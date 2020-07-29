<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UserPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user-edit');
    }

    public function rules()
    {
        return [
            'password'        => ['required', 'min:8'],
            'retype_password' => ['same:password'],
        ];
    }

    public function messages()
    {
        return [
            'passwod.required'     => 'O campo senha é obrigatório',
            'password.min'         => 'A senha deve ter no mínimo 8 caracteres',
            'retype_password.same' => 'As senhas digitadas devem ser iguais',
        ];
    }
}
