<?php

namespace App\Http\Controllers\Api\Messages;

use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function sendSuccess($data, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $allErrors = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($allErrors)){
            $response['data'] = $allErrors;
        }


        return response()->json($response, $code);
    }
}
