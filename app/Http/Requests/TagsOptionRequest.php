<?php

namespace App\Http\Requests;

use App\Domain\Contracts\MainContract;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class TagsOptionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        return [
            MainContract::TITLE =>  'required',
            MainContract::TITLE_KZ  =>  'required',
            MainContract::TITLE_EN  =>  'required',
        ];
    }

    public function attributes(): array
    {
        return [
            //
        ];
    }

    public function messages(): array
    {
        return [
            MainContract::TITLE.'.required' =>  'Укажите название',
            MainContract::TITLE_KZ.'.required' =>  'Укажите название на казахском',
            MainContract::TITLE_EN.'.required' =>  'Укажите название на англииском',
        ];
    }
}
