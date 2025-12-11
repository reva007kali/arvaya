<?php

namespace App\Livewire\Dashboard\Invitation;

use Livewire\Component;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Services\OpenAIService;
use Livewire\Attributes\Layout;

// TAMBAHKAN 2 BARIS INI:
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

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

    // Properti baru untuk loading state AI
    public $isGeneratingAi = false;
    public $aiTone = 'islami'; // Pilihan tone

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

    // --- TAMBAHKAN METHOD INI ---
    public function generateQuote()
    {
        // 1. Ambil nama pengantin
        $groom = $this->couple['groom']['nickname'] ?? 'Mempelai Pria';
        $bride = $this->couple['bride']['nickname'] ?? 'Mempelai Wanita';

        if (empty($groom) || empty($bride)) {
            $this->dispatch('notify', message: 'Isi nama panggilan dulu ya!', type: 'error');
            return;
        }

        $this->isGeneratingAi = true;

        // 2. Panggil Service
        // Pastikan Service diimport di atas: use App\Services\OpenAIService;
        $result = OpenAIService::generateWeddingQuote($groom, $bride, $this->aiTone);

        // 3. Masukkan hasil ke form
        $this->couple['quote'] = $result;

        $this->isGeneratingAi = false;
        $this->dispatch('notify', message: 'Kata-kata berhasil dibuat AI!', type: 'success');
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

        $manager = new ImageManager(new Driver());

        // 1. Upload Foto Baru
        // 1. Upload & Compress Foto Baru
        foreach ($this->newGalleryImages as $photo) {

            // Buat nama file unik dengan ekstensi .webp
            $filename = Str::random(40) . '.webp';

            // Tentukan folder penyimpanan (storage/app/public/invitations/ID)
            $folder = 'invitations/' . $this->invitation->id;
            $path = $folder . '/' . $filename;

            // --- PROSES KOMPRESI ---
            try {
                // Baca file dari temporary upload livewire
                $image = $manager->read($photo->getRealPath());

                // A. Resize: Batasi lebar max 1200px (tinggi menyesuaikan proporsi)
                // Ini mencegah foto 4000px dari kamera HP langsung masuk
                $image->scaleDown(width: 1200);

                // B. Encode ke WebP dengan kualitas 80%
                // Kualitas 80 sangat cukup untuk web, ukuran file bisa turun 70-90%
                $encoded = $image->toWebp(quality: 70);

                // C. Simpan ke Storage Public
                Storage::disk('public')->put($path, (string) $encoded);

                // Masukkan path ke array data untuk disimpan di DB
                // Path yang disimpan: storage/invitations/1/namafile.webp
                $this->existingGallery[] = 'storage/' . $path;

            } catch (\Exception $e) {
                // Fallback: Jika kompresi gagal (jarang terjadi), simpan file asli
                $originalPath = $photo->store('invitations/' . $this->invitation->id, 'public');
                $this->existingGallery[] = 'storage/' . $originalPath;
            }
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