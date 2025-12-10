<?php

namespace App\Livewire\Dashboard\Invitation;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Invitation;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public Invitation $invitation;
    public $activeTab = 'couple';

    // --- PROPERTI LOKAL (Agar stabil) ---
    // Kita pindahkan theme_template ke sini agar terdeteksi Livewire dengan baik
    public $theme_template;

    public $couple = [];
    public $events = [];
    public $theme = [];
    public $gifts = [];

    // Uploads
    public $newGalleryImages = [];
    public $existingGallery = [];

    protected function rules()
    {
        return [
            // Ubah rule dari invitation.theme_template ke properti lokal
            'theme_template' => 'required|string',

            'couple.groom.nickname' => 'required',
            'couple.bride.nickname' => 'required',
            'events.*.title' => 'required',
            'events.*.date' => 'required',
            'gifts.*.bank_name' => 'required',
            'gifts.*.account_number' => 'required|numeric',
        ];
    }

    public function mount(Invitation $invitation)
    {
        // Security Check
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $this->invitation = $invitation;

        // --- LOAD DATA KE PROPERTI LOKAL ---

        // 1. Load Template
        $this->theme_template = $invitation->theme_template ?? 'default';

        // 2. Load Couple (Safe Merge)
        $defaultCouple = [
            'groom' => ['nickname' => '', 'fullname' => '', 'father' => '', 'mother' => '', 'instagram' => ''],
            'bride' => ['nickname' => '', 'fullname' => '', 'father' => '', 'mother' => '', 'instagram' => ''],
            'quote' => ''
        ];
        $this->couple = array_replace_recursive($defaultCouple, $invitation->couple_data ?? []);

        // 3. Load Events
        $this->events = $invitation->event_data ?? [];
        if (empty($this->events)) {
            $this->events[] = ['title' => 'Akad', 'date' => '', 'location' => '', 'address' => '', 'map_link' => ''];
        }

        // 4. Load Theme Config
        $defaultTheme = ['primary_color' => '#d4af37', 'font' => 'sans', 'music_url' => ''];
        $this->theme = array_replace_recursive($defaultTheme, $invitation->theme_config ?? []);

        // 5. Load Others
        $this->existingGallery = $invitation->gallery_data ?? [];
        $this->gifts = $invitation->gifts_data ?? [];
    }

    public function render()
    {
        return view('livewire.dashboard.invitation.edit');
    }

    // --- Event Logic ---
    public function addEvent()
    {
        $this->events[] = [
            'title' => 'Acara Baru',
            'date' => '',
            'location' => '',
            'address' => '',
            'map_link' => ''
        ];
    }

    public function removeEvent($index)
    {
        unset($this->events[$index]);
        $this->events = array_values($this->events);
    }

    // --- Gallery Logic ---
    public function removeGalleryImage($index)
    {
        unset($this->existingGallery[$index]);
        $this->existingGallery = array_values($this->existingGallery);
    }

    // --- Gift Logic ---
    public function addGift()
    {
        $this->gifts[] = ['bank_name' => '', 'account_name' => '', 'account_number' => ''];
    }

    public function removeGift($index)
    {
        unset($this->gifts[$index]);
        $this->gifts = array_values($this->gifts);
    }

    public function save()
    {
        $this->validate();

        // 1. Upload Foto Baru
        foreach ($this->newGalleryImages as $photo) {
            $path = $photo->store('invitations/' . $this->invitation->id, 'public');
            $this->existingGallery[] = 'storage/' . $path;
        }

        // 2. Simpan ke Database
        // Gunakan properti lokal ($this->theme_template) untuk update
        $this->invitation->update([
            'theme_template' => $this->theme_template, // <--- INI KUNCINYA
            'couple_data' => $this->couple,
            'event_data' => $this->events,
            'theme_config' => $this->theme,
            'gallery_data' => $this->existingGallery,
            'gifts_data' => $this->gifts,
        ]);

        $this->newGalleryImages = [];

        session()->flash('message', 'Perubahan berhasil disimpan!');
    }
}