<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class AuditUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('audit-edit');
    }




    public function rules()
    {
        return [
            'field_name' => [ 'required', 'others_rules' ],

            //  define others_rules
        ];
    }




    public function messages()
    {
        return [
            'field_name.required' => 'Forneça um valor para este campo',

            // define others messages
        ];
    }
}
