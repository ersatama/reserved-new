<?php

namespace App\Http\Requests\Booking;

use App\Domain\Contracts\BookingContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\Time\Time;
use Illuminate\Validation\ValidationException;

class BookingGuestRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            MainContract::USER_ID                    =>  'required|integer|exists:users,id',
            MainContract::ORGANIZATION_ID            =>  'required|integer|exists:organizations,id',
            MainContract::TITLE                      =>  'required',
            MainContract::ORGANIZATION_TABLE_LIST_ID =>  'required|exists:organization_table_lists,id',
            MainContract::TIMEZONE                   =>  'required',
            MainContract::TIME                       =>  'required',
            MainContract::DATE                       =>  'required|date',
            MainContract::PRICE                      =>  'required',
            MainContract::CURRENCY                   =>  'nullable',
            MainContract::CODE                       =>  'required|integer',
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
