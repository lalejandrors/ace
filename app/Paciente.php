<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = "pacientes";

    protected $fillable = ['tipoId', 'identificacion', 'nombres', 'apellidos', 'fechaNacimiento', 'telefonoFijo', 'telefonoCelular', 'email', 'genero', 'hijos', 'ciudad_id', 'ubicacion', 'direccion', 'estadoCivil', 'ocupacion', 'eps_id', 'user_id'];

    protected $with = ['ciudad', 'eps'];//para que se envien en las llamadas por ajax y poder usar eloquent

    public function user()
    {
        return $this->belongsTo('Ace\User','user_id');
    }

    public function ciudad()
    {
        return $this->belongsTo('Ace\Ciudad');
    }

    public function eps()
    {
        return $this->belongsTo('Ace\Eps');
    }

    public function agendas()
    {
        return $this->hasMany('Ace\Agenda');
    }

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

    public function certificadosMedicos()
    {
        return $this->hasMany('Ace\CertificadoMedico');
    }

    public function formulas()
    {
        return $this->hasMany('Ace\Formula');
    }

    public function consentimientos()
    {
        return $this->hasMany('Ace\Consentimiento');
    }

    public function incapacidadesMedicas()
    {
        return $this->hasMany('Ace\IncapacidadMedica');
    }

    public function formulasTratamientos()
    {
        return $this->hasMany('Ace\FormulaTratamiento');
    }

    public function acompanantes()
    {
        return $this->belongsToMany('Ace\Acompanante','pacientes_acompanantes')->withPivot('parentesco')->withTimestamps();
    }

    public function cie10s()
    {
        return $this->belongsToMany('Ace\Cie10','pacientes_cie10s')->withTimestamps();
    }
}
