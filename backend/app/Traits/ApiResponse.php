<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponse
{
    /**
     * Return a success JSON response.
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function successResponse($data, ?string $message = null, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Return an error JSON response.
     *
     * @param string $message
     * @param int $statusCode
     * @param mixed|null $data
     * @return JsonResponse
     */
    protected function errorResponse(string $message, $data = null, int $statusCode = 500): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Return a paginated JSON response.
     *
     * @param LengthAwarePaginator $paginator
     * @param string|null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function paginatedResponse(LengthAwarePaginator $paginator, ?string $message = null, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'has_more_pages' => $paginator->hasMorePages(),
            ],
        ]);
    }
}
