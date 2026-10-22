<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('items')
            ->when($request->get('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('order_number', 'like', "%{$search}%")
                      ->orWhere('guest_email', 'like', "%{$search}%");
                });
            })
            ->when($request->get('date_from'), function ($query, $date) {
                $query->whereDate('created_at', '>=', $date);
            })
            ->when($request->get('date_to'), function ($query, $date) {
                $query->whereDate('created_at', '<=', $date);
            })
            ->latest()
            ->paginate(20);

        $totalOrders = Order::count();
        $pendingCount = Order::where('status', 'pending')->count();
        $processingCount = Order::where('status', 'processing')->count();
        $shippedCount = Order::where('status', 'shipped')->count();
        $deliveredCount = Order::where('status', 'delivered')->count();
        $cancelledCount = Order::where('status', 'cancelled')->count();
        $unpaidCount = Order::where('payment_status', 'unpaid')->count();
        $paidCount = Order::where('payment_status', 'paid')->count();
        $approvedCount = Order::where('payment_status', 'approved')->count();
        $rejectedCount = Order::where('payment_status', 'rejected')->count();

        return view('admin.orders.index', compact(
            'orders', 'totalOrders', 'pendingCount', 'processingCount',
            'shippedCount', 'deliveredCount', 'cancelledCount',
            'unpaidCount', 'paidCount', 'approvedCount', 'rejectedCount'
        ));
    }

    public function show($id)
    {
        $order = Order::with(['items', 'shippingAddress'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);

        if (in_array($order->status, ['delivered', 'cancelled'])) {
            return redirect()->route('admin.orders.show', $order->id)
                ->with('error', 'Cannot change status. Order is already ' . $order->status . '.');
        }

        $updateData = $validated;
        if ($validated['status'] === 'cancelled') {
            $updateData['cancelled_by'] = 'admin';
        }

        $order->update($updateData);

        if ($validated['status'] === 'delivered') {
            $order->load('items');
            foreach ($order->items as $item) {
                Product::where('id', $item->product_id)
                    ->where('stock_quantity', '>=', $item->quantity)
                    ->decrement('stock_quantity', $item->quantity);
            }
        }

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Order status updated successfully.');
    }

    public function approvePayment($id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'payment_status' => 'approved',
            'status' => 'processing',
        ]);

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Payment approved successfully.');
    }

    public function rejectPayment($id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'payment_status' => 'rejected',
            'status' => 'cancelled',
            'cancelled_by' => 'admin',
        ]);

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Payment rejected and order cancelled.');
    }
}
