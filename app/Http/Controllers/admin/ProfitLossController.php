<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfitLossController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->whereIn('orders.status', ['delivered', 'shipped', 'processing']);

        if ($request->filled('date_from')) {
            $baseQuery->whereDate('orders.created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $baseQuery->whereDate('orders.created_at', '<=', $request->date_to);
        }

        $summary = (clone $baseQuery)->select(
            DB::raw('SUM(order_items.product_price * order_items.quantity) as total_revenue'),
            DB::raw('SUM(COALESCE(products.price, 0) * order_items.quantity) as total_base_cost'),
            DB::raw('SUM(order_items.quantity) as total_qty'),
            DB::raw('COUNT(DISTINCT orders.id) as total_orders')
        )->first();

        $items = (clone $baseQuery)
            ->select(
                'order_items.id',
                'order_items.order_id',
                'order_items.product_name',
                'order_items.product_price',
                'order_items.quantity',
                'order_items.subtotal',
                'orders.order_number',
                'orders.created_at as order_date',
                'orders.status',
                'products.price as base_price',
                'products.sale_price',
                'products.images',
                'products.id as product_id'
            )
            ->orderBy('orders.created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.profit-loss.index', compact('items', 'summary'));
    }
}
