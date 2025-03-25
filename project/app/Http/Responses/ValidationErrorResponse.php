<?php

namespace App\Http\Responses;

use Illuminate\Validation\ValidationException;
use App\http\Responses\BaseResponse;
use Symfony\Component\HttpFoundation\Response;

class ValidationErrorResponse extends BaseResponse
{
    public function __construct(ValidationException $exception)
    {
        parent::__construct(
            $exception->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    protected function makeResponseData(): ?array
    {
        return [
            'message' => 'Переданные данные не корректны.',
            'errors'  => $this->prepareData()
        ];
    }
}
