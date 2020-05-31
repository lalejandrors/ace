<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tratamiento extends Model
{
    use SoftDeletes;

    protected $table = "tratamientos";

    protected $fillable = ['nombre','user_id'];

    protected $dates = ['deleted_at'];

    public function itemsFormulasTratamientos()
    {
        return $this->hasMany('Ace\ItemFormulaTratamiento');
    }

    public function user()
    {
        return $this->belongsTo('Ace\User');
    }

    public function agendas()
    {
        return $this->hasMany('Ace\Agenda');
    }
}
