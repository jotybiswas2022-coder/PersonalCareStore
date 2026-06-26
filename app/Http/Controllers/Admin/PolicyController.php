<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function index()
    {
        $policies = Policy::paginate(20);
        return view('admin.policies.index', compact('policies'));
    }

    public function create()
    {
        return view('admin.policies.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'      => 'required|string|max:50|unique:policies,type',
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Policy::create($validated);

        return redirect()->route('admin.policies.index')
            ->with('success', 'Policy page created successfully.');
    }

    public function edit($id)
    {
        $policy = Policy::findOrFail($id);
        return view('admin.policies.form', compact('policy'));
    }

    public function update(Request $request, $id)
    {
        $policy = Policy::findOrFail($id);

        $validated = $request->validate([
            'type'      => 'required|string|max:50|unique:policies,type,' . $id,
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $policy->update($validated);

        return redirect()->route('admin.policies.index')
            ->with('success', 'Policy page updated successfully.');
    }

    public function destroy($id)
    {
        $policy = Policy::findOrFail($id);
        $policy->delete();

        return redirect()->route('admin.policies.index')
            ->with('success', 'Policy page deleted successfully.');
    }
}
