<?php

namespace App\Http\Requests;

use App\Domain\Contracts\UserContract;
use Illuminate\Foundation\Http\FormRequest;

class SmsCodeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            UserContract::CODE  =>  'required|digits:6|integer'
        ];
    }

    public function messages()
    {
        return [
            'integer'   =>  'Код должен содержать только цифры'
        ];
    }
}
