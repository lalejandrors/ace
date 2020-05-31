<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class LimiteUsuario extends Model
{
    protected $table = "limite_usuarios";

    protected $fillable = ['limite'];
}
