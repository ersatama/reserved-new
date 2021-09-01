<?php

namespace App\Http\Requests;

use App\Domain\Contracts\OrganizationTablesContract;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class OrganizationTablesRequest extends FormRequest
{

    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            OrganizationTablesContract::ORGANIZATION_ID => 'required|exists:organizations,id',
            OrganizationTablesContract::NAME    =>  'required'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
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
            OrganizationTablesContract::ORGANIZATION_ID.'.required' =>  'Выберите организацию',
            OrganizationTablesContract::ORGANIZATION_ID.'.exists' =>  'Организации не существует',
            OrganizationTablesContract::NAME.'.required'    =>  'Укажите название секции'
        ];
    }
}
