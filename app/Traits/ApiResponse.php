<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponse
{
    // will receive a data to be returned and an optional status
    /**
     * Build successful response
     * @param string/array $data
     * @param int code
     * @return Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json(['data' => $data], $code);
    }

    /**
     * Build successful response
     * @param string/array $message
     * @param int code
     * @return Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
}
