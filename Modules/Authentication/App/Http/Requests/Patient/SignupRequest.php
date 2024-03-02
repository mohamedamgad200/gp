<?php

namespace Modules\Authentication\App\Http\Requests\Patient;

use App\Models\Patient;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class SignupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'string', 'email', 'unique:' . Patient::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'birth' => ['required', 'date', 'date_format:d-m-Y'],
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}
