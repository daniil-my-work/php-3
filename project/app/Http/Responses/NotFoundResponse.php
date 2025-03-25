<?php

namespace App\Http\Responses;

use Symfony\Component\HttpFoundation\Response;
use App\http\Responses\BaseResponse;

class NotFoundResponse extends BaseResponse
{
    public function __construct()
    {
        parent::__construct([], Response::HTTP_NOT_FOUND);
    }

    protected function makeResponseData(): ?array
    {
        return ['message' => 'Запрашиваемая страница не существует.'];
    }
}
