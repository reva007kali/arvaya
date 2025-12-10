<?php

namespace App\Livewire\Dashboard\Message;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Invitation;
use App\Models\Message;

class Index extends Component
{
    use WithPagination;

    public Invitation $invitation;
    public $replyContent = '';
    public $replyingToId = null; // ID pesan yang sedang dibalas

    public function mount(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) abort(403);
        $this->invitation = $invitation;
    }

    public function render()
    {
        // Ambil semua pesan utama (yang bukan balasan), beserta balasannya
        $messages = $this->invitation->messages()
            ->whereNull('parent_id')
            ->with('replies')
            ->latest()
            ->paginate(10);

        return view('livewire.dashboard.message.index', [
            'messages' => $messages
        ]);
    }

    public function delete($id)
    {
        $this->invitation->messages()->findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Pesan dihapus.', type: 'info');
    }

    // Set form reply aktif untuk ID tertentu
    public function setReply($id)
    {
        $this->replyingToId = $id;
        $this->replyContent = ''; // Reset text
    }

    public function cancelReply()
    {
        $this->replyingToId = null;
    }

    public function sendReply($parentId)
    {
        $this->validate(['replyContent' => 'required|string|max:500']);

        // Simpan Balasan
        Message::create([
            'invitation_id' => $this->invitation->id,
            'parent_id' => $parentId,
            'sender_name' => 'Mempelai', // Atau nama user
            'content' => $this->replyContent,
            'is_reply_from_owner' => true,
        ]);

        $this->replyingToId = null;
        $this->dispatch('notify', message: 'Balasan terkirim!', type: 'success');
    }
}