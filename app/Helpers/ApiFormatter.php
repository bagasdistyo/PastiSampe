<?php

namespace App\Helpers;

class ApiFormatter
{
    protected static $response = [
        'code' => null,
        'message' => null,
        'data' => null,
    ];

    public static function createApi($code = null, $message = null, $data = null)
    {
        self::$response['code'] = $code;
        self::$response['message'] = $message;

        // Assign the nested "data" object directly to the top-level "data" property
        self::$response['data'] = isset($data->data) ? $data->data : $data;

        // Removing "response_code" and "response_message" properties if present
        if (isset(self::$response['data']->response_code)) {
            unset(self::$response['data']->response_code);
        }
        if (isset(self::$response['data']->response_message)) {
            unset(self::$response['data']->response_message);
        }

        return response()->json(self::$response, self::$response['code']);
    }
}