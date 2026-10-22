<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentDetail;
use Illuminate\Http\Request;

class PaymentDetailController extends Controller
{
    public function index()
    {
        $query = PaymentDetail::query();

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('bank_name', 'like', "%{$search}%")
                  ->orWhere('account_number', 'like', "%{$search}%")
                  ->orWhere('account_holder', 'like', "%{$search}%");
            });
        }

        $paymentDetails = $query->latest()->paginate(20);

        $totalCount = PaymentDetail::count();
        $activeCount = PaymentDetail::where('is_active', true)->count();
        $inactiveCount = PaymentDetail::where('is_active', false)->count();

        if (request()->wantsJson()) {
            return response()->json([
                'html' => view('admin.payment-details._table', compact('paymentDetails'))->render(),
                'pagination' => $paymentDetails->links()->render(),
            ]);
        }

        return view('admin.payment-details.index', compact('paymentDetails', 'totalCount', 'activeCount', 'inactiveCount'));
    }

    public function create()
    {
        return view('admin.payment-details.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        PaymentDetail::create($validated);

        return redirect()->route('admin.payment-details.index')
            ->with('success', 'Payment details created successfully.');
    }

    public function edit(PaymentDetail $paymentDetail)
    {
        return view('admin.payment-details.edit', compact('paymentDetail'));
    }

    public function update(Request $request, PaymentDetail $paymentDetail)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $paymentDetail->update($validated);

        return redirect()->route('admin.payment-details.index')
            ->with('success', 'Payment details updated successfully.');
    }

    public function destroy(PaymentDetail $paymentDetail)
    {
        $paymentDetail->delete();
        return redirect()->route('admin.payment-details.index')
            ->with('success', 'Payment details deleted successfully.');
    }
}
