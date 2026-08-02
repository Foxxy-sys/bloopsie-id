<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Collection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        // Search by nama produk
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        // Filter kategori (checkbox, bisa banyak dipilih)
        if ($request->filled('category')) {
            $query->whereIn('category_id', $request->category);
        }

        // Filter bulan rilis (checkbox, bisa banyak dipilih) — angka 1-12
        if ($request->filled('month')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->month as $m) {
                    $q->orWhereMonth('release_date', (int) $m);
                }
            });
        }

        // Filter ketersediaan stok
        if ($request->filled('availability')) {
            $query->where(function ($q) use ($request) {
                if (in_array('in_stock', $request->availability)) {
                    $q->orWhere('stock', '>', 0);
                }
                if (in_array('sold_out', $request->availability)) {
                    $q->orWhere('stock', '<=', 0);
                }
            });
        }

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'price-asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
            case 'az':
                $query->orderBy('name', 'asc');
                break;
            case 'bestseller':
                $query->orderByDesc('featured')->orderByDesc('created_at');
                break;
            default: // newest
                $query->orderByDesc('release_date')->orderByDesc('created_at');
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::orderBy('name')->get();

        // Daftar bulan yang benar-benar ada produknya, plus jumlah produknya
        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $months = Product::selectRaw('MONTH(release_date) as month_num, COUNT(*) as total')
            ->whereNotNull('release_date')
            ->groupBy('month_num')
            ->orderBy('month_num')
            ->get()
            ->map(function ($row) use ($monthNames) {
                return [
                    'value' => $row->month_num,
                    'label' => $monthNames[$row->month_num] ?? $row->month_num,
                    'count' => $row->total,
                ];
            });

        return view('pages.shop', compact('products', 'categories', 'months'));
    }

    // Pastikan model Product sudah di-import di atas: use App\Models\Product;

    public function show($id)
    {
        // Cari produk berdasarkan ID, jika tidak ada akan muncul error 404
        $product = Product::findOrFail($id);
        
        // Kirim data $product ke view product-detail
        return view('pages.product-detail', compact('product'));
    }
    public function collections()
    {
        // 1. Ganti Category menjadi Collection, dan tarik relasi products-nya
        $currentCollection = Collection::with('products')->latest('created_at')->first();

        $archives = [];
        if ($currentCollection) {
            // 2. Gunakan Collection lagi di sini
            $archives = Collection::where('id', '!=', $currentCollection->id)
                ->with('products')
                ->withCount('products') 
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy(function($val) {
                    return Carbon::parse($val->created_at)->format('Y'); 
                });
        }

        return view('pages.collections', compact('currentCollection', 'archives'));
    }
}