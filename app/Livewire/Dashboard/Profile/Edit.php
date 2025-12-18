<?php

namespace App\Livewire\Dashboard\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone_number;
    public $avatar;
    public $newAvatar;

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->avatar = $user->avatar;
    }

    public function updatedNewAvatar()
    {
        $this->validate([
            'newAvatar' => 'image|max:2048', // 2MB Max
        ]);
    }

    public function save()
    {
        $user = auth()->user();

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['nullable', 'string', 'max:20'],
        ]);

        if ($this->newAvatar) {
            $path = $this->newAvatar->store('avatars', 'public');

            // If using storage link, we might need full URL or relative path depending on setup.
            // Assuming 'avatar' column stores the URL or path. 
            // If previous implementation used Google avatar URL, it was a full URL.
            // We'll store the asset path here.

            $user->avatar = Storage::url($path);
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone_number = $this->phone_number;
        $user->save();

        $this->dispatch('notify', message: 'Profil berhasil diperbarui!', type: 'success');
    }

    public function render()
    {
        return view('livewire.dashboard.profile.edit');
    }
}
