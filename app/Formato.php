<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formato extends Model
{
    use SoftDeletes;

    protected $table = "formatos";

    protected $fillable = ['nombre', 'contenido', 'user_id'];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('Ace\User', 'user_id');
    }
}
