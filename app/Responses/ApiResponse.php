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

    public static function sendResponse($result , $message ,$error = null, $code=200): array
    {
        if ($code === 200) {
            return [
                'success' => true,
                'data' => $result,
                'message' => $message,
                'status' => 200,
            ];
        }
        return [
            'success' => false,
            'message' => $message,
            'error' => $error,
            'status' => 500,
        ];
    }
}
