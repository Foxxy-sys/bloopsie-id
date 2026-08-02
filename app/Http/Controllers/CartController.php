<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem; // Pastikan model ini di-import
use App\Models\Product;  // Pastikan model ini di-import
use Illuminate\Support\Facades\Auth; // Untuk mengecek user login

class CartController extends Controller
{
    // Fungsi index() yang mungkin sudah Anda miliki untuk melihat keranjang
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Cari keranjang user
        $cart = \App\Models\Cart::with('items.product')->where('user_id', $user->id)->first();
        $cartItems = $cart ? $cart->items : collect();

        return view('pages.cart', compact('cartItems')); 
    }

    // --- TAMBAHKAN FUNGSI INI ---
    public function add(Request $request)
    {
        // 1. Validasi data yang dikirim dari form
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'action' => 'required|in:cart,buy'
        ]);

        // 2. Pastikan pelanggan sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memasukkan barang ke keranjang.');
        }

        $user = Auth::user();
        $productId = $request->product_id;
        $quantity = $request->quantity;
        $action = $request->action;

        // 3. Cek ketersediaan stok produk
        $product = Product::findOrFail($productId);
        if ($product->stock < $quantity) {
            return back()->with('error', 'Mohon maaf, stok tidak mencukupi.');
        }

        // --- BAGIAN YANG DIPERBAIKI MULAI DARI SINI ---

        // 4a. Cari keranjang milik user, jika belum punya maka buatkan otomatis
        $cart = \App\Models\Cart::firstOrCreate([
            'user_id' => $user->id
        ]);

        // 4b. Cek apakah produk sudah ada di dalam keranjang INI (menggunakan cart_id)
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            // Jika sudah ada, tambahkan quantity-nya
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Jika belum ada, buat data item baru menggunakan cart_id
            CartItem::create([
                'cart_id' => $cart->id,     // <-- Diubah dari user_id menjadi cart_id
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }
        
        // --- BATAS BAGIAN YANG DIPERBAIKI ---

        // 5. Arahkan halaman sesuai tombol yang diklik
        if ($action === 'buy') {
            return redirect()->route('cart')->with('success', 'Produk siap dibeli!');
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
    public function checkout()
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Ambil data keranjang
        $cart = \App\Models\Cart::with('items.product')->where('user_id', $user->id)->first();
        $cartItems = $cart ? $cart->items : collect();

        // Cegah user masuk ke halaman checkout jika keranjangnya kosong
        if ($cartItems->count() == 0) {
            return redirect()->route('cart')->with('error', 'Keranjang belanjamu masih kosong.');
        }

        // Hitung ulang subtotal untuk ditampilkan di halaman checkout
        $subtotal = 0;
        foreach($cartItems as $item) {
            if($item->product) {
                $subtotal += $item->product->price * $item->quantity;
            }
        }

        return view('pages.checkout', compact('cartItems', 'subtotal'));
    }
    // Fungsi untuk mengubah quantity via AJAX
    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        
        $cartItem = \App\Models\CartItem::findOrFail($id);
        
        // Pastikan item ini benar-benar milik user yang sedang login
        if ($cartItem->cart->user_id == Auth::id()) {
            $cartItem->update(['quantity' => $request->quantity]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }

    // Fungsi untuk menghapus item via AJAX
    public function remove($id)
    {
        $cartItem = \App\Models\CartItem::findOrFail($id);

        if ($cartItem->cart->user_id == Auth::id()) {
            $cartItem->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }
}