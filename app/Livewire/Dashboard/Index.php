<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public function render()
    {
        return view('livewire.dashboard.index', [
            'invitations' => Auth::user()->invitations()->latest()->get()
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
