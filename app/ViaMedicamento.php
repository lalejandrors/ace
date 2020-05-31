<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class ViaMedicamento extends Model
{
    protected $table = "via_medicamentos";

    protected $fillable = ['nombre'];

    public function itemsFormulas()
    {
        return $this->hasMany('Ace\ItemFormula');
    }
}
