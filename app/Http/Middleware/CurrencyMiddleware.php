<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Session;

class CurrencyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah mata uang sudah disimpan di session.
        // Jika sudah, langsung lewati agar website tetap ngebut!
        if (!Session::has('currency')) {
            
            $countryCode = 'ID'; // Default kita asumsikan Indonesia

            // LOGIKA 1: Cek Cloudflare (Persiapan untuk nanti saat sudah online/hosting)
            if ($request->hasHeader('CF-IPCountry')) {
                $countryCode = $request->header('CF-IPCountry');
            } 
            // LOGIKA 2: Cek IP Geolocation (Untuk testing di localhost sekarang)
            else {
                $ip = $request->ip();
                
                // CATATAN PENTING: Karena kamu menjalankan di laptop (localhost), IP-nya pasti 127.0.0.1.
                // Sistem tidak bisa melacak lokasi localhost. 
                // Jadi untuk TESTING, kita tipu sistem dengan memasukkan IP dummy (Contoh di bawah ini IP Singapore).
                // Nanti saat sudah online, hapus atau beri komentar (//) pada 3 baris di bawah ini:
                if ($ip == '127.0.0.1' || $ip == '::1') {
                    $ip = '8.8.8.8'; // Ganti dengan IP negara lain untuk ngetes (misal US: 8.8.8.8)
                }

                $location = Location::get($ip);
                if ($location) {
                    $countryCode = $location->countryCode;
                }
            }

            // Tentukan Mata Uang berdasarkan Kode Negara
            $currency = match($countryCode) {
                'US' => 'USD',
                'SG' => 'SGD',
                'MY' => 'MYR',
                'AU' => 'AUD',
                default => 'IDR' // Negara selain di atas, anggap saja pakai Rupiah
            };

            // Simpan ke Session agar diingat oleh sistem
            Session::put('country_code', $countryCode);
            Session::put('currency', $currency);
        }

        return $next($request);
    }
}