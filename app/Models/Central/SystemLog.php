<?php

declare(strict_types=1);

namespace App\Models\Central;

use App\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class SystemLog extends Model
{
    protected $connection = 'central';

    protected $table = 'system_logs';

    public const TYPE_DNS          = 'dns';
    public const TYPE_SSL          = 'ssl';
    public const TYPE_DATABASE     = 'database';
    public const TYPE_PROVISIONING = 'provisioning';
    public const TYPE_EXCEPTION    = 'exception';
    public const TYPE_GENERAL      = 'general';

    public const SEVERITY_INFO     = 'info';
    public const SEVERITY_WARNING  = 'warning';
    public const SEVERITY_CRITICAL = 'critical';

    public const STATUS_UNRESOLVED = 'unresolved';
    public const STATUS_RESOLVED   = 'resolved';

    protected $fillable = [
        'tenant_id',
        'type',
        'severity',
        'message',
        'context',
        'suggested_cause',
        'source',
        'status',
        'resolved_by',
        'resolved_at',
        'resolution_note',
        'occurred_at',
    ];

    protected $casts = [
        'context'     => 'array',
        'resolved_at' => 'datetime',
        'occurred_at' => 'datetime',
    ];

    public static function types(): array
    {
        return [
            self::TYPE_DNS          => 'DNS',
            self::TYPE_SSL          => 'SSL',
            self::TYPE_DATABASE     => 'Database',
            self::TYPE_PROVISIONING => 'Provisioning',
            self::TYPE_EXCEPTION    => 'Exception',
            self::TYPE_GENERAL      => 'General',
        ];
    }

    public static function severities(): array
    {
        return [
            self::SEVERITY_INFO     => 'Info',
            self::SEVERITY_WARNING  => 'Warning',
            self::SEVERITY_CRITICAL => 'Critical',
        ];
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }

    public function resolver()
    {
        return $this->belongsTo(CentralUser::class, 'resolved_by');
    }

    public function scopeUnresolved(Builder $q): Builder
    {
        return $q->where('status', self::STATUS_UNRESOLVED);
    }

    public function scopeResolved(Builder $q): Builder
    {
        return $q->where('status', self::STATUS_RESOLVED);
    }

    public function scopeCritical(Builder $q): Builder
    {
        return $q->where('severity', self::SEVERITY_CRITICAL);
    }

    public function isResolved(): bool
    {
        return $this->status === self::STATUS_RESOLVED;
    }

    /**
     * Capture a log entry. Safe to call from anywhere; never throws.
     * If the central DB or table is unavailable, silently falls back to file log.
     */
    public static function capture(array $attributes): ?self
    {
        try {
            $attributes = array_merge([
                'type'        => self::TYPE_GENERAL,
                'severity'    => self::SEVERITY_WARNING,
                'status'      => self::STATUS_UNRESOLVED,
                'occurred_at' => now(),
            ], $attributes);

            return static::create($attributes);
        } catch (Throwable $e) {
            @\Log::warning('[system_logs capture failed] ' . $e->getMessage(), [
                'attrs' => $attributes,
            ]);
            return null;
        }
    }

    /**
     * Convert a Throwable into a SystemLog entry.
     */
    public static function fromThrowable(Throwable $e, array $extra = []): ?self
    {
        $defaults = [
            'type'            => self::TYPE_EXCEPTION,
            'severity'        => self::SEVERITY_CRITICAL,
            'message'         => mb_substr($e->getMessage() ?: get_class($e), 0, 1000),
            'context'         => [
                'exception' => get_class($e),
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
                'trace'     => collect(explode("\n", $e->getTraceAsString()))->take(15)->implode("\n"),
            ],
            'suggested_cause' => null,
        ];

        return static::capture(array_merge($defaults, $extra));
    }
}
