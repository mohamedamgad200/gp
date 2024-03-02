<?php

namespace Modules\Post\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'body' => ['required_without:image','string'],
            'image' => ['required_without:body','image','mimes:png,jpg','max:90000'],
            'doctor_id'=>['required','integer',Rule::exists('doctors','id')]
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}
