<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailValidationRequest extends FormRequest
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
            //
            'name'=>'required|string|min:3|max:20',
            'email' => 'required|email|unique:users,email',
            'password'=>'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé.'
        ];
    }
}
