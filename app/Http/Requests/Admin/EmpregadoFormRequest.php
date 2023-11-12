<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EmpregadoFormRequest extends FormRequest
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
        return [
            'nome' => 'required|max:50',
            'cpf' => 'required|max:15',
            'ctps' => 'required|max:20',
            'serie' => 'required|max:10',
            'data_nascimento' => 'required',
            'data_admissao' => 'required',
            'setor_id' => 'required',
            'funcao_id' => 'required',
            'grupo_id' => 'required'
        ];
    }
}