<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'nome' => [
                'required', 'min:3',
                Rule::unique('clientes', 'nome')->ignore($this->id)
            ],
            'nif' => [
                "required",
                Rule::unique('clientes', 'nif')->ignore($this->id)
            ],
        ];
    }

    public function messages()
    {
        return [
            'unique' => 'O campo :attribute já está inserido no banco de Dados, por favor tente novamente com outro :attribute!',
            'min' => 'O campo :attribute Deve ter no mínimo 3 Caracteres',
        ];
    }

    public function attributes()
    {
        return [
            'nif' => 'NIF',
            'nome' => 'Nome',
        ];
    }
}
