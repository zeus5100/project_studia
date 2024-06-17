<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'last_name' => 'required|string|max:50|regex:/^[a-zA-Z]+$/',
            'phone' => 'required|string|max:20',
            'comments' => 'nullable|string',
        ];
    }
}
