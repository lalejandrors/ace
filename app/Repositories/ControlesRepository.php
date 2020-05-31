<?php 

namespace Ace\Repositories;

use DB;

class ControlesRepository{

	//PARA DATATABLES
	public function findControlesDatatableSearch($start, $length, $search, $usuarioId){

	    return DB::table('controls')->select('controls.id', 'controls.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'controls.created_at')->join('pacientes', 'pacientes.id', '=', 'controls.paciente_id')->where('controls.user_id', $usuarioId)->where('controls.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->offset($start)->limit($length)->orderBy('controls.id','DESC')->get();
	}

	public function findControlesDatatableSearchNum($search, $usuarioId){

	    return DB::table('controls')->select('controls.id', 'controls.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'controls.created_at')->join('pacientes', 'pacientes.id', '=', 'controls.paciente_id')->where('controls.user_id', $usuarioId)->where('controls.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->orderBy('controls.id','DESC')->get();
	}

	public function findControlesDatatable($start, $length, $usuarioId){

	    return DB::table('controls')->select('controls.id', 'controls.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'controls.created_at')->join('pacientes', 'pacientes.id', '=', 'controls.paciente_id')->where('controls.user_id', $usuarioId)->offset($start)->limit($length)->orderBy('controls.id','DESC')->get();
	}

	public function findControlesDatatableNum($usuarioId){

	    return DB::table('controls')->select('controls.id', 'controls.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'controls.created_at')->join('pacientes', 'pacientes.id', '=', 'controls.paciente_id')->where('controls.user_id', $usuarioId)->orderBy('controls.id','DESC')->get();
	}
	//END PARA DATATABLES

}