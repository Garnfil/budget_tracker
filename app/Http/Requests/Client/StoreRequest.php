<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'firstname' => 'required_with:lastname',
            'lastname' => 'required_with:firstname',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|string',
            'gender' => 'nullable|in:Male,Female',
            'address' => 'nullable'
        ];
    }
}
