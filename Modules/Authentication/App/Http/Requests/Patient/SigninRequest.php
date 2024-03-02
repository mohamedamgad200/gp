<?php

namespace Modules\Authentication\App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class SigninRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required','string','email'],
            'password' => ['required','string'],
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}
