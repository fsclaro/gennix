<?php

namespace App;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Gravatar;
use App\Helper\GennixHelper;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, HasMediaTrait;

    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'is_superadmin',
        'gender',
        'position',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'last_login',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'last_login',
        'email_verified_at',
    ];

    /**
     * relacionamentos
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }


    /**
     * funções
     */
    public function adminlte_image()
    {
        return $this->getAvatar($this->id);
    }


    public function adminlte_desc()
    {
        return $this->position;
    }


    public function adminlte_profile_url()
    {
        return 'profile/username';
    }


    public function firstName()
    {
        $name = explode(" ", $this->name);

        return $name[0];
    }


    public function saveActivity($title, $details = null, $type = 'info')
    {
        if ($details) {
            $msgDetails = '<span class="text-red text-bold">Mensagem:</span> ' . $details['message'] . '<br>' .
                '<span class="text-red text-bold">Código de Erro:</span> ' . $details['code_error'] . '<br>' .
                '<span class="text-red text-bold">Usuário:</span> ' . Auth::user()->name . '<br>'.
                '<span class="text-red text-bold">Data/Hora:</span> ' . now()->format(env('DATE_FORMAT_LONG')) . "<br>" .
                '<span class="text-red text-bold">Linha:</span> ' . $details['line'] . '<br>' .
                '<span class="text-red text-bold">Arquivo:</span> ' . $details['file'];
        } else {
            $msgDetails = null;
        }

        Activity::insert([
            'user_id' => Auth::user()->id,
            'ipaddress' => GennixHelper::internalIP(),
            'externalip' => GennixHelper::externalIP(),
            'useragent' => GennixHelper::userAgent(),
            'url' => GennixHelper::urlCurrent(),
            'title' => $title,
            'details' => $msgDetails,
            'type' => $type,
            'is_read' => false,
            'created_at' => now()
        ]);
    }

    public function getAvatar($id)
    {
        $user = User::where('id', $id)->first();
        $avatar = $user->getMedia('avatars');

        if (count($avatar) <= 0) {
            if (Gravatar::exists($user->email)) {
                $avatarUrl = Gravatar::get($user->email);
            } else {
                $avatarUrl = asset('/img/avatar/avatar00.png');
            }
        } else {
            $avatarUrl = $avatar[0]->getFullUrl();
        }

        return $avatarUrl;
    }

    public function detachAllRoles()
    {
        DB::table('role_user')->where('user_id', $this->id)->delete();
    }
}
