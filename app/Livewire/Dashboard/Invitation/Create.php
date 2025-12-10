<?php

namespace App\Livewire\Dashboard\Invitation;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    // Properti Form
    public $title = '';
    public $slug = '';
    public $groom_name = '';
    public $bride_name = '';
    public $event_date = '';

    // Definisi Rules Eksplisit (Solusi Error MissingRulesException)
    protected function rules()
    {
        return [
            'title'      => 'required|min:3|max:255',
            'slug'       => 'required|alpha_dash|unique:invitations,slug|max:255',
            'groom_name' => 'required|string|max:100',
            'bride_name' => 'required|string|max:100',
            'event_date' => 'required|date',
        ];
    }

    // Custom Messages (Opsional, biar bahasa Indonesia)
    protected $messages = [
        'title.required' => 'Judul undangan wajib diisi.',
        'slug.unique'    => 'Link URL ini sudah dipakai orang lain.',
        'slug.alpha_dash'=> 'Link URL hanya boleh huruf, angka, dan strip.',
    ];

    public function render()
    {
        return view('livewire.dashboard.invitation.create');
    }

    // Auto-generate slug saat judul diketik
    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        // 1. Validasi
        $this->validate();

        // 2. Siapkan Struktur Data JSON Default (PENTING: Struktur ini harus match dengan Edit.php)
        $defaultCoupleData = [
            'groom' => [
                'nickname' => $this->groom_name, 
                'fullname' => $this->groom_name, // Default fullname sama dengan nickname dulu
                'father'   => '', 
                'mother'   => '',
                'instagram'=> ''
            ],
            'bride' => [
                'nickname' => $this->bride_name, 
                'fullname' => $this->bride_name,
                'father'   => '', 
                'mother'   => '',
                'instagram'=> ''
            ],
            'quote' => 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri...'
        ];

        $defaultEventData = [
            [
                'title'     => 'Akad Nikah',
                'date'      => $this->event_date . ' 08:00', // Default jam 8 pagi
                'location'  => '', 
                'address'   => '',
                'map_link'  => ''
            ]
        ];
        
        $defaultThemeConfig = [
            'primary_color' => '#d4af37', // Gold
            'font'          => 'sans-serif',
            'music_url'     => ''
        ];

        // 3. Simpan ke Database
        $invitation = Invitation::create([
            'user_id'        => Auth::id(),
            'title'          => $this->title,
            'slug'           => Str::slug($this->slug), // Pastikan slug bersih
            'couple_data'    => $defaultCoupleData,
            'event_data'     => $defaultEventData,
            'theme_config'   => $defaultThemeConfig,
            'gallery_data'   => [], // Array kosong
            'gifts_data'     => [], 
            'theme_template' => 'regular',
            'is_active'      => true,
        ]);

        // 4. Redirect
        session()->flash('status', 'Undangan berhasil dibuat! Silakan lengkapi detailnya.');
        return redirect()->route('dashboard.invitation.edit', $invitation->id);
    }
}