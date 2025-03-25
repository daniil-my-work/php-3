<?php

namespace App\Http\Controllers;

use App\Http\Responses\FailResponse;
use App\Http\Responses\SuccessResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

abstract class Controller
{
    protected function success($data, ?int $code = Response::HTTP_OK)
    {
        return new SuccessResponse($data, $code);
    }

    protected function fail($message, Throwable $exception)
    {
        return new FailResponse($message, $exception);
    }

    // добавить
    // protected function notFound($message, Throwable $exception)
    // {
    //     return new FailResponse($message, $exception);
    // }
    // protected function validationError($message, Throwable $exception)
    // {
    //     return new FailResponse($message, $exception);
    // }
}
