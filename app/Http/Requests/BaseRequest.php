<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\AppException;

class BaseRequest extends FormRequest
{
    protected $errorCode = '';

    public function validate()
    {
        if ($this->getValidatorInstance()->fails()) {
            $message = $this->getValidatorInstance()->getMessageBag();
            throw new AppException("validation error", $message, 422);
        }
    }

    protected function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }
}
