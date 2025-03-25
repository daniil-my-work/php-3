<?php

namespace App\Http\Responses;

use Symfony\Component\HttpFoundation\Response;
use App\http\Responses\BaseResponse;

class FailResponse extends BaseResponse
{
    public function __construct(
        protected ?string $message,
        protected $exception,
    ) {
        $code = $this->exception->getCode() ?? Response::HTTP_BAD_REQUEST;
        parent::__construct([], $code);
    }

    protected function makeResponseData(): ?array
    {
        return ['message' => $this->exception->getMessage() ?? 'Ошибка'];
    }
}
