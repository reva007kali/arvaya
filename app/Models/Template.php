<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $guarded = [];

    // Definisi Tier & Fitur (Logic Pusat)
    const TIERS = [
        'basic' => [
            'label' => 'Basic Tier',
            'features' => ['rsvp', 'guest_book', 'map'],
            'limitations' => ['music', 'gallery', 'countdown', 'love_story']
        ],
        'premium' => [
            'label' => 'Premium Tier',
            'features' => ['rsvp', 'guest_book', 'map', 'music', 'gallery', 'countdown'],
            'limitations' => ['love_story']
        ],
        'exclusive' => [
            'label' => 'Exclusive Tier',
            'features' => ['rsvp', 'guest_book', 'map', 'music', 'gallery', 'countdown', 'love_story', 'prioritas_server'],
            'limitations' => []
        ]
    ];


    // Helper untuk cek apakah template ini dipakai
    public function invitations()
    {
        return $this->hasMany(Invitation::class, 'theme_template', 'slug');
    }
}
