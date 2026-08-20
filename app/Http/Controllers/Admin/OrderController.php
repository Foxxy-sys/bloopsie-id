<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private array $statuses = ['pending', 'processing', 'packed', 'shipped', 'delivered', 'cancelled'];

    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $query->where(function ($sub) use ($request) {
                $sub->where('invoice', 'like', '%'.$request->q.'%')
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%'.$request->q.'%'));
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'statuses' => $this->statuses,
        ]);
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product');

        return view('admin.orders.show', [
            'order' => $order,
            'statuses' => $this->statuses,
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:'.implode(',', $this->statuses),
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status order berhasil diperbarui.');
    }
}