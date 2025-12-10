<?php

namespace App\Livewire\Dashboard\Guest;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Invitation;
use App\Models\Guest;
use Illuminate\Support\Str;

class Index extends Component
{
    use WithPagination;

    public Invitation $invitation;
    
    // Form Inputs
    public $name = '';
    public $phone = '';
    public $category = 'Keluarga'; // Default
    
    // Search
    public $search = '';

    public function mount(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) abort(403);
        $this->invitation = $invitation;
    }

    public function render()
    {
        $guests = $this->invitation->guests()
            ->where('name', 'like', '%'.$this->search.'%')
            ->latest()
            ->paginate(10);

        return view('livewire.dashboard.guest.index', [
            'guests' => $guests
        ]);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|numeric',
        ]);

        // Generate Slug Unik (bapak-budi, bapak-budi-1, dst)
        $baseSlug = Str::slug($this->name);
        $slug = $baseSlug;
        $count = 1;
        
        while($this->invitation->guests()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }

        // Format No HP ke 62 (Hapus 0 di depan)
        $cleanPhone = $this->phone;
        if(Str::startsWith($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        $this->invitation->guests()->create([
            'name' => $this->name,
            'slug' => $slug,
            'phone' => $cleanPhone,
            'category' => $this->category,
        ]);

        $this->reset(['name', 'phone']);
        $this->dispatch('notify', message: 'Tamu berhasil ditambahkan!', type: 'success');
    }

    public function delete($id)
    {
        $this->invitation->guests()->findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Tamu dihapus.', type: 'info');
    }
}