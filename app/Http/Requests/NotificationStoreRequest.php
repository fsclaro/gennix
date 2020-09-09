<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class NotificationStoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('notification-create');
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
