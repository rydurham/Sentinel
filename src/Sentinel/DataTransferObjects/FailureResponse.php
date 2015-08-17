<?php

namespace Sentinel\DataTransferObjects;

class FailureResponse extends BaseResponse
{
    public function __construct($message, array $payload = null)
    {
        parent::__construct($message, $payload);

        $this->success = false;
    }
}
