<?php

namespace App\Http\Requests\Card;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Domain\Contracts\CardContract;
use Illuminate\Validation\ValidationException;

class CardPostRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            MainContract::PG_XML    =>  'required'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function validated(): array
    {
        $request    =   $this->validator->validated();
        $request[MainContract::PG_XML]  =    json_decode(json_encode(simplexml_load_string($request[MainContract::PG_XML])),true);
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
