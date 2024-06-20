<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'activity_id' => 'required|exists:activities,id',
            'lesson_topic' => 'required|string|max:50',
            'lesson_datetime' => 'required|date_format:Y-m-d\TH:i',
            'comments' => 'nullable|string|max:1000',
        ];
    }
}
