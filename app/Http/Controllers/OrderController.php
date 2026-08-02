<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; // Pastikan model Order sudah ada

class OrderController extends Controller
{
    public function index()
    {
        // Mengambil semua pesanan milik user yang sedang login
        // 'items.product' memanggil relasi agar data produk di dalam pesanan ikut terbawa
        $orders = Auth::user()->orders()->with('items.product')->latest()->get();

        return view('pages.orders', compact('orders'));
    }
}