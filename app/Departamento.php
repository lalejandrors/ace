<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = "departamentos";

    protected $fillable = ['nombre'];

    public function ciudades()
    {
        return $this->hasMany('Ace\Ciudad');
    }
}
