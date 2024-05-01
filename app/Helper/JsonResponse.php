<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse as ResponseType;
use Symfony\Component\HttpFoundation\Response;

class JsonResponse
{
    public static function success(
        $result = null,
        string $message = 'Success'
    ): ResponseType {
        return response()->json(
            [
               'error' => false,
               'message' => $message,
               'result' => !is_null($result) ?
                   $result :
                   null,
            ],
            Response::HTTP_OK,
            [
                'knipklok-identifier' => request()->knipklok_identifier,
                'message' => request()->message,
            ]
        );
    }

    public static function successWithoutContent(
        string $message = 'Success'
    ): ResponseType {
        return response()->json(
            [
                'error' => false,
                'message' => $message,
                'result' => null,
            ],
            Response::HTTP_ACCEPTED,
            [
                'knipklok-identifier' => request()->knipklok_identifier,
                'message' => request()->message,
            ]
        );
    }

    public static function created(
        $result = null,
        string $message = 'created'
    ): ResponseType {
        return response()->json(
            [
                'error' => false,
                'message' => $message,
                'result' => !is_null($result) ?
                    $result :
                    null,
            ],
            Response::HTTP_CREATED,
            [
                'knipklok-identifier' => request()->knipklok_identifier,
                'message' => request()->message,
            ]
        );
    }

    public static function fail(
        ?string $message = null,
        int $errorCode = Response::HTTP_BAD_REQUEST
    ): ResponseType {
        return response()->json(
            [
                'error' => true,
                'message' => $message,
                'result' => null,
            ],
            $errorCode,
            [
                'knipklok-identifier' => request()->knipklok_identifier,
                'message' => request()->message,
            ]
        );
    }
}
