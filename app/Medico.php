<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Medico extends Model
{
    use SoftDeletes;

    protected $table = "medicos";

    protected $fillable = ['especialidad', 'registroMedico', 'email'];

    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->belongsToMany('Ace\User','users_medicos')->withTimestamps();
    }

    public function user()
    {
        return $this->hasOne('Ace\User');
    }
}
