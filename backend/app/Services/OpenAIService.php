<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

final class OpenAIService
{
    public function chat($prompt)
    {
        $response = Http::withToken(config('services.openai.api_key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4', // or gpt-3.5-turbo
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a productivity assistant.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
            ]);

        return $response->json()['choices'][0]['message']['content'] ?? 'No response.';
    }
}
