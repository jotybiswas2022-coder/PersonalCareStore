<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Review;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalCustomers = User::where('is_admin', false)->count();
        $totalReviews = Review::count();

        // Today's stats
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::whereDate('created_at', today())
            ->whereIn('payment_status', ['paid', 'approved'])
            ->sum('total');

        // Low stock products
        $lowStockProducts = Product::where('stock_quantity', '<=', 5)->count();

        // Order status counts
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        // Payment stats
        $paymentUnpaid = Order::where('payment_status', 'unpaid')->count();
        $paymentPending = Order::where('payment_status', 'pending')->count();
        $paymentPaid = Order::where('payment_status', 'paid')->count();
        $paymentApproved = Order::where('payment_status', 'approved')->count();
        $paymentRejected = Order::where('payment_status', 'rejected')->count();

        // Profit & Loss stats
        $plStats = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->whereIn('orders.status', ['delivered', 'shipped', 'processing'])
            ->select(
                DB::raw('SUM(order_items.product_price * order_items.quantity) as total_revenue'),
                DB::raw('SUM(COALESCE(products.price, 0) * order_items.quantity) as total_base_cost'),
                DB::raw('SUM(order_items.quantity) as total_qty')
            )
            ->first();

        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentProducts = Product::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $unreadMessages = ContactMessage::whereNull('admin_reply')->count();

        return view('admin.dashboard', compact(
            'totalProducts', 'totalCategories', 'totalOrders', 'totalCustomers', 'totalReviews',
            'todayOrders', 'todayRevenue',
            'lowStockProducts',
            'pendingOrders', 'processingOrders', 'shippedOrders', 'deliveredOrders', 'cancelledOrders',
            'paymentUnpaid', 'paymentPending', 'paymentPaid', 'paymentApproved', 'paymentRejected',
            'plStats',
            'recentOrders', 'recentProducts',
            'unreadMessages'
        ));
    }
}
