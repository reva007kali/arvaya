<?php

namespace App\Livewire\Dashboard\Payment;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Invitation;
use App\Models\Template;

class Checkout extends Component
{
    use WithFileUploads;

    public Invitation $invitation;
    public $proofImage;

    // Info Tagihan
    public $templateName;
    public $templatePrice;
    public $templateTier;
    public $features = [];

    public function mount(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id())
            abort(403);
        $this->invitation = $invitation;

        // Ambil info template yang sudah dipilih di Editor
        $template = Template::where('slug', $invitation->theme_template)->firstOrFail();

        $this->templateName = $template->name;
        $this->templatePrice = $template->price;
        $this->templateTier = $template->tier;
        $this->features = Template::TIERS[$template->tier]['features'] ?? [];

        // Pastikan amount di invitation sync dengan harga template terbaru
        if ($invitation->payment_status == 'unpaid') {
            $invitation->update(['amount' => $template->price, 'package_type' => $template->tier]);
        }
    }

    public function save()
    {
        $this->validate(['proofImage' => 'required|image|max:2048']);
        $path = $this->proofImage->store('payment_proofs', 'public');

        $this->invitation->update([
            'payment_proof' => 'storage/' . $path,
            'payment_status' => 'pending',
        ]);

        session()->flash('message', 'Pembayaran dikirim! Menunggu verifikasi.');
        return redirect()->route('dashboard.index');
    }

    public function render()
    {
        return view('livewire.dashboard.payment.checkout');
    }
}