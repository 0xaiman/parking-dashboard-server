<?php

namespace App\Traits;

trait ResponseAPI
{
    // Success Response
    public static function success($message, $data=[], $statusCode=200)
    {
        return response()->json([
            'success'=>true,
            'message'=>$message,
            'data'=>$data,
            'errors'=>null,
            'status'=>$statusCode
        ], $statusCode);
    }

       // Success Response
       public static function error($message, $errors, $statusCode=400)
       {
           return response()->json([
               'success'=>false,
               'message'=>$message,
               'data'=>null,
               'errors'=>$errors,
                'status'=>$statusCode
           ], $statusCode);
       }
}