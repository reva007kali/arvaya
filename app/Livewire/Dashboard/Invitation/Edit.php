<?php

namespace App\Livewire\Dashboard\Invitation;

// 1. IMPORTS
// Kita memanggil class-class yang dibutuhkan oleh component ini
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// Library Manipulasi Gambar
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
// Models
use App\Models\Invitation;
use App\Models\Template;
// Service AI
use App\Services\OpenAIService;

class Edit extends Component
{
    // Mengaktifkan fitur upload file di Livewire
    use WithFileUploads;

    // --- PROPERTI UTAMA ---
    public Invitation $invitation;
    public $activeTab = 'couple'; // Tab default yang terbuka saat halaman dimuat

    // --- PROPERTI DATA (MODEL BINDING) ---
    // Variabel ini terhubung langsung dengan input form di view (wire:model)
    public $theme_template; // Slug template yang dipilih (misal: 'rustic')

    // Data JSON yang di-decode jadi Array
    public $couple = [];
    public $events = [];
    public $theme = [];
    public $gifts = [];

    // --- PROPERTI GALERI & UPLOAD ---
    // Struktur data galeri baru (Associative Array)
    public $gallery = [
        'cover' => null,
        'groom' => null,
        'bride' => null,
        'moments' => [],
    ];

    // Penampung file sementara (sebelum di-save)
    public $newCover;
    public $newGroom;
    public $newBride;
    public $newMoments = [];

    // --- PROPERTI AI ---
    public $isGeneratingAi = false; // Loading state
    public $aiTone = 'islami';      // Pilihan gaya bahasa

    // --- PROPERTI LOGIC TEMPLATE & HARGA ---
    public $availableTemplates = [];   // List semua template dari DB
    public $currentTemplatePrice = 0;  // Harga template yang sedang dipilih
    public $currentTierName = '';      // Nama Tier (Basic/Premium)
    public $currentTierFeatures = [];  // List fitur yang didapat

    // --- RULES VALIDASI ---
    protected function rules()
    {
        return [
            'theme_template' => 'required|string',
            'couple.groom.nickname' => 'required',
            'couple.bride.nickname' => 'required',
            'events.*.title' => 'required',
            'events.*.date' => 'required',
            // Validasi gifts hanya jika user mengisi salah satunya
            'gifts.*.bank_name' => 'required_with:gifts.*.account_number',
            'gifts.*.account_number' => 'numeric|nullable',
        ];
    }

    // --- LIFECYCLE: MOUNT (Saat Halaman Pertama Kali Dibuka) ---
    public function mount(Invitation $invitation)
    {
        // 1. Security Check: Pastikan user adalah pemilik undangan
        if ($invitation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $this->invitation = $invitation;

        // 2. Load Templates dari Database (Hanya yang aktif)
        $this->availableTemplates = Template::where('is_active', true)->get();

        // 3. Set Template Awal
        $this->theme_template = $invitation->theme_template ?? 'default';

        // 4. Load Data JSON & Merge dengan Default
        // Tujuannya agar tidak error "Undefined index" jika data di DB masih kosong/null
        $this->loadInvitationData();

        // 5. Hitung Info Harga Berdasarkan Template Awal
        $this->updateTemplateInfo();
    }

    // --- LOGIC: UPDATE HARGA REALTIME ---
    // Method ini otomatis jalan ketika user mengubah radio button 'theme_template'
    public function updatedThemeTemplate($value)
    {
        $this->updateTemplateInfo();
    }

    // Hitung harga & fitur berdasarkan template yang dipilih
    public function updateTemplateInfo()
    {
        // Cari template di collection local (tidak perlu query DB lagi)
        $template = $this->availableTemplates->where('slug', $this->theme_template)->first();

        if ($template) {
            $this->currentTemplatePrice = $template->price;
            $this->currentTierName = ucfirst($template->tier); // Misal: "Premium"

            // Ambil fitur dari konstanta model Template
            // Pastikan const TIERS ada di App\Models\Template
            $this->currentTierFeatures = Template::TIERS[$template->tier]['features'] ?? [];
        }
    }

    // --- HELPER: LOAD DATA ---
    private function loadInvitationData()
    {
        // Default Couple
        $defaultCouple = [
            'groom' => ['nickname' => '', 'fullname' => '', 'father' => '', 'mother' => '', 'instagram' => ''],
            'bride' => ['nickname' => '', 'fullname' => '', 'father' => '', 'mother' => '', 'instagram' => ''],
            'quote' => ''
        ];
        // array_replace_recursive: Data DB menimpa Default, tapi key yang hilang di DB akan diisi Default
        $this->couple = array_replace_recursive($defaultCouple, $this->invitation->couple_data ?? []);

        // Default Events
        $this->events = $this->invitation->event_data ?? [];
        if (empty($this->events)) {
            $this->events[] = ['title' => 'Akad Nikah', 'date' => '', 'location' => '', 'address' => '', 'map_link' => ''];
        }

        // Default Theme Config
        $this->theme = array_replace_recursive(
            ['primary_color' => '#B89760', 'music_url' => ''],
            $this->invitation->theme_config ?? []
        );

        // Default Gifts
        $this->gifts = $this->invitation->gifts_data ?? [];

        // Default Gallery
        $defaultGallery = ['cover' => null, 'groom' => null, 'bride' => null, 'moments' => []];
        $dbGallery = $this->invitation->gallery_data ?? [];

        // Migrasi Data Lama (Jika gallery masih array biasa [0,1,2])
        if (isset($dbGallery[0])) {
            $this->gallery = array_merge($defaultGallery, ['moments' => $dbGallery]);
        } else {
            $this->gallery = array_replace_recursive($defaultGallery, $dbGallery);
        }
    }

    // --- FITUR: AI WRITER ---
    public function generateQuote()
    {
        // Validasi nama harus ada dulu
        $groom = $this->couple['groom']['nickname'] ?? null;
        $bride = $this->couple['bride']['nickname'] ?? null;

        if (empty($groom) || empty($bride)) {
            $this->dispatch('notify', message: 'Isi nama panggilan mempelai dulu ya!', type: 'error');
            return;
        }

        $this->isGeneratingAi = true;

        // Panggil Service OpenAI
        $result = OpenAIService::generateWeddingQuote($groom, $bride, $this->aiTone);

        $this->couple['quote'] = $result;
        $this->isGeneratingAi = false;

        $this->dispatch('notify', message: 'Kata-kata berhasil dibuat AI!', type: 'success');
    }

    // --- HELPER: IMAGE PROCESSING ---
    private function processImage($file, $width = 1200)
    {
        $manager = new ImageManager(new Driver());
        $filename = Str::random(40) . '.webp';
        $folder = 'invitations/' . $this->invitation->id;
        $path = $folder . '/' . $filename;

        try {
            // 1. Baca Gambar
            $image = $manager->read($file->getRealPath());

            // 2. Resize (Scale Down) agar tidak terlalu besar
            $image->scaleDown(width: $width);

            // 3. Convert ke WebP (Quality 80%)
            $encoded = $image->toWebp(quality: 60);

            // 4. Simpan ke Public Storage
            Storage::disk('public')->put($path, (string) $encoded);

            return 'storage/' . $path;

        } catch (\Exception $e) {
            // Fallback jika error (misal GD library tidak support WebP)
            return 'storage/' . $file->store($folder, 'public');
        }
    }

    // --- CRUD ACTIONS (Event, Gift, Gallery) ---

    public function addEvent()
    {
        $this->events[] = ['title' => 'Acara Baru', 'date' => '', 'location' => '', 'address' => '', 'map_link' => ''];
    }

    public function removeEvent($index)
    {
        unset($this->events[$index]);
        $this->events = array_values($this->events);
    }

    public function addGift()
    {
        $this->gifts[] = ['bank_name' => '', 'account_name' => '', 'account_number' => ''];
    }

    public function removeGift($index)
    {
        unset($this->gifts[$index]);
        $this->gifts = array_values($this->gifts);
    }

    public function removeSpecific($key)
    {
        $this->gallery[$key] = null; // Hapus cover/groom/bride
    }

    public function removeMoment($index)
    {
        unset($this->gallery['moments'][$index]);
        $this->gallery['moments'] = array_values($this->gallery['moments']);
    }

    // --- MAIN ACTION: SAVE ---
    public function save()
    {
        $this->validate();

        // 1. PROSES UPLOAD GAMBAR
        if ($this->newCover)
            $this->gallery['cover'] = $this->processImage($this->newCover, 1080);
        if ($this->newGroom)
            $this->gallery['groom'] = $this->processImage($this->newGroom, 800);
        if ($this->newBride)
            $this->gallery['bride'] = $this->processImage($this->newBride, 800);

        foreach ($this->newMoments as $photo) {
            $this->gallery['moments'][] = $this->processImage($photo, 1000);
        }

        // 2. TENTUKAN PAKET & HARGA (CORE LOGIC)
        // Cari template yang dipilih di database
        $selectedTemplate = Template::where('slug', $this->theme_template)->first();

        // Fallback jika template tidak ditemukan (sangat jarang terjadi)
        $packageType = $selectedTemplate ? $selectedTemplate->tier : 'basic';
        $amount = $selectedTemplate ? $selectedTemplate->price : 0;

        // 3. UPDATE DATABASE
        $this->invitation->update([
            'theme_template' => $this->theme_template,

            // Update Info Keuangan & Paket
            'package_type' => $packageType,
            'amount' => $amount,

            // Update Data JSON
            'couple_data' => $this->couple,
            'event_data' => $this->events,
            'theme_config' => $this->theme,
            'gallery_data' => $this->gallery,
            'gifts_data' => $this->gifts,
        ]);

        // 4. BERSIHKAN
        $this->reset(['newCover', 'newGroom', 'newBride', 'newMoments']);

        session()->flash('message', 'Perubahan disimpan! Paket & Harga disesuaikan dengan template.');
    }

    public function render()
    {
        return view('livewire.dashboard.invitation.edit');
    }
}