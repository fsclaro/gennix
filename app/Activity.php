<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $table = 'activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ipaddress',
        'externalip',
        'useragent',
        'url',
        'title',
        'details',
        'type',
        'is_read'
    ];

    /**
     * The dates attributes.
     *
     * @var array
     */
    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];



    /**
     * Relationships
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
