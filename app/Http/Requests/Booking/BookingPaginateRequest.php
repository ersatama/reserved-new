<?php

namespace App\Http\Requests\Booking;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class BookingPaginateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            MainContract::PAGINATE  =>  'nullable|integer'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function validated(): array
    {
        $request = $this->validator->validated();
        if (!$this->has(MainContract::PAGINATE)) {
            $request[MainContract::PAGINATE]    =   0;
        } elseif ((int) $this->has(MainContract::PAGINATE) > 0) {
            $request[MainContract::PAGINATE]    =   (int) $request[MainContract::PAGINATE] - 1;
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
