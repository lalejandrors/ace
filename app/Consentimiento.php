<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class Consentimiento extends Model
{
    protected $table = "consentimientos";

    protected $fillable = ['numero', 'historiaClinica_id', 'control_id', 'sesion_id', 'paciente_id', 'contenido', 'observacion', 'user_id'];

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

    public function paciente()
    {
        return $this->belongsTo('Ace\Paciente');
    }

    public function user()
    {
        return $this->belongsTo('Ace\User');
    }
}
