<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = "ciudads";

    protected $fillable = ['nombre', 'departamento_id'];

    protected $with = ['departamento'];

    public function departamento()
    {
        return $this->belongsTo('Ace\Departamento');
    }

    public function pacientes()
    {
        return $this->hasMany('Ace\Paciente');
    }
}
