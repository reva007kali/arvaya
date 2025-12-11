<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'theme_template',
        'theme_config',
        'couple_data',
        'event_data',
        'gallery_data',
        'gifts_data',
        'ai_wishes_summary',
        'is_active',
        'visit_count',
        'package_type',
        'amount',
        'payment_status',
        'payment_proof',
        'active_until',
    ];

    /**
     * The attributes that should be cast.
     * Ini PENTING untuk kolom JSON di SQLite.
     */
    protected $casts = [
        'theme_config' => 'array',
        'couple_data' => 'array',
        'event_data' => 'array', // Akan jadi array of objects
        'gallery_data' => 'array',
        'gifts_data' => 'array',
        'is_active' => 'boolean',
    ];

    // // Definisi Paket (Bisa ditaruh di Config, tapi di sini biar cepat)
    // Definisi Paket Harga (Sesuai Gambar)
    const PACKAGES = [
        'basic' => [
            'name' => 'Undangan Digital Regular',
            'price' => 149000,
            'original_price' => 248000, // Harga coret
            'is_best_seller' => false,
            // Fitur visual untuk ditampilkan di Card (UI)
            'benefits' => [
                'Pengerjaan 1 hari',
                'Subdomain nama kamu',
                'Tema undangan aesthetic',
                'Sebar undangan tanpa batas',
                'Request Backsound',
                'Google maps lokasi acara',
                'Countdown Event', // <-- Added
                'Fitur RSVP',
                'Angpao Digital',
                'Unlimited Galeri',
                'Wedding gift',
                "Fitur kirim do'a & ucapan"
            ],
            // Fitur yang DIBATASI secara sistem (Logic Backend)
            // Regular di gambar punya Musik & Galeri, jadi kita hapus dari limitations.
            // Kita batasi 'love_story' karena itu ada di Custom.
            'limitations' => ['love_story', 'custom_css']
        ],
        'premium' => [
            'name' => 'Undangan Digital Custom',
            'price' => 350000,
            'original_price' => 500000, // Harga coret
            'is_best_seller' => true,
            'benefits' => [
                'Pengerjaan 1-2 hari',
                'Bebas custom',
                'Revisi Maksimal 3 Kali',
                'Subdomain nama kamu',
                'Tema undangan aesthetic',
                'Sebar undangan tanpa batas',
                'Request Backsound',
                'Google maps lokasi acara',
                'Countdown Event', // <-- Added
                'Fitur RSVP',
                'Angpao Digital',
                'Unlimited Galeri',
                'Wedding gift',
                // 'Filter Instagram', // <-- Removed
                'Custom love story',
                "Fitur kirim do'a & ucapan"
            ],
            'limitations' => [] // Full Access
        ],
    ];

    // --- Relationships ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // --- Helpers / Accessors ---
    public function getGroomNicknameAttribute()
    {
        return $this->couple_data['groom']['nickname'] ?? 'Groom';
    }

    // Cara pakai: $invitation->bride_nickname
    public function getBrideNicknameAttribute()
    {
        return $this->couple_data['bride']['nickname'] ?? 'Bride';
    }

    // Helper Cek Fitur
    public function hasFeature($featureName)
    {
        // Jika paketnya basic, cek apakah fitur ini ada di limitations
        $package = self::PACKAGES[$this->package_type] ?? self::PACKAGES['basic'];

        if (in_array($featureName, $package['limitations'])) {
            return false;
        }
        return true;
    }
}
