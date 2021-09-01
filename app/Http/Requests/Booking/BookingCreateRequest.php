<?php

namespace App\Http\Requests\Booking;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use App\Helpers\Time\Time;

class BookingCreateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            MainContract::USER_ID                    =>  'required|exists:users,id',
            MainContract::ORGANIZATION_ID            =>  'required|exists:organizations,id',
            MainContract::ORGANIZATION_TABLE_LIST_ID =>  'required|exists:organization_table_lists,id',
            MainContract::TIMEZONE                   =>  'required',
            MainContract::TIME                       =>  'required',
            MainContract::DATE                       =>  'required|date',
            MainContract::PRICE                      =>  'required',
            MainContract::CURRENCY                   =>  'nullable',
            MainContract::CARD_ID                    =>  'nullable|integer',
        ];
    }

    /**
     * @throws ValidationException
     */
    public function validated(): array
    {
        $request = $this->validator->validated();

        $request[MainContract::TIME] =   Time::toLocal($request[MainContract::DATE].' '.$request[MainContract::TIME],$request[MainContract::TIMEZONE]);

        if ((int)$request[MainContract::PRICE] === 0) {
            $request[MainContract::STATUS]   =   MainContract::ON;
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
