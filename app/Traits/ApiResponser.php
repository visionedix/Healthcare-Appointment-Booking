<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser
{
    protected function successResponse($data, $count = 0, $message = null, $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => 'Success',
            'message' => $message,
            'count' => $count,
            'data' => $data
        ], $code);
    }

    protected function successCreateResponse($data, $count = 0, $message = null, $code = 201): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => 'Success',
            'message' => $message,
            'count' => $count,
            'data' => $data
        ], $code);
    }

    protected function successResponseWithPagination($data, $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json($data, $code);
    }

    protected function errorResponse(string|object $ex, $code): \Illuminate\Http\JsonResponse
    {
        if (getType($ex) == 'object') {
            $errorMessage = $ex->getMessage();

            Log::error(
                $ex->getMessage() . PHP_EOL .
                'File: ' . $ex->getFile() . PHP_EOL .
                'Line: ' . $ex->getLine() . PHP_EOL .
                'Code: ' . $ex->getCode() . PHP_EOL .
                'Trace: ' . $ex->getTraceAsString()
            );
        } else {
            $errorMessage = $ex;

            Log::error($errorMessage);
        }

        return response()->json([
            'code' => $code,
            'status' => 'Error',
            'message' => $errorMessage,
            'data' => null
        ], $code);
    }
}
