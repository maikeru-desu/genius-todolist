<?php

namespace App\Http\Controllers;

use App\Actions\Ai\GenerateInsightAction;
use App\Services\OpenRouterService;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function __construct(protected OpenRouterService $openRouterService)
    {}

    public function getInsight(GenerateInsightAction $generateInsightAction)
    {
        return $this->successResponse($generateInsightAction->execute($this->openRouterService), 'Insight generated successfully');
    }
}
