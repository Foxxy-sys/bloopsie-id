<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil nama bulan saat ini (contoh: "July")
        $currentMonthName = now()->format('F');
        
        // 2. Cari kotak eksklusif khusus bulan ini (mencocokkan tahun-bulan rilis)
        $currentMonth = now()->format('Y-m');
        $currentBox = Product::with('category')->where('release_date', 'like', $currentMonth . '%')->first();

        // 3. Ambil 4 produk terbaru untuk ditampilkan di bagian "Loved This Month"
        $featuredProducts = Product::latest()->take(4)->get();

        // Hitung sisa hari sampai akhir bulan ini untuk label "Days Left"
        $daysLeft = now()->endOfMonth()->diffInDays(now());

        return view('pages.home', compact('currentBox', 'featuredProducts', 'currentMonthName', 'daysLeft'));
    }
}