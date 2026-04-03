<?php

namespace App\Http\Requests;

// use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome_usuario' => 'required',
            'email' => 'required|email',
            'senha' => 'required|min:8',
        ];
    }

    public function messages(): array
    {
        return[
            'nome_usuario.required' => "Campo nome é obrigatório!",
            'email.required' => "Campo email é obrigatório!",
            'email.email' => "É necessário um email válido!",
            'senha.required' => "Campo senha é obrigatório!",
            'senha.min' => "Senha com no mínimo :min caracteries!",
        ];
    }
}
