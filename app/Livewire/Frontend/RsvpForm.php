<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Invitation;
use App\Models\Guest;
use App\Notifications\GuestRsvpNotification;

class RsvpForm extends Component
{
    public Invitation $invitation;
    public ?Guest $guest = null;

    // Form Fields
    public $name = '';
    public $phone = '';
    public $pax = 1;
    public $rsvp_status = 1; // 1: Hadir
    public $message = '';

    public $isSubmitted = false;

    public function mount($invitation, $guest = null)
    {
        $this->invitation = $invitation;
        $this->guest = $guest;

        // Jika tamu terdeteksi (dari link khusus), isi otomatis
        if ($guest) {
            $this->name = $guest->name;
            $this->phone = $guest->phone;
            $this->rsvp_status = $guest->rsvp_status == 0 ? 1 : $guest->rsvp_status;
            $this->pax = $guest->pax;
            $this->isSubmitted = $guest->rsvp_status != 0; // Jika sudah pernah isi, tampilkan state 'sudah isi'
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'rsvp_status' => 'required',
            'pax' => 'required|integer|min:1|max:10',
        ]);

        if ($this->guest) {
            // Update Tamu yang sudah ada
            $this->guest->update([
                'phone' => $this->phone,
                'rsvp_status' => $this->rsvp_status,
                'pax' => $this->pax,
                'message_from_guest' => $this->message,
            ]);
        } else {
            // Tamu Umum (Belum terdaftar), Buat tamu baru (Optional, atau simpan pesan saja)
            // Di sini kita buat guest baru tapi tanpa slug unik (atau generate random)
            // Agar dashboard tetap rapi, kita bisa skip create guest dan langsung simpan pesan di GuestBook
            // Tapi untuk fitur RSVP, idealnya masuk tabel Guest.

            $this->guest = Guest::create([
                'invitation_id' => $this->invitation->id,
                'name' => $this->name,
                'slug' => \Illuminate\Support\Str::uuid(), // Slug acak internal
                'phone' => $this->phone,
                'rsvp_status' => $this->rsvp_status,
                'pax' => $this->pax,
                'category' => 'Umum',
                'message_from_guest' => $this->message,
            ]);
        }

        // --- DISPATCH NOTIFICATION ---
        // Notify the invitation owner (User)
        if ($this->invitation->user) {
            $this->invitation->user->notify(new GuestRsvpNotification(
                $this->name,
                $this->rsvp_status,
                $this->invitation->title,
                $this->invitation->id
            ));
        }

        $this->isSubmitted = true;
        session()->flash('message', 'Terima kasih atas konfirmasinya!');
    }

    public function render()
    {
        return view('livewire.frontend.rsvp-form');
    }
}