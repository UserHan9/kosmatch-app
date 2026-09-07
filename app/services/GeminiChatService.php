<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiChatService
{
    protected string $apiKey;
    protected string $model = 'gemini-2.5-flash';

    protected string $systemPrompt = <<<PROMPT
Kamu adalah asisten Customer Service untuk KosMatch, platform booking kost online.
Tugasmu HANYA menjawab pertanyaan umum seputar:
- Cara mencari dan booking kamar kost
- Cara pembayaran dan metode yang didukung
- Status booking (pending, confirmed, cancelled, completed) secara umum
- Kebijakan pembatalan booking
- Cara menghubungi pemilik kost

Kamu TIDAK memiliki akses ke data booking, pembayaran, atau akun pribadi user manapun.
Jika user bertanya soal booking/akun spesifik miliknya, arahkan mereka untuk cek
halaman "Booking Saya" atau hubungi admin melalui email support@kosmatch.test.

Jawab singkat, ramah, dan gunakan Bahasa Indonesia.
PROMPT;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    /**
     * @param array $history  [['role' => 'user'|'assistant', 'content' => string], ...]
     */
    public function reply(array $history): string
    {
        // Gemini pakai role 'user' dan 'model' (bukan 'assistant'),
        // dan formatnya "contents" bukan "messages"
        $contents = collect($history)->map(function ($item) {
            return [
                'role' => $item['role'] === 'assistant' ? 'model' : 'user',
                'parts' => [
                    ['text' => $item['content']],
                ],
            ];
        })->values()->all();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(
            "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}",
            [
                'system_instruction' => [
                    'parts' => [
                        ['text' => $this->systemPrompt],
                    ],
                ],
                'contents' => $contents,
                'generationConfig' => [
                    'maxOutputTokens' => 500,
                ],
            ]
        );

        if ($response->failed()) {
            \Illuminate\Support\Facades\Log::error('Gemini API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return 'Maaf, terjadi gangguan pada layanan chat. Silakan coba lagi nanti.';
        }

        $data = $response->json();

        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        return $text ?? 'Maaf, saya tidak bisa memproses permintaan itu saat ini.';
    }
}