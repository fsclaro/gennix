<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class RoleStoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('role-create');
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
            'title.required'       => __('gennix.model_role.request_title'),
            'permissions.required' => __('gennix.model_role.request_permissions'),
        ];
    }
}
