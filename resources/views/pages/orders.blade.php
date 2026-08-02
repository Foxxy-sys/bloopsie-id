@extends('layouts.app')

@push('styles')
    @vite(['resources/css/profile.css', 'resources/css/orders.css'])
@endpush

@section('title', 'My Orders — Bloopsie.id')

@section('content')

<div class="wrap">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a> / <a href="{{ route('profile.edit') }}">My Account</a> / <span>Orders</span>
  </div>

  <!-- Pembungkus baru yang berada di tengah tanpa sistem grid 2 kolom -->
  <div style="max-width: 900px; margin: 0 auto; padding: 20px 0 100px;">
    
    <!-- KONTEN UTAMA: DAFTAR PESANAN DINAMIS -->
    <main class="content-card">
      <div class="content-header">
        <div>
          <h2>My Orders</h2>
          <p>Lacak, lihat, dan kelola semua riwayat pesananmu di sini.</p>
        </div>
      </div>

      <div class="orders-container">
        
        @forelse($orders as $order)
            <!-- KARTU PESANAN DINAMIS -->
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <span class="order-id">Order #{{ $order->order_number ?? 'BLP-'.$order->id }}</span>
                        <span class="order-date">Placed on {{ $order->created_at->format('F d, Y') }}</span>
                    </div>
                    
                    @php
                        $statusClass = match(strtolower($order->status)) {
                            'completed' => 'status-completed',
                            'shipped' => 'status-shipped',
                            'processing' => 'status-processing',
                            default => 'status-processing'
                        };
                        $statusIcon = match(strtolower($order->status)) {
                            'completed' => '✔',
                            'shipped' => '🚚',
                            default => '⏳'
                        };
                    @endphp
                    <span class="order-status {{ $statusClass }}">
                        {{ $statusIcon }} {{ ucfirst($order->status) }}
                    </span>
                </div>
                
                <div class="order-body">
                    <div class="order-items">
                        @if($order->items && $order->items->count() > 0)
                            @php $firstItem = $order->items->first(); @endphp
                            
                            <img src="{{ $firstItem->product->cover_image ? asset('images/' . $firstItem->product->cover_image) : 'https://picsum.photos/seed/'.$firstItem->product->id.'/150/150' }}" alt="{{ $firstItem->product->name }}">
                            
                            <div class="item-info">
                                <h4>{{ $firstItem->product->name }}</h4>
                                <p>Qty: {{ $firstItem->quantity }}</p>
                                
                                @if($order->items->count() > 1)
                                    <p style="margin-top:4px; font-size: 0.8rem; font-weight: 700;">+ {{ $order->items->count() - 1 }} item lainnya</p>
                                @endif
                            </div>
                        @else
                            <p style="color: var(--muted); font-size: 0.9rem;">Detail produk tidak ditemukan.</p>
                        @endif
                    </div>
                    <div class="order-total">
                        <p>Total Amount</p>
                        <h3>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div class="order-footer">
                    @if(strtolower($order->status) == 'completed')
                        <button class="btn btn-outline" style="padding: 10px 20px;">View Invoice</button>
                        <button class="btn btn-primary" style="padding: 10px 20px;">Buy Again</button>
                    @else
                        <button class="btn btn-outline" style="padding: 10px 20px;">Track Order</button>
                        <button class="btn btn-primary" style="padding: 10px 20px;">View Details</button>
                    @endif
                </div>
            </div>
        @empty
            <!-- TAMPILAN JIKA BELUM ADA PESANAN -->
            <div style="text-align: center; padding: 40px 20px; background: var(--surface); border-radius: var(--radius-sm); border: 1.5px dashed rgba(74,58,58,.15);">
                <div style="font-size: 3rem; margin-bottom: 16px;">🛍️</div>
                <h3 style="font-family: var(--sans); font-weight: 700; margin-bottom: 8px;">Belum Ada Pesanan</h3>
                <p style="color: var(--muted); font-size: 0.95rem; margin-bottom: 24px;">Kamu belum pernah melakukan pesanan. Yuk mulai belanja koleksi Bloopsie!</p>
                <a href="{{ route('shop') }}" class="btn btn-primary">Mulai Belanja</a>
            </div>
        @endforelse

      </div>
    </main>

  </div>
</div>

@endsection