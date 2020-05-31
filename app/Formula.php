<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    protected $table = "formulas";

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

    public function itemsFormulas()
    {
        return $this->hasMany('Ace\ItemFormula');
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
        return $this->belongsToMany('Ace\Cie10','formulas_cie10s','formula_id','cie10_id')->withTimestamps();
    }
}
