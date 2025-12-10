<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'name',
        'slug',
        'category',
        'phone',
        'rsvp_status',
        'pax',
        'message_from_guest',
    ];

    // Konstanta untuk status RSVP agar kode lebih terbaca
    const RSVP_PENDING = 0;
    const RSVP_HADIR = 1;
    const RSVP_TIDAK_HADIR = 2;
    const RSVP_RAGU = 3;

    // --- Relationships ---

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    // Tamu (yang terdaftar) bisa punya banyak pesan di buku tamu
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // --- Accessors ---

    // Mendapatkan teks status RSVP
    // Cara pakai: $guest->rsvp_status_label
    public function getRsvpStatusLabelAttribute()
    {
        return match ($this->rsvp_status) {
            self::RSVP_HADIR => 'Hadir',
            self::RSVP_TIDAK_HADIR => 'Maaf, Tidak Bisa Hadir',
            self::RSVP_RAGU => 'Masih Ragu',
            default => 'Belum Konfirmasi',
        };
    }

    // Helper untuk generate link unik tamu ini
    public function getUniqueLinkAttribute()
    {
        // Pastikan route 'invitation.show' sudah didefinisikan nanti
        // domain.com/reza-adinda?to=bapak-budi
        return route('invitation.show', [
            'slug' => $this->invitation->slug,
            'to' => $this->slug
        ]);
    }
}
