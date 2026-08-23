<?php

namespace App\Models\Central;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $connection = 'central';

    protected $table = 'plans';

    protected $fillable = [
        'name',
        'slug',
        'price',
        'yearly_price',
        'billing_interval',
        'limits',
        'features',
        'is_active',
        'is_private',
        'is_trial',
        'trial_days',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'yearly_price' => 'decimal:2',
        'limits'       => 'array',
        'features'     => 'array',
        'is_active'    => 'boolean',
        'is_private'   => 'boolean',
        'is_trial'     => 'boolean',
        'trial_days'   => 'integer',
    ];

    /**
     * All configurable usage limits with their metadata.
     * Each key maps to a tenant-side Eloquent model for counting.
     */
    public const AVAILABLE_LIMITS = [
        'max_products'    => ['label' => 'Products',       'icon' => 'bi-box-seam',        'model' => \App\Models\Product::class],
        'max_users'       => ['label' => 'Users',          'icon' => 'bi-people',          'model' => \App\Models\User::class],
        'max_warehouses'  => ['label' => 'Warehouses',     'icon' => 'bi-building',        'model' => \App\Models\Warehouse::class],
        'max_customers'   => ['label' => 'Customers',      'icon' => 'bi-person-lines-fill', 'model' => \App\Models\Client::class],
        'max_suppliers'   => ['label' => 'Suppliers',      'icon' => 'bi-truck',           'model' => \App\Models\Provider::class],
        // Monthly-reset counter (not an all-time row count) — usage is tracked
        // via whatsapp_usages, so 'monthly' => true and no backing 'model'.
        'max_whatsapp_messages' => ['label' => 'WhatsApp Messages / month', 'icon' => 'bi-whatsapp', 'model' => null, 'monthly' => true],
    ];

    public const AVAILABLE_FEATURES = [
        'pos'                => ['label' => 'Point of Sale',          'icon' => 'bi-shop-window',      'description' => 'In-store POS terminal'],
        'online_orders'      => ['label' => 'Online Orders',          'icon' => 'bi-cart3',            'description' => 'E-commerce order management'],
        'hrm'                => ['label' => 'HR Management',          'icon' => 'bi-person-badge',     'description' => 'Employees, attendance, payroll'],
        'accounting'         => ['label' => 'Accounting',             'icon' => 'bi-calculator',       'description' => 'Financial accounting & bookkeeping'],
        'woocommerce'        => ['label' => 'WooCommerce',            'icon' => 'bi-bag-check',        'description' => 'WooCommerce store integration'],
        'transfers'          => ['label' => 'Transfers',              'icon' => 'bi-arrow-left-right', 'description' => 'Stock transfers between warehouses'],
        'service_maintenance'=> ['label' => 'Service & Maintenance',  'icon' => 'bi-wrench',           'description' => 'Service & maintenance management'],
        'ai_reports'         => ['label' => 'AI Reports',             'icon' => 'bi-robot',            'description' => 'AI-powered analytics & reports'],
    ];

    public function tenantSubscriptions()
    {
        return $this->hasMany(TenantSubscription::class, 'plan_id');
    }

    /**
     * Scope: only plans visible to the public (active + not private).
     */
    public function scopePublic($query)
    {
        return $query->where('is_active', true)->where('is_private', false);
    }

    /**
     * A plan is "free" when both monthly and yearly prices are zero.
     */
    public function isFree(): bool
    {
        return (float) $this->price <= 0
            && (float) ($this->yearly_price ?? 0) <= 0;
    }

    /**
     * Whether this plan offers a free trial period.
     */
    public function hasTrial(): bool
    {
        return ! $this->isFree() && $this->is_trial && $this->getTrialDays() > 0;
    }

    /**
     * Get the number of trial days for this plan.
     * Falls back to global config if per-plan value is not set.
     */
    public function getTrialDays(): int
    {
        if ($this->trial_days > 0) {
            return $this->trial_days;
        }

        return (int) config('tenancy.trial_days', 0);
    }

    /**
     * Whether this plan requires payment before provisioning.
     */
    public function requiresPayment(): bool
    {
        return ! $this->isFree() && ! $this->hasTrial();
    }

    /**
     * Get a specific limit value, or the default if not set.
     * Returns -1 for "unlimited".
     */
    public function getLimit(string $key, int $default = -1): int
    {
        $limits = $this->limits ?? [];

        if (!isset($limits[$key]) || $limits[$key] === '' || $limits[$key] === null) {
            return $default;
        }

        return (int) $limits[$key];
    }

    /**
     * Check if a feature is enabled on this plan.
     */
    public function hasFeature(string $key): bool
    {
        $features = $this->features ?? [];

        return in_array($key, $features, true);
    }

    /**
     * Check if a specific limit is set (not unlimited).
     */
    public function hasLimit(string $key): bool
    {
        return $this->getLimit($key) > 0;
    }

    /**
     * Get all configured limits as a formatted array.
     */
    public function getFormattedLimits(): array
    {
        $result = [];

        foreach (self::AVAILABLE_LIMITS as $key => $meta) {
            $value = $this->getLimit($key);
            $result[$key] = [
                'label' => $meta['label'],
                'icon' => $meta['icon'],
                'value' => $value,
                'display' => $value < 0 ? 'Unlimited' : number_format($value),
            ];
        }

        return $result;
    }

    /**
     * Get active feature keys.
     */
    public function getActiveFeatures(): array
    {
        $features = $this->features ?? [];
        $result = [];

        foreach (self::AVAILABLE_FEATURES as $key => $meta) {
            if (in_array($key, $features, true)) {
                $result[$key] = $meta;
            }
        }

        return $result;
    }

    /**
     * Count how many limits are configured (not unlimited).
     */
    public function getConfiguredLimitsCount(): int
    {
        $count = 0;

        foreach (array_keys(self::AVAILABLE_LIMITS) as $key) {
            if ($this->getLimit($key) > 0) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Get the price for a given billing cycle.
     * Falls back to monthly * 12 if yearly_price is not set.
     */
    public function getPriceForCycle(string $cycle = 'monthly'): float
    {
        if ($cycle === 'yearly') {
            return (float) ($this->yearly_price ?? $this->price * 12);
        }

        return (float) $this->price;
    }

    /**
     * Monthly savings percentage when paying yearly.
     */
    public function getYearlySavingsPercent(): int
    {
        $monthly12 = (float) $this->price * 12;
        $yearly = (float) ($this->yearly_price ?? $monthly12);

        if ($monthly12 <= 0) {
            return 0;
        }

        return (int) round((($monthly12 - $yearly) / $monthly12) * 100);
    }
}
