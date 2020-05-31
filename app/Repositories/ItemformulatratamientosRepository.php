<?php 

namespace Ace\Repositories;

use DB;

class ItemformulatratamientosRepository{

	public function existenciaFormulacionTratamiento($paciente, $tratamiento){

	    //para saber de la existencia de la formulacion de un tratamiento a alguien para crear una cita de tipo sesion, y evitar la asignacion en formulacion de tratamientos en caso de que ya este asignado
	    return DB::table('item_formula_tratamientos')->join('formula_tratamientos', 'formula_tratamientos.id', '=', 'item_formula_tratamientos.formulaTratamiento_id')->where('formula_tratamientos.paciente_id',$paciente)->where('item_formula_tratamientos.tratamiento_id', $tratamiento)->where('item_formula_tratamientos.activo', 1)->count();
	}

	public function asignacionFormulacionTratamiento($paciente, $tratamiento){

	    //para saber de la existencia de la formulacion de un tratamiento a alguien cuando se quiere empezar el proceso de registro de una sesion
	    return DB::table('item_formula_tratamientos')->select(DB::raw('item_formula_tratamientos.id as idItem, item_formula_tratamientos.*'))->join('formula_tratamientos', 'formula_tratamientos.id', '=', 'item_formula_tratamientos.formulaTratamiento_id')->where('formula_tratamientos.paciente_id',$paciente)->where('item_formula_tratamientos.tratamiento_id', $tratamiento)->where('item_formula_tratamientos.activo', 1)->first();
	}

}