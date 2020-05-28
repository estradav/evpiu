<?php

namespace App;

use App\Traits\LockableTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    use LockableTrait;


    /** The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username','menu','password','created_at','objectguid','lockout_time'
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
     * Obtiene todas las publicaciones que posee el usuario.
     *
     * @return HasMany
     */
    public function posts() {
        return $this->hasMany(Post::class);
    }
}
