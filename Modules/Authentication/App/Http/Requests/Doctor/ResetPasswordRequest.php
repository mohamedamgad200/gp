<?php

namespace Modules\Authentication\App\Http\Requests\Doctor;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'=>['required','string','email',Rule::exists('doctors','email')],
            'otp'=>['required','max:'.LENGTH],
            'password'=>['required','confirmed',Rules\Password::defaults()],
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}
