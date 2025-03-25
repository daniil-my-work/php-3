<?php

namespace App\Http\Responses;

use Symfony\Component\HttpFoundation\Response;
use App\http\Responses\BaseResponse;

class SuccessResponse extends BaseResponse
{
    public function __construct(
        protected mixed $data,
        int $code = Response::HTTP_OK
    ) {
        parent::__construct($data, $code);
    }

    protected function makeResponseData(): ?array
    {
        return $this->data ? [
            'data' => $this->prepareData()
        ] : null;
    }
}
