<?php

namespace App\Exceptions;

use App\Exceptions\ResourceBaseException;

class AppException extends ResourceBaseException
{
    private $httpResponseCode;
    protected static $className;

    /**
     * @param $errorCode
     * @param $errors
     * @param $responseCode
     * @param $previousException
     */
    public function __construct($message, $errors = null, $responseCode = null, $previousException = null)
    {

        $this->httpResponseCode = $responseCode;

        parent::__construct($message, $errors, $previousException, []);
    }

    public function getHttpResponseCode()
    {
        return $this->httpResponseCode;
    }
}
