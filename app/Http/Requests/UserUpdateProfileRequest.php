<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UserUpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user-profile');
    }


    public function rules()
    {
        if (strlen($this->password) > 0) {
            $password_rule = ['required', 'min:8'];
        } else {
            $password_rule = ['sometimes'];
        }

        return [
            'name'      => ['required'],
            'email'     => ['required', 'email:rfc,spoof','unique:users,email,' . $this->id],
            'password'  => $password_rule,
            'gender'    => ['required'],
            'position'  => ['required'],
        ];
    }


    public function messages()
    {
        return [
            'name.required'     => 'Forneça o nome para este usuário',
            'email.required'    => 'Forneça um e-mail válido',
            'email.unique'      => 'Este e-mail já está associado a outro usuário',
            'password.min'      => 'A senha deve ter no mínimo 8 caracteres',
            'gender.required'   => 'Escolha uma das opções',
            'position.required' => 'Defina a posição/função para este usuário',
        ];
    }
}
