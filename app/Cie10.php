<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class Cie10 extends Model
{
    protected $table = "cie10s";

    protected $fillable = ['codigo', 'descripcion'];

    public function historiasClinicas()
    {
        return $this->belongsToMany('Ace\HistoriaClinica','historia_clinicas_cie10s','cie10_id','historiaClinica_id')->withTimestamps();
    }

    public function controles()
    {
        return $this->belongsToMany('Ace\Control','controls_cie10s','cie10_id','control_id')->withTimestamps();
    }

    public function sesiones()
    {
        return $this->belongsToMany('Ace\Sesion','sesions_cie10s','cie10_id','sesion_id')->withTimestamps();
    }

    public function pacientes()
    {
        return $this->belongsToMany('Ace\Paciente','pacientes_cie10s')->withTimestamps();
    }

    public function incapacidadesMedicas()
    {
        return $this->belongsToMany('Ace\IncapacidadMedica')->withTimestamps();
    }

    public function formulas()
    {
        return $this->belongsToMany('Ace\Formula','formulas_cie10s','cie10_id','formula_id')->withTimestamps();
    }

    public function formulasTratamientos()
    {
        return $this->belongsToMany('Ace\FormulaTratamiento','formula_tratamientos_cie10s','cie10_id','formulaTratamiento_id')->withTimestamps();
    }
}
