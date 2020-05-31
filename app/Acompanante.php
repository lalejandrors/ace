<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class Acompanante extends Model
{
    protected $table = "acompanantes";

    protected $fillable = ['tipoId', 'identificacion', 'nombres', 'apellidos', 'telefonoFijo', 'telefonoCelular'];

    public function historiasClinicas()
    {
        return $this->hasMany('Ace\HistoriaClinica');
    }

    public function controles()
    {
        return $this->hasMany('Ace\Control');
    }

    public function sesiones()
    {
        return $this->hasMany('Ace\Sesion');
    }

    public function pacientes()
    {
        return $this->belongsToMany('Ace\Paciente','pacientes_acompanantes')->withPivot('parentesco')->withTimestamps();
    }
}
