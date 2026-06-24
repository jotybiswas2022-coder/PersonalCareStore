<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ToLetAdvertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToLetAdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = ToLetAdvertisement::latest()->paginate(20);
        $total = ToLetAdvertisement::count();
        $pending = ToLetAdvertisement::pending()->count();
        $approved = ToLetAdvertisement::approved()->count();
        $rejected = ToLetAdvertisement::rejected()->count();

        return view('admin.to-let.index', compact(
            'advertisements',
            'total',
            'pending',
            'approved',
            'rejected'
        ));
    }

    public function create()
    {
        return view('admin.to-let.create');
    }

    public function store(Request $request)
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
            'status' => 'nullable|in:pending,approved,rejected',
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
        $validated['status'] = $validated['status'] ?? 'pending';

        ToLetAdvertisement::create($validated);

        return redirect()->route('admin.to-let.index')
            ->with('success', 'Advertisement created successfully.');
    }

    public function edit($id)
    {
        $advertisement = ToLetAdvertisement::findOrFail($id);
        return view('admin.to-let.edit', compact('advertisement'));
    }

    public function update(Request $request, $id)
    {
        $advertisement = ToLetAdvertisement::findOrFail($id);

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
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'nullable|in:pending,approved,rejected',
            'admin_note' => 'nullable|string',
        ]);

        // Handle image uploads
        $imagePaths = $advertisement->images ?? [];

        // Handle image deletions
        if ($request->filled('delete_images')) {
            $deleteIndices = array_map('intval', explode(',', $request->delete_images));
            foreach ($deleteIndices as $idx) {
                if (isset($imagePaths[$idx])) {
                    Storage::disk('public')->delete($imagePaths[$idx]);
                    unset($imagePaths[$idx]);
                }
            }
            $imagePaths = array_values($imagePaths); // re-index
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if (count($imagePaths) < 5) {
                    $imagePaths[] = $image->store('to-let', 'public');
                }
            }
        }

        $validated['images'] = $imagePaths;

        if (!isset($validated['status'])) {
            $validated['status'] = $advertisement->status;
        }

        $advertisement->update($validated);

        return redirect()->route('admin.to-let.index')
            ->with('success', 'Advertisement updated successfully.');
    }

    public function destroy($id)
    {
        $advertisement = ToLetAdvertisement::findOrFail($id);

        // Delete images
        if ($advertisement->images) {
            foreach ($advertisement->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $advertisement->delete();

        return redirect()->route('admin.to-let.index')
            ->with('success', 'Advertisement deleted successfully.');
    }

    public function approve($id)
    {
        $advertisement = ToLetAdvertisement::findOrFail($id);
        $advertisement->update(['status' => 'approved']);

        return redirect()->route('admin.to-let.index')
            ->with('success', 'Advertisement approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $advertisement = ToLetAdvertisement::findOrFail($id);
        $advertisement->update([
            'status' => 'rejected',
            'admin_note' => $request->input('admin_note'),
        ]);

        return redirect()->route('admin.to-let.index')
            ->with('success', 'Advertisement rejected successfully.');
    }
}
