<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    public static function generateText($prompt)
    {
        $apiKey = env('OPENAI_API_KEY');

        if (!$apiKey) {
            return "Error: API Key belum disetting.";
        }

        $response = Http::withToken($apiKey)->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini', // atau gpt-4o-mini (lebih murah)
            'messages' => [
                ['role' => 'system', 'content' => 'Kamu adalah asisten penulis undangan pernikahan yang puitis dan sopan dalam Bahasa Indonesia.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => 150,
        ]);

        return $response->json()['choices'][0]['message']['content'] ?? 'Gagal generate kata-kata.';
    }
}