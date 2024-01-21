<?php

namespace App\Http\Requests\Income;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'budget_id' => 'required|exists:budgets,id',
            'income_category_id' => 'required|exists:income_categories,id',
            'title' => 'required',
            'amount' => 'required|numeric',
            'transaction_datetime' => 'required',
            'description' => 'nullable|max:250',
        ];
    }
}
