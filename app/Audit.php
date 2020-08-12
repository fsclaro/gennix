<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\GennixHelper;
use App\User;

class Audit extends Model
{
    protected $table = 'activity_log';

    protected $fillable = [
        'log_name',
        'description',
        'subject_id',
        'subject_type',
        'causer_id',
        'causer_type',
        'properties',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        //
    ];

    protected $guarded = [
        'id'
    ];

    // define os atributos que serão auditados
    protected static $logAttributes = [
        'id',
        'log_name',
        'description',
        'subject_id',
        'subject_type',
        'causer_id',
        'causer_type',
        'properties',
        'created_at',
        'updated_at',
    ];

    // define que somente os atributos alterados que serão auditados
    // nas operações do tipo updated
    protected static $logOnlyDirty = false;

    // define quais os tipos de ações que serão auditados
    protected static $recordEvents = [
        'created',
        'updated',
        'deleted'
    ];

    public function getCauser($causerID, $causerType, $attribute)
    {
        $data = $causerType::find($causerID);

        if ($data) {
            return $data->$attribute;
        }
        return null;
    }

    //Declare the custom function for formatting
    public function prettyPrint($json_data)
    {

        //Initialize variable for adding space
        $space = 0;
        $flag = false;
        $output = '';

        //Using <pre> tag to format alignment and font
        $output .= "<pre>";

        //loop for iterating the full json data
        for ($counter = 0; $counter < strlen($json_data); $counter++) {
            //Checking ending second and third brackets
            if ($json_data[$counter] == '}' || $json_data[$counter] == ']') {
                $space--;
                $output .= "\n";
                $output .= str_repeat(' ', ($space * 2));
            }


            //Checking for double quote(“) and comma (,)
            if ($json_data[$counter] == '"' && ($json_data[$counter - 1] == ',' ||
                $json_data[$counter - 2] == ',')) {
                $output .= "\n";
                $output .= str_repeat(' ', ($space * 2));
            }
            if ($json_data[$counter] == '"' && !$flag) {
                if ($json_data[$counter - 1] == ':' || $json_data[$counter - 2] == ':') {
                    //Add formatting for question and answer
                    $output .= '<span style="color:blue;font-weight:bold">';
                } else {
                    //Add formatting for answer options
                    $output .= '<span style="color:red;">';
                }
            }
            $output .= $json_data[$counter];
            //Checking conditions for adding closing span tag
            if ($json_data[$counter] == '"' && $flag) {
                $output .= '</span>';
            }
            if ($json_data[$counter] == '"') {
                $flag = !$flag;
            }

            //Checking starting second and third brackets
            if ($json_data[$counter] == '{' || $json_data[$counter] == '[') {
                $space++;
                $output .= "\n";
                $output .= str_repeat(' ', ($space * 2));
            }
        }
        $output .= "</pre>";

        return $output;
    }
}
