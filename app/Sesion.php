<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    protected $table = "sesions";

    protected $fillable = ['numero', 'paciente_id', 'acompanante_id', 'itemFormulaTratamiento_id', 'numeroVez', 'observacion', 'user_id'];

    public function user()
    {
        return $this->belongsTo('Ace\User');
    }

    public function paciente()
    {
        return $this->belongsTo('Ace\Paciente');
    }

    public function acompanante()
    {
        return $this->belongsTo('Ace\Acompanante');
    }

    public function itemFormulaTratamiento()
    {
        return $this->belongsTo('Ace\ItemFormulaTratamiento', 'itemFormulaTratamiento_id');
    }

    public function formulasTratamientos()
    {
        return $this->hasMany('Ace\FormulaTratamiento');
    }

    public function certificadosMedicos()
    {
        return $this->hasMany('Ace\CertificadoMedico');
    }

    public function incapacidadesMedicas()
    {
        return $this->hasMany('Ace\IncapacidadMedica');
    }

    public function formulas()
    {
        return $this->hasMany('Ace\Formula');
    }

    public function consentimientos()
    {
        return $this->hasMany('Ace\Consentimiento');
    }

    public function cie10s()
    {
        return $this->belongsToMany('Ace\Cie10','sesions_cie10s','sesion_id','cie10_id')->withTimestamps();
    }
}
