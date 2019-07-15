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
}
