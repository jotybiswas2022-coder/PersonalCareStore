<?php

use App\Models\Setting;

if (!function_exists('settings')) {
    function settings(): ?Setting
    {
        return Setting::first();
    }
}

if (!function_exists('currencyFormat')) {
    function currencyFormat(float $amount): string
    {
        $setting = settings();
        $currency = $setting?->currency ?? 'BDT';
        return $currency . ' ' . number_format($amount, 2);
    }
}
