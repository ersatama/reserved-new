<?php

namespace App\Http\Requests\OrganizationRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use App\Domain\Contracts\MainContract;

class OrganizationRequestCreateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            MainContract::NAME  =>  'required',
            MainContract::PHONE =>  'required',
            MainContract::ORGANIZATION_NAME =>  'required',
            MainContract::CATEGORY_ID   =>  'required',
            MainContract::CITY_ID   =>  'required',
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
