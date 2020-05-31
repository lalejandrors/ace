<?php 

namespace Ace\Repositories;

use DB;

class CiudadesRepository{

	public function ciudadesAutocomplete($busqueda){

	    //para obtener las ciudades en el autocompletar
	    return DB::table('ciudads')->select('ciudads.id', DB::raw('CONCAT(ciudads.nombre , " (", departamentos.nombre, ")") as label'))->join('departamentos', 'departamentos.id', '=', 'ciudads.departamento_id')->where('ciudads.nombre','like',"%$busqueda%")->orderBy('ciudads.nombre','ASC')->get();//para que funcione el autocomplete de jquery ui, los datos se deben mandar como value y label
	}

}