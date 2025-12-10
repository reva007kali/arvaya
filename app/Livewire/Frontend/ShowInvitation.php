<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use App\Models\Invitation;
use App\Models\Guest;


#[Layout('components.layouts.guest')]
class ShowInvitation extends Component
{
    public Invitation $invitation;
    public ?Guest $guest = null; // Bisa null jika tamu umum

    #[Url(as: 'to')]
    public $guestSlug = '';

    public function mount($slug)
    {
        // 1. Cari Undangan berdasarkan Slug
        $this->invitation = Invitation::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // 2. Hitung statistik pengunjung
        $this->invitation->increment('visit_count');

        // 3. Cek apakah ada parameter tamu (?to=slug-tamu)
        if ($this->guestSlug) {
            $this->guest = $this->invitation->guests()
                ->where('slug', $this->guestSlug)
                ->first();
        }
    }

    
    public function render()
    {
        // Tentukan nama komponen tema, default ke 'themes.default'
        $themeName = $this->invitation->theme_template ?? 'default';
        $componentName = "themes.{$themeName}";

        return view('livewire.frontend.show-invitation', [
            'componentName' => $componentName
        ]);
    }
}