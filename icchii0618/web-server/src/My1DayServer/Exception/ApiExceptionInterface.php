<?php

namespace My1DayServer\Exception;

interface ApiExceptionInterface
{
    function getHttpStatusCode();
    function getErrorCode();
}
