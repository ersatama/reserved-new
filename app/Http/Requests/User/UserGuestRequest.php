<?php

namespace App\Http\Requests\User;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use App\Helpers\Random\Random;
use Illuminate\Validation\ValidationException;

class UserGuestRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            MainContract::NAME  =>  'required|min:2|max:255',
            MainContract::PHONE =>  'required|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            MainContract::NAME.'.min'  =>  'Укажите ваше имя',
        ];
    }

    /**
     * @throws ValidationException
     */
    public function validated(): array
    {
        $request    =   $this->validator->validated();
        $request[MainContract::PASSWORD]    =   rand(100000,999999);
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
