<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class Eps extends Model
{
    protected $table = "eps";

    protected $fillable = ['codigo', 'nombre'];

    public function pacientes()
    {
        return $this->hasMany('Ace\Paciente');
    }
}
