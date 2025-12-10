<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    /**
     * Generate kata-kata mutiara pernikahan
     */
    public static function generateWeddingQuote($groom, $bride, $tone = 'islami')
    {
        $apiKey = env('OPENAI_API_KEY');

        if (empty($apiKey)) {
            return "Error: API Key OpenAI belum disetting di .env";
        }

        // Tentukan prompt berdasarkan tone
        $promptTone = match ($tone) {
            'islami' => 'bernuansa Islami, mengutip makna ayat atau hadits tentang pernikahan (tapi jangan tulis ayat arabnya),',
            'modern' => 'beraya modern, casual, tapi tetap romantis,',
            'formal' => 'beraya formal, puitis, dan sangat sopan,',
            default => 'romantis',
        };

        $prompt = "Buatkan 1 paragraf pendek (maksimal 30 kata) kata-kata mutiara undangan pernikahan untuk pasangan bernama {$groom} dan {$bride}. Gaya bahasa {$promptTone} menyentuh hati, dalam Bahasa Indonesia.";

        try {
            $response = Http::withToken($apiKey)->timeout(15)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini', // Bisa ganti gpt-4o-mini kalau mau lebih pintar
                'messages' => [
                    ['role' => 'system', 'content' => 'Kamu adalah asisten penulis undangan pernikahan profesional.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
                'max_tokens' => 200,
            ]);

            if ($response->successful()) {
                return $response->json()['choices'][0]['message']['content'];
            } else {
                Log::error('OpenAI Error: ' . $response->body());
                return "Maaf, AI sedang sibuk. Silakan coba lagi nanti.";
            }
        } catch (\Exception $e) {
            Log::error('OpenAI Connection Error: ' . $e->getMessage());
            return "Gagal terhubung ke server AI.";
        }
    }
}