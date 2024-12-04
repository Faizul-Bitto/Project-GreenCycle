<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiHttpResponses
{
    public function successResponse($data, $message = null, $code = JsonResponse::HTTP_OK)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function errorResponse($message, $code)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}
