<?php

namespace App\Traits;

trait HttpResponses {
    protected function success($data, $message = null, $code = 200){
        return response()->json([
            'status' => 'The request was successifully handled',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($data, $message = null, $code){
        return response()->json([
            'status' => 'An error ocured',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
};