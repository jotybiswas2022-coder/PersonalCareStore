<?php

use App\Models\Setting;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

if (!function_exists('settings')) {
    function settings(): ?Setting
    {
        return Setting::first();
    }
}

if (!function_exists('sendNotificationEmail')) {
    /**
     * Send a notification email without ever breaking the customer-facing
     * request: mail transport problems are logged and swallowed.
     */
    function sendNotificationEmail(?string $to, Mailable $mailable): void
    {
        if (! $to) {
            return;
        }

        try {
            Mail::to($to)->send($mailable);
        } catch (\Throwable $e) {
            Log::error('Notification email failed', [
                'to' => $to,
                'mailable' => $mailable::class,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

if (!function_exists('currencyFormat')) {
    function currencyFormat($amount): string
    {
        if ($amount === null) {
            $amount = 0;
        }
        $amount = (float) $amount;
        $setting = settings();
        $currency = $setting?->currency ?? 'BDT';
        return $currency . ' ' . number_format($amount, 2);
    }
}
