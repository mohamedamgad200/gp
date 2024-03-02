<?php

namespace Modules\Authentication\App\Http\Requests\Patient;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ResendOTPRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'=>['required','string','email',Rule::exists('patients','email')]
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}
