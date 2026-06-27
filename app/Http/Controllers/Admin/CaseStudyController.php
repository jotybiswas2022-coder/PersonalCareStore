<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\CaseStudy;

class CaseStudyController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $caseStudies = CaseStudy::query()
            ->when($query, function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('client', 'like', "%{$query}%")
                  ->orWhere('category', 'like', "%{$query}%")
                  ->orWhere('technologies', 'like', "%{$query}%");
            })
            ->orderBy('sort_order')
            ->get();

        if ($request->ajax()) {
            $html = view('backend.casestudy._table_rows', compact('caseStudies'))->render();
            return response()->json([
                'html'  => $html,
                'count' => $caseStudies->count(),
                'query' => $query,
            ]);
        }

        return view('backend.casestudy.index', compact('caseStudies', 'query'));
    }

    public function create()
    {
        return view('backend.casestudy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'client'       => 'nullable|string|max:255',
            'category'     => 'nullable|string|max:255',
            'problem'      => 'required|string',
            'solution'     => 'required|string',
            'result'       => 'required|string',
            'technologies' => 'nullable|string|max:500',
            'url'          => 'nullable|url|max:500',
            'image'        => 'nullable|image|max:2048',
            'sort_order'   => 'nullable|integer|min:0',
        ]);

        $data = $request->only([
            'title', 'client', 'category', 'problem', 'solution', 'result',
            'technologies', 'url', 'sort_order'
        ]);

        $data['is_active'] = $request->has('is_active') ? true : false;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('case-studies', 'public');
        }

        CaseStudy::create($data);

        return redirect()->route('admin.casestudies.index')
            ->with('success', 'Case study created successfully!');
    }

    public function edit($id)
    {
        $caseStudy = CaseStudy::findOrFail($id);
        return view('backend.casestudy.edit', compact('caseStudy'));
    }

    public function update(Request $request, $id)
    {
        $caseStudy = CaseStudy::findOrFail($id);

        $request->validate([
            'title'        => 'required|string|max:255',
            'client'       => 'nullable|string|max:255',
            'category'     => 'nullable|string|max:255',
            'problem'      => 'required|string',
            'solution'     => 'required|string',
            'result'       => 'required|string',
            'technologies' => 'nullable|string|max:500',
            'url'          => 'nullable|url|max:500',
            'image'        => 'nullable|image|max:2048',
            'sort_order'   => 'nullable|integer|min:0',
        ]);

        $data = $request->only([
            'title', 'client', 'category', 'problem', 'solution', 'result',
            'technologies', 'url', 'sort_order'
        ]);

        $data['is_active'] = $request->has('is_active') ? true : false;

        if ($request->hasFile('image')) {
            if ($caseStudy->image && Storage::disk('public')->exists($caseStudy->image)) {
                Storage::disk('public')->delete($caseStudy->image);
            }
            $data['image'] = $request->file('image')->store('case-studies', 'public');
        }

        $caseStudy->update($data);

        return redirect()->route('admin.casestudies.index')
            ->with('success', 'Case study updated successfully!');
    }

    public function destroy($id)
    {
        $caseStudy = CaseStudy::findOrFail($id);

        if ($caseStudy->image && Storage::disk('public')->exists($caseStudy->image)) {
            Storage::disk('public')->delete($caseStudy->image);
        }

        $caseStudy->delete();

        return redirect()->route('admin.casestudies.index')
            ->with('success', 'Case study deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $caseStudy = CaseStudy::findOrFail($id);
        $caseStudy->update(['is_active' => !$caseStudy->is_active]);

        return redirect()->route('admin.casestudies.index')
            ->with('success', 'Case study status updated!');
    }
}
