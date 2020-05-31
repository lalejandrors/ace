<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laboratorio extends Model
{
    use SoftDeletes;

    protected $table = "laboratorios";

    protected $fillable = ['nombre','user_id'];

    protected $dates = ['deleted_at'];

    public function medicamentos()
    {
        return $this->hasMany('Ace\Medicamento');
    }

    public function user()
    {
        return $this->belongsTo('Ace\User');
    }
}
