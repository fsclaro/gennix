<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class PermissionUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('permission-edit');
    }

    public function rules()
    {
        return [
            'title'      => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'title.required'      => __("gennix.model_permission.request_title"),
        ];
    }
}
