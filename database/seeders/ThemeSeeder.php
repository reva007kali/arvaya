<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;

class ThemeSeeder extends Seeder
{
    public function run()
    {
        $themes = [
            [
                'name' => 'Royal Luxury',
                'slug' => 'royal-luxury',
                'description' => 'Elegan dengan nuansa emas dan hitam yang mewah.',
                'tier' => 'premium',
                'price' => 150000,
                'thumbnail' => '/themes/thumbnails/royal-luxury.jpg'
            ],
            [
                'name' => 'Botanical Garden',
                'slug' => 'botanical-garden',
                'description' => 'Nuansa alam yang segar dengan ornamen dedaunan air.',
                'tier' => 'premium',
                'price' => 150000,
                'thumbnail' => '/themes/thumbnails/botanical-garden.jpg'
            ],
            [
                'name' => 'Minimalist Clean',
                'slug' => 'minimalist-clean',
                'description' => 'Desain simpel, bersih, dan modern dengan white space.',
                'tier' => 'premium',
                'price' => 150000,
                'thumbnail' => '/themes/thumbnails/minimalist-clean.jpg'
            ],
            [
                'name' => 'Dark Romance',
                'slug' => 'dark-romance',
                'description' => 'Romantis dan dramatis dengan dominasi warna merah marun dan hitam.',
                'tier' => 'premium',
                'price' => 150000,
                'thumbnail' => '/themes/thumbnails/dark-romance.jpg'
            ],
            [
                'name' => 'Vintage Classic',
                'slug' => 'vintage-classic',
                'description' => 'Nuansa nostalgia jaman dulu dengan tekstur kertas dan font klasik.',
                'tier' => 'premium',
                'price' => 150000,
                'thumbnail' => '/themes/thumbnails/vintage-classic.jpg'
            ],
            [
                'name' => 'Bohemian Dream',
                'slug' => 'bohemian-dream',
                'description' => 'Gaya boho yang santai dengan warna bumi (earth tone) dan pampas.',
                'tier' => 'premium',
                'price' => 150000,
                'thumbnail' => '/themes/thumbnails/bohemian-dream.jpg'
            ],
            [
                'name' => 'Islamic Elegant',
                'slug' => 'islamic-elegant',
                'description' => 'Desain islami modern dengan ornamen geometris dan warna lembut.',
                'tier' => 'premium',
                'price' => 150000,
                'thumbnail' => '/themes/thumbnails/islamic-elegant.jpg'
            ],
            [
                'name' => 'Japanese Zen',
                'slug' => 'japanese-zen',
                'description' => 'Ketenangan gaya Jepang dengan aksen bunga sakura dan tata letak vertikal.',
                'tier' => 'premium',
                'price' => 150000,
                'thumbnail' => '/themes/thumbnails/japanese-zen.jpg'
            ],
            [
                'name' => 'Tropical Paradise',
                'slug' => 'tropical-paradise',
                'description' => 'Ceria dan hidup dengan warna teal, oranye, dan daun palem.',
                'tier' => 'premium',
                'price' => 150000,
                'thumbnail' => '/themes/thumbnails/tropical-paradise.jpg'
            ],
            [
                'name' => 'Galaxy Night',
                'slug' => 'galaxy-night',
                'description' => 'Magis dan mempesona dengan latar belakang langit malam berbintang.',
                'tier' => 'premium',
                'price' => 150000,
                'thumbnail' => '/themes/thumbnails/galaxy-night.jpg'
            ],
        ];

        foreach ($themes as $theme) {
            Template::firstOrCreate(
                ['slug' => $theme['slug']],
                $theme
            );
        }
    }
}
