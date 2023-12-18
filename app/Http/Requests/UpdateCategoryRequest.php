<?php

namespace App\Http\Requests;

use App\Traits\APIResponseTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UpdateCategoryRequest extends FormRequest
{
    use  APIResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
             return [
                 'name'=>'required|string',
             ];
    }
    protected function failedValidation(Validator $validator): void
    {
        // to store  the error validation  message
        $allErrors = $validator->errors()->all();
        // to check the json response
        if ($this->expectsJson())
            throw new HttpResponseException(
                $this->errorResponse(  $allErrors , Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        // for other response types (without 0handling)
        parent::failedValidation($validator);
    }
}
