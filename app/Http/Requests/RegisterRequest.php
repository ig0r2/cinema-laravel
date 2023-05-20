<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'password' => 'required|min:8|confirmed',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email je obavezan.',
            'email.email' => 'Email mora biti validan.',
            'email.unique' => 'Email je već u upotrebi.',
            'name.required' => 'Ime je obavezno.',
            'password.required' => 'Lozinka je obavezna.',
            'password.min' => 'Lozinka mora sadržati 8 ili više karaktera.',
            'password.confirmed' => 'Lozinka se ne slažu.',
        ];
    }
}
