<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ToLetAdvertisement;
use Illuminate\Http\Request;

class ToLetAdvertisementController extends Controller
{
    public function create()
    {
        return view('frontend.to-let.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'property_type' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'area_location' => 'required|string|max:255',
            'full_address' => 'required|string',
            'monthly_rent' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'property_size' => 'nullable|numeric|min:0',
            'tenant_preference' => 'required|string|max:255',
            'available_from' => 'required|date',
            'description' => 'nullable|string',
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:255',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Handle image uploads (max 5, min 1 required)
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if (count($imagePaths) < 5) {
                    $imagePaths[] = $image->store('to-let', 'public');
                }
            }
        }

        $validated['images'] = !empty($imagePaths) ? $imagePaths : null;
        $validated['status'] = 'pending';

        ToLetAdvertisement::create($validated);

        return redirect()->route('to-let.create')
            ->with('success', 'Your advertisement has been submitted successfully! It will be reviewed by our team.');
    }
}
