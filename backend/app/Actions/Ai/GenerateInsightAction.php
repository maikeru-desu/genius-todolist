<?php

declare(strict_types=1);

namespace App\Actions\Ai;

use App\Models\Todo;
use App\Services\OpenRouterService;
use Illuminate\Support\Facades\Auth;

final class GenerateInsightAction
{
    public function execute(OpenRouterService $aiService)
    {
        $userId = Auth::user()->id;
        $todayTasks = Todo::where('user_id', $userId)->where('due_date', today())->get();
        $history = Todo::where('user_id', $userId)->where('due_date', '<', today())->get();

        $formattedTodayTasks = json_encode($todayTasks, JSON_PRETTY_PRINT);
        $formattedHistory = json_encode($history, JSON_PRETTY_PRINT);

        $prompt = <<<EOT
            Act like a personal productivity assistant.

            Here is the user's task history:
            $formattedHistory

            Here are today's tasks:
            $formattedTodayTasks

            Give a short insight report on:
            - How many high-priority tasks are due today
            - What task should be done first and why
            - How long it might take based on history
            - Any recommendation to boost productivity

            Limit response to 2-3 concise sentences.
        EOT;

        return $aiService->chat($prompt);
    }
}
