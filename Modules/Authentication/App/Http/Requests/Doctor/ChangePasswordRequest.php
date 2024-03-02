<?php

namespace Modules\Authentication\App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_password' => ['required','string'],
            'new_password'=>['required','confirmed',Rules\Password::defaults()],
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}
