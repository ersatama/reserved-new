<?php

namespace App\Http\Requests\Organization;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class OrganizationUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            MainContract::TITLE =>  'nullable|min:1',
            MainContract::DESCRIPTION   =>  'nullable',
            MainContract::DESCRIPTION_KZ    =>  'nullable',
            MainContract::DESCRIPTION_EN    =>  'nullable',

            MainContract::_2GIS         =>  'nullable',

            MainContract::START_MONDAY  =>  'nullable',
            MainContract::END_MONDAY    =>  'nullable',
            MainContract::WORK_MONDAY   =>  'nullable',

            MainContract::START_TUESDAY =>  'nullable',
            MainContract::END_TUESDAY   =>  'nullable',
            MainContract::WORK_TUESDAY  =>  'nullable',

            MainContract::START_WEDNESDAY   =>  'nullable',
            MainContract::END_WEDNESDAY     =>  'nullable',
            MainContract::WORK_WEDNESDAY    =>  'nullable',

            MainContract::START_THURSDAY    =>  'nullable',
            MainContract::END_THURSDAY      =>  'nullable',
            MainContract::WORK_THURSDAY     =>  'nullable',

            MainContract::START_FRIDAY  =>  'nullable',
            MainContract::END_FRIDAY    =>  'nullable',
            MainContract::WORK_FRIDAY   =>  'nullable',

            MainContract::START_SATURDAY    =>  'nullable',
            MainContract::END_SATURDAY  =>  'nullable',
            MainContract::WORK_SATURDAY =>  'nullable',

            MainContract::START_SUNDAY  =>  'nullable',
            MainContract::END_SUNDAY    =>  'nullable',
            MainContract::WORK_SUNDAY   =>  'nullable',

            MainContract::ADDRESS   =>  'nullable',
            MainContract::PHONE =>  'nullable',
            MainContract::EMAIL =>  'nullable',
            MainContract::WEBSITE   =>  'nullable',
            MainContract::INSTAGRAM =>  'nullable',
            MainContract::YOUTUBE   =>  'nullable',
            MainContract::FACEBOOK  =>  'nullable',
            MainContract::VK        =>  'nullable',
            MainContract::PRICE =>  'nullable',
            MainContract::CITY_ID   =>  'nullable',
            MainContract::CATEGORY_ID   =>  'nullable',
            MainContract::IMAGE =>  'nullable',
            MainContract::WALLPAPER =>  'nullable'
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
