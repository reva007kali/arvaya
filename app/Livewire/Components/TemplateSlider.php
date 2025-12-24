<?php

namespace App\Livewire\Components;

use App\Models\Template;
use Livewire\Component;

use Illuminate\Support\Facades\Cache;

class TemplateSlider extends Component
{
    public $tier = 'all';

    public function render()
    {
        $templates = Cache::remember('template_slider_home', 3600, function () {
            return Template::select(['id', 'name', 'slug', 'thumbnail', 'tier', 'price', 'category', 'preview_url'])
                ->where('is_active', true)
                ->latest()
                ->take(10)
                ->get();
        });

        return view('livewire.components.template-slider', [
            'templates' => $templates
        ]);
    }
}
