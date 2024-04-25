<?php

namespace App\Helper;

use App\Models\User;
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
                'portal-identifier' => request()->portal_identifier,
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
                'portal-identifier' => request()->portal_identifier,
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
                'portal-identifier' => request()->portal_identifier,
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
                'portal-identifier' => request()->portal_identifier,
                'message' => request()->message,
            ]
        );
    }

    public static function respondWithToken(
         ?string $message = null,
        int $errorCode = Response::HTTP_BAD_REQUEST,
        string $token,
        ?User $user = null
    ): ResponseType
    {
        return response()->json(
            [
                'error' => false,
                'message' => $message,
                'result' => [
                    'user' => $user,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                ]
            ],
            $errorCode,
            [
                'portal-identifier' => request()->portal_identifier,
                'message' => request()->message,
            ]
        );
    }
}