<?php

namespace App\Http\Requests\Organization;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Domain\Contracts\MainContract;
use Illuminate\Validation\ValidationException;

class OrganizationIdsRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            MainContract::IDS   =>  'required|array'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function validated(): array
    {
        return $this->validator->validated();
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status' => 'failure',
            'status_code' => 400,
            'message' => 'Bad Request',
            'errors' => $validator->errors(),
        ];
        throw new HttpResponseException(response()->json($response, 400));
    }
}
