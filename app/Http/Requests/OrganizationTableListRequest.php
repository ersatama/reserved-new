<?php

namespace App\Http\Requests;

use App\Domain\Contracts\OrganizationTableListContract;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class OrganizationTableListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            OrganizationTableListContract::ORGANIZATION_ID  => 'required|exists:organizations,id',
            OrganizationTableListContract::ORGANIZATION_TABLE_ID    =>  'required|exists:organization_tables,id',
            OrganizationTableListContract::TITLE =>  'required',
            OrganizationTableListContract::LIMIT    =>  'required|min:1'
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
            OrganizationTableListContract::ORGANIZATION_ID.'.required'  =>  'Выберите организацию',
            OrganizationTableListContract::ORGANIZATION_ID.'.exists'  =>  'Организации не существует',
            OrganizationTableListContract::ORGANIZATION_TABLE_ID.'.required'  =>  'Выберите секцию',
            OrganizationTableListContract::ORGANIZATION_TABLE_ID.'.exists'  =>  'Секции не существует',
            OrganizationTableListContract::TITLE.'.required' =>  'Укажите название стола',
            OrganizationTableListContract::LIMIT.'.required'    =>  'Укажите вместимость человек',
            OrganizationTableListContract::LIMIT.'.min'    =>  'Минимальное цисло 1'
        ];
    }
}
