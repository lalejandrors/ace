<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicamento extends Model
{
    use SoftDeletes;

    protected $table = "medicamentos";

    protected $fillable = ['nombre', 'tipo', 'concentracion', 'unidades', 'presentacion_id', 'laboratorio_id', 'user_id'];

    protected $dates = ['deleted_at'];

    protected $with = ['presentacion', 'laboratorio'];//para que se envien en las llamadas por ajax y poder usar eloquent

    public function presentacion()
    {
        return $this->belongsTo('Ace\Presentacion');
    }

    public function laboratorio()
    {
        return $this->belongsTo('Ace\Laboratorio');
    }

    public function itemsFormulas()
    {
        return $this->hasMany('Ace\ItemFormula');
    }

    public function user()
    {
        return $this->belongsTo('Ace\User');
    }
    
}
