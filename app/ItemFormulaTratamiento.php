<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class ItemFormulaTratamiento extends Model
{
    protected $table = "item_formula_tratamientos";

    protected $fillable = ['formulaTratamiento_id', 'tratamiento_id', 'numeroSesiones', 'sesionesRealizadas', 'activo', 'fechaPosibleTerminacion', 'observacion'];

    public function tratamiento()
    {
        return $this->belongsTo('Ace\Tratamiento');
    }

    public function formulaTratamiento()
    {
        return $this->belongsTo('Ace\FormulaTratamiento');
    }

    public function sesiones()
    {
        return $this->hasMany('Ace\Sesion');
    }
}
