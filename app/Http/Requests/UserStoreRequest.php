<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UserStoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user-create');
    }

    public function rules()
    {
        return [
            'name'      => ['required'],
            'email'     => ['required', 'email:rfc,spoof','unique:users,email,' . $this->id],
            'password'  => ['required', 'min:8'],
            'active'    => ['required', 'integer'],
            'gender'    => ['required'],
            'position'  => ['required'],
            'roles'     => ['required_if:is_superadmin,0', 'integer'],
            
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Forneça o nome para este usuário',
            'email.required'    => 'Forneça um e-mail válido',
            'email.unique'      => 'Este e-mail já está associado a outro usuário',
            'password.min'      => 'A senha deve ter no mínimo 8 caracteres',
            'active.required'   => 'Escolha uma das opções',
            'gender.required'   => 'Escolha uma das opções',
            'position.required' => 'Defina a posição/função para este usuário',
            'roles.required'    => 'Escolha pelo menos um papel para este usuário',
        ];
    }
}
