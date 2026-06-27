<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        if (!$setting) {
            $setting = Setting::create([
                'currency' => 'BDT',
                'delivery_charge_inside' => 0,
                'delivery_charge_outside' => 0,
                'vat_percentage' => 0,
            ]);
        }
        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'currency'               => 'required|string|in:BDT,USD,INR',
            'delivery_charge_inside'  => 'required|numeric|min:0',
            'delivery_charge_outside' => 'required|numeric|min:0',
            'vat_percentage'         => 'required|numeric|min:0|max:100',
            'contact_phone'          => 'nullable|string|max:30',
            'contact_email'          => 'nullable|email|max:255',
            'contact_address'        => 'nullable|string|max:500',
            'contact_hours'          => 'nullable|string|max:255',
            'newsletter_heading'     => 'nullable|string|max:255',
            'newsletter_text'        => 'nullable|string|max:500',
            'newsletter_placeholder' => 'nullable|string|max:255',
            'newsletter_button_text' => 'nullable|string|max:100',
            'newsletter_enabled'     => 'nullable|boolean',
        ]);

        $validated['newsletter_enabled'] = $request->boolean('newsletter_enabled');

        $setting = Setting::first();
        if ($setting) {
            $setting->update($validated);
        } else {
            Setting::create($validated);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
