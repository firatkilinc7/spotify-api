<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'profile_pic' => 'required|mimes:jpeg,jpg,png,webp',
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
