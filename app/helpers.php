<?php

use App\Models\Setting;

if (!function_exists('settings')) {
    function settings(): ?Setting
    {
        return Setting::first();
    }
}

