<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class FormulaTratamiento extends Model
{
    protected $table = "formula_tratamientos";

    protected $fillable = ['numero', 'historiaClinica_id', 'control_id', 'sesion_id', 'paciente_id', 'observacion', 'user_id'];

    public function historiaClinica()
    {
        return $this->belongsTo('Ace\HistoriaClinica');
    }

    public function control()
    {
        return $this->belongsTo('Ace\Control');
    }

    public function sesion()
    {
        return $this->belongsTo('Ace\Sesion');
    }

    public function itemsFormulasTratamientos()
    {
        return $this->hasMany('Ace\ItemFormulaTratamiento', 'formulaTratamiento_id');
    }

    public function paciente()
    {
        return $this->belongsTo('Ace\Paciente');
    }

    public function user()
    {
        return $this->belongsTo('Ace\User');
    }

    public function cie10s()
    {
        return $this->belongsToMany('Ace\Cie10','formula_tratamientos_cie10s','formulaTratamiento_id','cie10_id')->withTimestamps();
    }
}
