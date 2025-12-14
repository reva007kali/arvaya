<?php

namespace App\Livewire\Dashboard\Payment;

use Livewire\Component;
use App\Models\Template;
use App\Models\Invitation;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Mail\NewOrderNotification;
use Illuminate\Support\Facades\Mail;

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


        // --- LOGIC KIRIM EMAIL ---
        try {
            // Ganti dengan email kamu yang asli
            Mail::to('admin@arvayadeaure.com')->send(new NewOrderNotification($this->invitation));
        } catch (\Exception $e) {
            // Log error jika email gagal, tapi jangan hentikan proses checkout user
            \Illuminate\Support\Facades\Log::error('Gagal kirim email notifikasi: ' . $e->getMessage());
        }
        // -------------------------

        session()->flash('message', 'Pembayaran dikirim! Menunggu verifikasi.');
        return redirect()->route('dashboard.index');
    }

    public function render()
    {
        return view('livewire.dashboard.payment.checkout');
    }
}