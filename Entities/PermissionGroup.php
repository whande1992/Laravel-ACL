<?php

namespace Modules\GruposDeAcesso\Entities;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    protected $fillable = [];

    public function Permissions()
    {

        return $this->hasMany('\Modules\GruposDeAcesso\Entities\Permission','permissiongroup_id');
    }
}
