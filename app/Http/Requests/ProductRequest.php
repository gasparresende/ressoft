<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //$id = $this->segment(2);
        return [
            'produto' => 'required|unique:products|max:255',
            'codigo' => 'required|unique:products',
        ];
    }

    public function messages()
    {
        return [
            'produto.required' => 'A descrição do produto é obrigatório',
            'codigo.required' => 'O Código do produto é obrigatório',
            'unique' => 'O campo :attribute já está inserido no banco de dados !'
        ];
    }

    public function attributes()
    {
        return [
            'produto' => 'Nome',
            'codigo' => 'NIF',
        ];
    }
}
