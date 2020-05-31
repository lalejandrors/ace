<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class ItemFormula extends Model
{
    protected $table = "item_formulas";

    protected $fillable = ['formula_id', 'medicamento_id', 'viaMedicamento_id', 'cantidad', 'dosisFrecuencia', 'horas', 'duracion', 'observacion'];

    public function medicamento()
    {
        return $this->belongsTo('Ace\Medicamento');
    }

    public function viaMedicamento()
    {
        return $this->belongsTo('Ace\ViaMedicamento', 'viaMedicamento_id');
    }

    public function formula()
    {
        return $this->belongsTo('Ace\Formula');
    }
}
