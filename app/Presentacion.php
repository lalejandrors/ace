<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class Presentacion extends Model
{
    protected $table = "presentacions";

    protected $fillable = ['nombre'];

    public function medicamentos()
    {
        return $this->hasMany('Ace\Medicamento');
    }
}
