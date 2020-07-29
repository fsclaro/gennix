<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class RoleUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('role-edit');
    }

    public function rules()
    {
        return [
            'title'         => ['required'],
            'permissions.*' => ['integer'],
            'permissions'   => ['required', 'array'],
        ];
    }

    public function messages()
    {
        return [
            'title.required'       => 'Forneça uma descrição para este papel',
            'permissions.required' => 'Escolha pelo menos uma permissão da lista de permissões',
        ];
    }
}
