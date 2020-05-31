<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use SoftDeletes;

    protected $table = "agendas";

    protected $fillable = ['paciente_id', 'citaTipo_id', 'tratamiento_id', 'fechaHoraInicio', 'fechaHoraFin', 'observacion', 'estado', 'user_id'];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('Ace\User');
    }

    public function paciente()
    {
        return $this->belongsTo('Ace\Paciente');
    }

    public function citaTipo()
    {
        return $this->belongsTo('Ace\CitaTipo', 'citaTipo_id');
    }

    public function tratamiento()
    {
        return $this->belongsTo('Ace\Tratamiento');
    }
}
