<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

use App\Domain\Contracts\IikoContract;

class IikoRequest extends FormRequest
{

    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            IikoContract::ORGANIZATION_ID   =>  'required|exists:organizations,id',
            IikoContract::IIKO_ID   =>  'required',
            IikoContract::API_KEY   =>  'required',
            IikoContract::API_ID    =>  'required',
            IikoContract::API_SECRET    =>  'required',
        ];
    }

    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
