<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/21/2024
 */


namespace App\Http\Helpers;

use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

trait RequestTraitValidation
{
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(
            sendError(
                'Validation Error',
                $validator->errors()->toArray(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
