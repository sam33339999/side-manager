<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Precognition;

class BaseRequest extends FormRequest
{
    protected array $errors = [];

    /**
     * @return void
     * @throws AuthorizationException
     */
    public function validateResolved()
    {
        // parent::validateResolved();
        $this->prepareForValidation();

        if (! $this->passesAuthorization()) {
            $this->failedAuthorization();
        }

        $instance = $this->getValidatorInstance();

        if ($this->isPrecognitive()) {
            $instance->after(Precognition::afterValidationHook($this));
        }

        if ($instance->fails()) {
            $this->errors = $instance->errors()->toArray();
        }

        $this->passedValidation();
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
