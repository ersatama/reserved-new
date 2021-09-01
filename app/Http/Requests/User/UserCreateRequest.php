<?php

namespace App\Http\Requests\User;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Validation\ValidationException;

class UserCreateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            MainContract::NAME  =>  'required|min:2|max:255',
            MainContract::PHONE =>  'required|max:255|unique:users,phone',
            MainContract::PASSWORD  =>  'required|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            MainContract::NAME.'.min'  =>  'Укажите ваше имя',
            MainContract::PHONE.'.unique'   =>  'Номер уже зарегистрирован',
            MainContract::PASSWORD.'.min'   =>  'Минимальное количество символов 8'
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
