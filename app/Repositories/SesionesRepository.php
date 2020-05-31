<?php 

namespace Ace\Repositories;

use DB;

class SesionesRepository{

	//PARA DATATABLES
	public function findSesionesDatatableSearch($start, $length, $search, $usuarioId){

	    return DB::table('sesions')->select('sesions.id', 'sesions.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'sesions.created_at', 'tratamientos.nombre as tratamiento', 'sesions.numeroVez', 'item_formula_tratamientos.numeroSesiones')->join('pacientes', 'pacientes.id', '=', 'sesions.paciente_id')->join('item_formula_tratamientos', 'item_formula_tratamientos.id', '=', 'sesions.itemFormulaTratamiento_id')->join('tratamientos', 'tratamientos.id', '=', 'item_formula_tratamientos.tratamiento_id')->where('sesions.user_id', $usuarioId)->where('sesions.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->orWhere('tratamientos.nombre', 'like', '%'.$search.'%')->offset($start)->limit($length)->orderBy('sesions.id','DESC')->get();
	}

	public function findSesionesDatatableSearchNum($search, $usuarioId){

	    return DB::table('sesions')->select('sesions.id', 'sesions.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'sesions.created_at', 'tratamientos.nombre as tratamiento', 'sesions.numeroVez', 'item_formula_tratamientos.numeroSesiones')->join('pacientes', 'pacientes.id', '=', 'sesions.paciente_id')->join('item_formula_tratamientos', 'item_formula_tratamientos.id', '=', 'sesions.itemFormulaTratamiento_id')->join('tratamientos', 'tratamientos.id', '=', 'item_formula_tratamientos.tratamiento_id')->where('sesions.user_id', $usuarioId)->where('sesions.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->orWhere('tratamientos.nombre', 'like', '%'.$search.'%')->orderBy('sesions.id','DESC')->get();
	}

	public function findSesionesDatatable($start, $length, $usuarioId){

	    return DB::table('sesions')->select('sesions.id', 'sesions.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'sesions.created_at', 'tratamientos.nombre as tratamiento', 'sesions.numeroVez', 'item_formula_tratamientos.numeroSesiones')->join('pacientes', 'pacientes.id', '=', 'sesions.paciente_id')->join('item_formula_tratamientos', 'item_formula_tratamientos.id', '=', 'sesions.itemFormulaTratamiento_id')->join('tratamientos', 'tratamientos.id', '=', 'item_formula_tratamientos.tratamiento_id')->where('sesions.user_id', $usuarioId)->offset($start)->limit($length)->orderBy('sesions.id','DESC')->get();
	}

	public function findSesionesDatatableNum($usuarioId){

	    return DB::table('sesions')->select('sesions.id', 'sesions.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'sesions.created_at', 'tratamientos.nombre as tratamiento', 'sesions.numeroVez', 'item_formula_tratamientos.numeroSesiones')->join('pacientes', 'pacientes.id', '=', 'sesions.paciente_id')->join('item_formula_tratamientos', 'item_formula_tratamientos.id', '=', 'sesions.itemFormulaTratamiento_id')->join('tratamientos', 'tratamientos.id', '=', 'item_formula_tratamientos.tratamiento_id')->where('sesions.user_id', $usuarioId)->orderBy('sesions.id','DESC')->get();
	}
	//END PARA DATATABLES

}