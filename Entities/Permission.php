<?php

namespace Modules\GruposDeAcesso\Entities;

use Illuminate\Database\Eloquent\Model;


class Permission extends Model
{
    protected $fillable = [];


    public function roles()
    {
        return  $this->belongsToMany('Modules\GruposDeAcesso\Entities\Role');
    }


}
