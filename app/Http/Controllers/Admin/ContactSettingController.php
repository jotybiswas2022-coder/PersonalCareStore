<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactSettingController extends Controller
{
    public function index()
    {
        $settings = settings();
        return view('admin.contact-setting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'contact_phone' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_address' => 'nullable|string',
            'contact_hours' => 'nullable|string|max:255',
            'newsletter_heading' => 'nullable|string|max:255',
            'newsletter_text' => 'nullable|string',
            'newsletter_placeholder' => 'nullable|string|max:255',
            'newsletter_button_text' => 'nullable|string|max:100',
            'newsletter_enabled' => 'nullable|boolean',
        ]);

        $validated['newsletter_enabled'] = $request->has('newsletter_enabled');

        $setting = settings();
        $setting->update($validated);

        return redirect()->route('admin.contact-setting.index')
            ->with('success', 'Contact information & newsletter settings updated successfully.');
    }
}
