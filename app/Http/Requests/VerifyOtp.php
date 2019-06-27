<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class VerifyOtp extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'mobile' => 'required|numeric|min:5|max:15',
            'otp' => 'required|numeric|digits:4'
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);
    }
}
