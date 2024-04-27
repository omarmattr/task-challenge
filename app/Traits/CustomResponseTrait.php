<?php

namespace App\Traits;

trait CustomResponseTrait
{
    private function custom_response($status, $message, $data, $statusCode = 200)
    {
        return response()->json(['status' => $status, 'message' => $message, 'data' => $data], $statusCode);
    }
}