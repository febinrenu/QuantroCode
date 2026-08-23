<?php

namespace App\Services;

use App\Models\Central\GeneralSetting;
use Illuminate\Support\Facades\Log;

/**
 * Sends SMS from the platform (central) to tenants — e.g. subscription
 * reminders. Unlike SmsOtpSender (which resolves the gateway from the
 * tenant's own settings), the gateway here is chosen by the super admin in
 * the central settings. Provider credentials are shared via .env.
 */
class CentralSmsSender
{
    /**
     * Resolve the platform's configured SMS gateway title, or null when SMS
     * is not configured centrally.
     */
    public static function gateway(): ?string
    {
        $gateway = GeneralSetting::instance()->sms_gateway;

        $gateway = is_string($gateway) ? trim($gateway) : '';

        return $gateway !== '' ? $gateway : null;
    }

    /**
     * Whether central SMS can be sent (a gateway is configured).
     */
    public static function isConfigured(): bool
    {
        return static::gateway() !== null;
    }

    /**
     * Send an SMS to a tenant. Returns true on success, false on any failure
     * or misconfiguration (never throws — callers log via the audit trail).
     */
    public static function send(string $toPhone, string $message): bool
    {
        $toPhone = trim($toPhone);
        $gateway = static::gateway();

        if ($toPhone === '' || $gateway === null || trim($message) === '') {
            return false;
        }

        try {
            app(SmsOtpSender::class)->sendVia($gateway, $toPhone, $message);

            Log::info("CentralSms: sent via [{$gateway}] to {$toPhone}");

            return true;
        } catch (\Throwable $e) {
            Log::error("CentralSms: failed to send via [{$gateway}] to {$toPhone} — {$e->getMessage()}");

            return false;
        }
    }
}
