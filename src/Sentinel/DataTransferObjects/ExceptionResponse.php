<?php

namespace Sentinel\DataTransferObjects;

class ExceptionResponse extends BaseResponse
{
    public function __construct($message, array $payload = null)
    {
        parent::__construct($message, $payload);

        $this->success = false;
        $this->error = true;
    }
}
