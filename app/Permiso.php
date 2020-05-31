<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = "permisos";

    protected $fillable = ['nombre'];

    public function users()
    {
        return $this->belongsToMany('Ace\User','users_permisos')->withTimestamps();
    }
}
