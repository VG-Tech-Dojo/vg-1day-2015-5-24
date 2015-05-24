<?php

namespace My1DayServer\Exception;

class InvalidJsonApiException extends \RuntimeException implements ApiExceptionInterface
{
    public function getHttpStatusCode()
    {
        return 400;
    }

    public function getErrorCode()
    {
        return 'invalid-json';
    }
}
