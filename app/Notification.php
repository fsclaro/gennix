<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Helper\GennixHelper;

class Notification extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'notification';

    protected $fillable = [
        'user_id_from',
        'user_id_to',
        'is_read',
        'message',
        'message_type',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
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
        'user_id_from',
        'user_id_to',
        'is_read',
        'message',
        'message_type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // define que somente os atributos alterados que serão auditados
    // nas operações do tipo updated
    protected static $logOnlyDirty = true;

    // define quais os tipos de ações que serão auditados
    protected static $recordEvents = [
        'created',
        'updated',
        'deleted'
    ];

    // Declarar todos os relacionamentos da tabela
    public function user_from()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function user_to()
    {
        return $this->hasOne(User::class, 'id', 'user_id_to');
    }
}
