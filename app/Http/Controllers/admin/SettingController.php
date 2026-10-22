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
            'currency' => 'required|string|in:BDT,USD,INR',
            'delivery_charge_inside' => 'required|numeric|min:0',
            'delivery_charge_outside' => 'required|numeric|min:0',
            'vat_percentage' => 'required|numeric|min:0|max:100',
        ]);

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
