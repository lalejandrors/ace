<?php

namespace Ace;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class InfoCentro extends Model
{
    protected $table = "info_centros";

    protected $fillable = ['razonSocial', 'nit', 'registroMedico', 'email', 'direccion', 'telefonos', 'linkWeb', 'linkFacebook', 'linkTwitter', 'linkYoutube', 'linkInstagram', 'infoAdicional', 'path'];

    //para guardar el logo...
    public function setPathAttribute($path){
        if(!empty($path)){

            $name=Carbon::now()->second.$path->getClientOriginalName();
            $this->attributes['path'] = $name;
            \Storage::disk('local')->put($name, \File::get($path));
        }
    }
}
