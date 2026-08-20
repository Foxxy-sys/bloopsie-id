<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products'   => Product::count(),
            'categories' => Category::count(),
            'orders'     => Order::count(),
            'customers'  => User::where('role', 'customer')->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        $latestOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestOrders'));
    }
}