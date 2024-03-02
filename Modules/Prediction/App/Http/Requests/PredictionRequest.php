<?php

namespace Modules\Prediction\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PredictionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "interest-q1" => ['required','string','in:Not at all,Several days,More than half the days,Nearly every day'],
            "interest-q2" => ['required','string','in:Not at all,Several days,More than half the days,Nearly every day'],
            "interest-q3" => ['required','string','in:Not at all,Several days,More than half the days,Nearly every day'],
            "interest-q4" => ['required','string','in:Not at all,Several days,More than half the days,Nearly every day'],
            "interest-q5" => ['required','string','in:Not at all,Several days,More than half the days,Nearly every day'],
            "interest-q6" => ['required','string','in:Not at all,Several days,More than half the days,Nearly every day'],
            "interest-q7" => ['required','string','in:Not at all,Several days,More than half the days,Nearly every day'],
            "interest-q8" => ['required','string','in:Not at all,Several days,More than half the days,Nearly every day'],
            "interest-q9" => ['required','string','in:Not at all,Several days,More than half the days,Nearly every day'],
            "text_input" => ['required','string'],
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}
