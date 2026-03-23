<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public function success(string $message, array $data = [], int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
            'status'  => $status
        ], $status);
    }

    public function error(string $message, array $errors = [], int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
            'status'  => $status
        ], $status);
    }
}
