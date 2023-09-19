<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'fullname' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required|string|min:6',
        ];
    }

    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation ERROR',

            'data'      => $validator->errors()

        ], 422));

    }
}
