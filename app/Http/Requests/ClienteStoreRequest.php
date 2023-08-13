<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteStoreRequest extends FormRequest
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
        $rules = [
            'nome'=>'required|min:3',
            'telefone' => 'required|min:11',
            'cpf' => 'required|min:11',
            'placa_carro' => 'required|min:7'
        ];

        if($this->method() === 'PUT'){
            $rules = [
                'nome'=>'nullable|min:3',
                'telefone' => 'nullable|min:11',
                'cpf' => 'nullable|min:11',
                'placa_carro' => 'nullable|min:7'
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return[
            'nome.required' => 'Nome do cliente é obrigatório!',
            'telefone.required' => 'Telefone do cliente é obrigatório!',
            'telefone.min' => 'Telefone com DDD',
            'cpf.required' => 'CPF do cliente é obrigatório!',
            'cpf.min' => 'CPF inválido',
            'placa_carro.required' => 'Placa do Carro do cliente é obrigatório!',
            'placa_carro.min' => 'Placa do Carro deve conter 7 digitos'


        ];
    }
}
