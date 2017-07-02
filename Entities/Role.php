<?php

namespace Modules\GruposDeAcesso\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [];



    public function permissions()
    {
        return $this->belongsToMany('\Modules\GruposDeAcesso\Entities\Permission');
    }
}
