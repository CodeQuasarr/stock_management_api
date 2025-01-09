<?php

namespace App\Responses;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiResponse
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function rollback($e, $message ="Something went wrong! Process not completed"): void
    {
        DB::rollBack();
        self::throw($e, $message);
    }

    public static function throw($e, $message ="Something went wrong! Process not completed"){
        Log::info($e);
        throw new HttpResponseException(response()->json(["message"=> $message], 500));
    }

    public static function mapResponse($data, $message = "Operation successful", $error = null, $code = 200): array
    {
        if ($code === 200) {
            return [
                'success' => true,
                'data' => $data,
                'message' => $message,
                'status' => $code,

            ];
        }
        return [
            'success' => false,
            'error' => $error,
            'message' => $message,
            'status' => $code,
        ];
    }

    public static function sendResponse($result , $message ,$error = null, $code=200): JsonResponse
    {
        if ($code === 200) {
            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => $message,
            ], $code);
        }
        return response()->json([
            'success' => false,
            'error' => $error,
            'message' => $message,
        ], $code);
    }
}
