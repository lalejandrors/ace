<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = "perfils";

    protected $fillable = ['nombre'];

    public function users()
    {
        return $this->hasMany('Ace\User');
    }
}
