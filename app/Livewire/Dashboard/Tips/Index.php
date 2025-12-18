<?php

namespace App\Livewire\Dashboard\Tips;

use Livewire\Component;
use App\Services\OpenAIService;

class Index extends Component
{
    // Chat Properties
    public $chatInput = '';
    public $chatHistory = []; // Array of ['role' => 'user'|'assistant', 'content' => '...']
    public $isTyping = false;

    // Guide Tabs
    public $activeTab = 'kua'; // kua, surat, budget

    public function mount()
    {
        // Initial greeting from Arvaya
        $this->chatHistory[] = [
            'role' => 'assistant',
            'content' => 'Halo! Saya Arvaya, teman diskusi pernikahanmu. Ada yang bisa saya bantu? Boleh tanya soal persiapan, tips hubungan, atau curhat santai juga boleh.'
        ];
    }

    public function sendMessage()
    {
        $this->validate([
            'chatInput' => 'required|string|max:500',
        ]);

        $userMessage = $this->chatInput;

        // Add user message to history
        $this->chatHistory[] = ['role' => 'user', 'content' => $userMessage];
        $this->chatInput = '';
        $this->isTyping = true;

        // Get AI Response
        // We pass the last 6 messages to keep context but save tokens
        $context = array_slice($this->chatHistory, -6);

        $aiResponse = OpenAIService::chatArvaya($userMessage, $context);

        $this->chatHistory[] = ['role' => 'assistant', 'content' => $aiResponse];
        $this->isTyping = false;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.dashboard.tips.index');
    }
}
