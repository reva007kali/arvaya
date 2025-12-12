<?php

namespace App\Livewire;

use App\Models\Template;
use Livewire\Component;

class TemplateShowcase extends Component
{
    public function render()
    {
        // Mengambil template, bisa diurutkan berdasarkan popularitas
        $templates = Template::where('is_active', true)
            ->inRandomOrder()
            ->take(6)
            ->get();

        return view('livewire.template-showcase', [
            'templates' => $templates
        ]);
    }
}