<?php namespace Sentinel\Exceptions;

use Exception;

class FormValidationFailedException extends Exception {

    protected $errors;

    /**
     * @param string $message
     * @param int    $errors
     */
    public function __construct($message, $errors)
    {
        $this->message = $message;
        $this->errors = $errors;
    }

    /**
     * @return int
     */
    public function getErrors()
    {
        return $this->errors;
    }
}