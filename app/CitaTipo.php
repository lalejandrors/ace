<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CitaTipo extends Model
{
    use SoftDeletes;

    protected $table = "cita_tipos";

    protected $fillable = ['nombre','color','user_id'];

    protected $dates = ['deleted_at'];

    public function agendas()
    {
        return $this->hasMany('Ace\Agenda');
    }

    public function user()
    {
        return $this->belongsTo('Ace\User');
    }
}
