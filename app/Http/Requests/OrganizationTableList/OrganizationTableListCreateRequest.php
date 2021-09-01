<?php

namespace App\Http\Requests\OrganizationTableList;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class OrganizationTableListCreateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            MainContract::ORGANIZATION_ID   =>  'required:exists:organizations,id',
            MainContract::ORGANIZATION_TABLE_ID =>  'required|exists:organization_tables,id',
            MainContract::KEY   =>  'required',
            MainContract::TITLE =>  'required',
            MainContract::LIMIT =>  'required'
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
