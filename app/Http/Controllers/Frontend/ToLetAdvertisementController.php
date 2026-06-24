<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ToLetAdvertisement;
use Illuminate\Http\Request;

class ToLetAdvertisementController extends Controller
{
    public function show($id)
    {
        $property = ToLetAdvertisement::approved()->findOrFail($id);
        return view('frontend.property-detail', compact('property'));
    }

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

    public function postProperty()
    {
        return view('frontend.post-property');
    }

    public function storePostProperty(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'property_type' => 'required|string|max:255',
            'listing_type' => 'nullable|string|max:255',
            'division' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'area_location' => 'required|string|max:255',
            'full_address' => 'required|string',
            'monthly_rent' => 'required|numeric|min:0',
            'security_deposit' => 'nullable|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'floor_number' => 'nullable|integer|min:0',
            'total_floors' => 'nullable|integer|min:0',
            'property_size' => 'nullable|numeric|min:0',
            'furnishing' => 'nullable|string|max:255',
            'tenant_preference' => 'required|string|max:255',
            'available_from' => 'required|date',
            'description' => 'nullable|string',
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'preferred_contact_method' => 'nullable|string|max:255',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Handle image uploads (max 5)
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

        return redirect()->route('post-property')
            ->with('success', 'Your property has been posted successfully! It will be reviewed by our team.');
    }
}
