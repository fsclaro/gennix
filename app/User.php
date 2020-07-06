<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Gravatar;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function adminlte_image() {
        if (Gravatar::exists($this->email))
            return Gravatar::get($this->email);

        return asset('/img/avatar/avatar00.png');
    }

    public function adminlte_desc() {
        return 'Analista de Sistemas';
    }

    public function adminlte_profile_url() {

        return 'profile/username';
    }
}
