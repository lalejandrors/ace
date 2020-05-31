<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;

class CopiaSeguridad extends Model
{
    protected $table = "copia_seguridads";

    protected $fillable = ['nombre','descripcion'];
}
