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

    // Contoh: Ambil nama panggilan mempelai pria untuk judul singkat
    // Cara pakai: $invitation->groom_nickname
    public function getGroomNicknameAttribute()
    {
        return $this->couple_data['groom']['nickname'] ?? 'Groom';
    }

    // Cara pakai: $invitation->bride_nickname
    public function getBrideNicknameAttribute()
    {
        return $this->couple_data['bride']['nickname'] ?? 'Bride';
    }
}
