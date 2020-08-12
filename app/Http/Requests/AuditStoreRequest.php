<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class AuditStoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('audit-create');
    }




    public function rules()
    {
        return [
            'field_name' => [ 'required', 'others_rules' ],

            // define others rules
        ];
    }




    public function messages()
    {
        return [
            'field_name.required' => 'Forneça um valor para este campo',

            // define other messages
        ];
    }
}
