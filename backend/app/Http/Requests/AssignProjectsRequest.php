<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignProjectsRequest extends FormRequest
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
            'projects' => ['required', 'array', 'min:1'],
            'projects.*.project_id' => ['required', 'exists:projects,id'],
            'projects.*.role' => ['required', 'string', 'max:255'],
            'projects.*.start_date' => ['required', 'date'],
            'projects.*.end_date' => ['nullable', 'date', 'after_or_equal:projects.*.start_date'],
        ];
    }
}
