<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'last_name' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'student_class_id' => 'required|exists:student_classes,id',
            'comments' => 'nullable|string',
        ];
    }
}
