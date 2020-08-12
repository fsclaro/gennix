<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'title',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    // define attributes for audit changes
    protected static $logAttributes = [
        'id',
        'title',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // register audit for only changed attributes
    protected static $logOnlyDirty = true;

    // define types actions for audit
    protected static $recordEvents = [
        'created',
        'updated',
        'deleted'
    ];


    /**
     * relacionamentos
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }


    public function detachAllPermissions()
    {
        DB::table('permission_role')->where('role_id', $this->id)->delete();
    }
}
