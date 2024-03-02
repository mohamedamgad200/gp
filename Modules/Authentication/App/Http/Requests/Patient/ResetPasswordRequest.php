<?php

namespace Modules\Authentication\App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'=>['required','string','email',Rule::exists('patients','email')],
            'otp'=>['required','max:'.LENGTH],
            'password'=>['required','confirmed',Rules\Password::defaults()],
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}
