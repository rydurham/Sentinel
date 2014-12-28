<?php namespace Sentinel\Services\Responders;

/**
 * Class ManagerResponse
 *
 * An object containing the result of a manager class action
 *
 * @package Sentinel\Services\Responders
 */

class ManagerResponse {

    private $key;
    private $success;
    private $payload;

    public function __construct($key, $success, array $payload = null)
    {
        $this->key = $key;
        $this->success = $success;
        $this->payload = $payload;
    }

}