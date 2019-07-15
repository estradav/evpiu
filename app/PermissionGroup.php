<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Permission;

class PermissionGroup extends Model
{
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Los permisos que pertenecen al grupo.
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'group_id', 'id');
    }
}
