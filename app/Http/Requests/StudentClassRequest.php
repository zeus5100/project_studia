<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentClassRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'academic_year' => 'required|string|regex:/^[0-9]{4}\/[0-9]{4}$/',
            'name' => 'required|string|max:50|regex:/^[a-zA-Z0-9\s]+$/u',
            'student_count' => 'required|integer|min:0',
            'comments' => 'nullable|string|max:255',
            'study_direction_id' => 'required|exists:study_directions,id',
            'teacher_id' => 'required|exists:teachers,id',
        ];
    }
}
