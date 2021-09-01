<?php

namespace App\Http\Requests\Review;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ReviewCreateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            MainContract::BOOKING_ID        =>  'required|exists:bookings,id',
            MainContract::ORGANIZATION_ID   =>  'required|exists:organizations,id',
            MainContract::USER_ID           =>  'required|exists:users,id',
            MainContract::RATING            =>  'required|integer',
            MainContract::COMMENT           =>  'required',
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
