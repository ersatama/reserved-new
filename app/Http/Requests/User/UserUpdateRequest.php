<?php

namespace App\Http\Requests\User;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class UserUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            MainContract::NAME  =>  'nullable|min:2|max:255',
            MainContract::EMAIL =>  'nullable|unique:'.UserContract::TABLE.','.MainContract::EMAIL.','.$this->id,
            MainContract::LANGUAGE_ID   =>  'nullable|exists:languages,id',
            MainContract::EMAIL_NOTIFICATION    =>  'nullable',
            MainContract::PUSH_NOTIFICATION     =>  'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            MainContract::NAME.'.min'  =>  'Укажите ваше имя',
            MainContract::EMAIL.'.unique'   =>  'Эл.почта уже занят другим пользователям',
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
