<?php

namespace Modules\Authentication\App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class DeleteProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password'=>['required','string']
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}
