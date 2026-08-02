<?php

namespace App\Http\Controllers;

use App\Models\Collection; // Sesuaikan dengan nama Model kamu
use Carbon\Carbon;

class CollectionController extends Controller
{
    public function index()
    {
        // 1. Ambil koleksi terbaru untuk "Current Collection"
        // Asumsi: Koleksi terbaru adalah yang terakhir diinput atau yang statusnya 'active'
        $currentCollection = Collection::latest('created_at')->first();

        // 2. Ambil sisanya untuk "Archive", lalu kelompokkan berdasarkan Tahun
        // Gunakan 'withCount' agar kita tahu jumlah produk di dalamnya
        $archives = [];
        if ($currentCollection) {
            $archives = Collection::where('id', '!=', $currentCollection->id)
                ->withCount('products') // Menghitung otomatis relasi produk
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy(function($val) {
                    // Kelompokkan data berdasarkan tahun dibuatnya
                    return Carbon::parse($val->created_at)->format('Y'); 
                });
        }

        return view('pages.collections', compact('currentCollection', 'archives'));
    }

    public function show($id)
    {
        // 1. Ambil koleksi berdasarkan ID
        $collection = Collection::with('products')->findOrFail($id);

        return view('pages.collection_detail', compact('collection'));
    }
    public function collections()
    {
        // 1. Ambil koleksi terbaru untuk "Current Collection"
        // Asumsi: Koleksi terbaru adalah yang terakhir diinput atau yang statusnya 'active'
        $currentCollection = Collection::latest('created_at')->first();

        // 2. Ambil sisanya untuk "Archive", lalu kelompokkan berdasarkan Tahun
        // Gunakan 'withCount' agar kita tahu jumlah produk di dalamnya
        $archives = [];
        if ($currentCollection) {
            $archives = Collection::where('id', '!=', $currentCollection->id)
                ->withCount('products') // Menghitung otomatis relasi produk
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy(function($val) {
                    // Kelompokkan data berdasarkan tahun dibuatnya
                    return Carbon::parse($val->created_at)->format('Y'); 
                });
        }

        return view('pages.collections', compact('currentCollection', 'archives'));
    }
}