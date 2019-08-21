<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PermissionGroup;

class Permission extends \Spatie\Permission\Models\Permission
{
    /**
     * El grupo al que pertenece el permiso.
     */
    public function group()
    {
        return $this->belongsTo(PermissionGroup::class, 'group_id');
    }

    /**
     * Obtiene el grupo al que pertenece cada permiso del parámetro.
     *
     * @param  array $permissions
     * @return \Spatie\Permission\Models\Permission
     */
    public static function getGroups(array $permissions) {
        return array_map(function ($permission){
            return static::where('id', $permission)
                        ->with('group')
                        ->get()
                        ->first()['group'];
        }, $permissions);
    }


}
