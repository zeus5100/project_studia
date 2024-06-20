<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
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
            'student_id' => 'required|exists:students,id',
            'grade_date' => 'required|date',
            'grade_value' => 'required|numeric|between:1,6',
            'grade_weight' => 'required|integer|between:1,100',
            'description' => 'nullable|string|max:255',
        ];
    }
}
