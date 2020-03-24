<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const VENDEDOR = 3;
    function users()
    {
        return $this->hasMany('App\User');
    }
}