<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

final class OpenRouterService
{
    public function chat($prompt)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.config('services.openrouter.api_key'),
            'Content-Type' => 'application/json',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'openrouter/cypher-alpha:free', // You can also try 'mistral/mistral-7b-instruct' for free
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful productivity assistant.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7,
        ]);

        return $response->json()['choices'][0]['message']['content'] ?? 'No response.';
    }
}
