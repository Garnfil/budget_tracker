<?php

namespace App\Http\Requests\Budget;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'initial_balance' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'display_name' => 'nullable',
            'description' => 'nullable|max:250'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'User field is required.'
            // Add more custom error messages if needed
        ];
    }
}
