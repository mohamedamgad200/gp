<?php

namespace Modules\Authentication\App\Http\Requests\Doctor;


use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ResendOTPRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'=>['required','string','email',Rule::exists('doctors','email')]
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}
