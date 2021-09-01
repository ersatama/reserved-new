<?php

namespace App\Http\Requests\Card;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class CardUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            MainContract::NAME      =>  'nullable',
            MainContract::STATUS    =>  'nullable'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function validated(): array
    {
        $request    =   $this->validator->validated();
        if (array_key_exists(MainContract::ID,$request)) {
            unset($request[MainContract::ID]);
        }
        return $request;
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
