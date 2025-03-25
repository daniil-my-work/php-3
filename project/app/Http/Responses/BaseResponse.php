<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseResponse implements Responsable
{
    public function __construct(
        protected mixed $data = [],
        public int $statusCode = Response::HTTP_OK
    ) {}

    /**
     * Возвращает JSON-ответ.
     *
     * @param Request $request
     * @return Response
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json($this->makeResponseData(), $this->statusCode);
    }

    /**
     * Преобразует данные в массив.
     *
     * @return array
     */
    protected function prepareData(): array
    {
        if ($this->data instanceof Arrayable) {
            return $this->data->toArray();
        }

        return $this->data;
    }

    /**
     * Метод для формирования ответа.
     *
     * @return array|null
     */
    abstract protected function makeResponseData(): ?array;
}
