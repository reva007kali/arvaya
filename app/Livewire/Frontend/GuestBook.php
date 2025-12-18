<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Invitation;
use App\Models\Message;
use App\Models\Guest;
use App\Notifications\NewMessageNotification;

class GuestBook extends Component
{
    use WithPagination;

    public Invitation $invitation;
    public ?Guest $guest = null;

    // Form
    public $sender_name = '';
    public $content = '';

    // Config
    protected $paginationTheme = 'tailwind';

    public function mount($invitation, $guest = null)
    {
        $this->invitation = $invitation;
        $this->guest = $guest;

        if ($guest) {
            $this->sender_name = $guest->name;
        }
    }

    public function sendMessage()
    {
        $this->validate([
            'sender_name' => 'required|string|max:50',
            'content' => 'required|string|max:500',
        ]);

        $msg = Message::create([
            'invitation_id' => $this->invitation->id,
            'guest_id' => $this->guest?->id,
            'sender_name' => $this->sender_name,
            'content' => $this->content,
        ]);

        // --- DISPATCH NOTIFICATION ---
        if ($this->invitation->user) {
            $this->invitation->user->notify(new NewMessageNotification(
                $this->sender_name,
                $this->content,
                $this->invitation->title,
                $this->invitation->id
            ));
        }

        $this->content = ''; // Reset pesan

        session()->flash('msg_status', 'Ucapan berhasil dikirim!');
    }

    public function render()
    {
        // Ambil pesan utama (bukan reply), urutkan terbaru
        $messages = $this->invitation->messages()
            ->whereNull('parent_id')
            ->with('replies') // Eager load reply dari mempelai
            ->latest()
            ->paginate(5);

        return view('livewire.frontend.guest-book', [
            'messages' => $messages
        ]);
    }
}