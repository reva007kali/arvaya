<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'guest_id',
        'parent_id',
        'sender_name',
        'content',
        'is_reply_from_owner',
    ];

    protected $casts = [
        'is_reply_from_owner' => 'boolean',
    ];

    // --- Relationships ---

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    // Relasi ke Guest (Optional, bisa null jika tamu umum)
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    // Relasi ke Pesan Induk (jika ini adalah balasan)
    public function parent()
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    // Relasi ke Balasan-balasan (Children)
    public function replies()
    {
        return $this->hasMany(Message::class, 'parent_id');
    }
}
