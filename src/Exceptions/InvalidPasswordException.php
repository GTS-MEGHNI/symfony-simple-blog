<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class InvalidPasswordException extends Exception
{

    public function getJsonResponse(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'error',
            'message' => 'Invalid password'
        ], 422);
    }
}