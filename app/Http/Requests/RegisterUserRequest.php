<?php

namespace App\Http\Requests;

use App\Rules\FullName;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'unique:users,email'],
            'userName' => ['required', 'regex:/[a-zA-z\s]+/', new FullName],
            'password' =>['required', 'min:8', 'confirmed'],
            'password_confirmation' => 'required',
            'cpf'=> ['required', 'unique:users,cpf']
        ];
    }

    public function messages(){
        return [
            'userName.required' => 'Seu nome é obrigatório.',
            'userName.alpha' => 'Seu nome deve conter somente letras.',
            'email.required' => 'Por favor, insira um email.',
            'password.required' => 'Por favor, insira uma senha para a conta.',
            'password.confirmed' => 'As senhas não coincidem.',
            'confirmPass.required' =>'Por favor, confirme sua senha.',
            'email.unique' => "Email ja cadastrado",
        ];

    }
}
