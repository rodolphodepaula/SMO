<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       //  $id = $this->segment(2);
        return [
           // 'name' => "required|min:3|max:50|unique:users,name,{$id}, id",
           'name' => "required|min:3|max:50",
           // 'email' => "required|min:3|max:50|unique:users,email,{$id}, id",
           'email' => "required|min:3|max:50",
            'tipousuario_id' => 'required'
        ];
    }
}
