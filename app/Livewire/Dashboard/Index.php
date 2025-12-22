<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $search = '';

    public function render()
    {
        $query = Auth::user()->invitations()->latest();

        if ($this->search !== '') {
            $s = $this->search;
            $query = $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                    ->orWhere('slug', 'like', "%{$s}%");
            });
        }

        return view('livewire.dashboard.index', [
            'invitations' => $query->get()
        ]);
    }

    // Fitur Hapus Undangan
    public function delete($id)
    {
        $invitation = Auth::user()->invitations()->find($id);

        if ($invitation) {
            $invitation->delete();
            session()->flash('status', 'Undangan berhasil dihapus.');
        }
    }
}
