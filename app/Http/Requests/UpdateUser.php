<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class UpdateUser extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'gender' => 'required',
            'email' => 'required|email',
            'location' => 'required',
            'profession_id' => 'required',
            'dob' => 'required|min:3',
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);
    }
}