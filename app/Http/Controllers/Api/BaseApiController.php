<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    /**
     * Should be called to return data
     * @param $data
     * @param int $httpCode
     * @return JsonResponse
     */
    protected function success($data, int $httpCode = 200)
    {
        return response()->json([
            'status' => 'ok',
            'data' => $data,
            'errors' => [],
        ], $httpCode);
    }

    /**
     * Should be called when endpoint is failed
     * @param int $httpCode
     * @param string $errorMessage
     * @return JsonResponse
     */
    protected function error(int $httpCode, string $errorMessage, string $type = 'http')
    {
        return response()->json([
            'status' => 'failed',
            'data' => [],
            'error' => [
                'type' => $type,
                'message' => $errorMessage,
            ]
        ], $httpCode);
    }

    /**
     * Allows to send validation errors
     * @param array $errors
     * @return JsonResponse
     */
    protected function validationErrors(array $errors)
    {
        return response()->json([
            'status' => 'failed',
            'data' => [],
            'error' => [
                'type' => 'validation',
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ]
        ], 422);
    }
}