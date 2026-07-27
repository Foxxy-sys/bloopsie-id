<?php

namespace App\Models;

// 1. PENTING: Gunakan Authenticatable, bukan Model biasa
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// 2. UBAH "extends Model" menjadi "extends Authenticatable"
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom-kolom yang boleh diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'profile_photo',     // Pastikan ini ada
        'role',
        'email_verified_at', // Pastikan ini juga ada
    ];

    /**
     * Kolom-kolom yang harus disembunyikan saat data user dipanggil (keamanan).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data kolom tertentu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
