<?php

namespace App\Http\Requests\OrganizationTableList;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class OrganizationTableListArrayRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            MainContract::ORGANIZATION_ID   =>  'nullable',
            MainContract::ORGANIZATION_TABLE_ID =>  'nullable',
            MainContract::TABLES    =>  'nullable'
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
