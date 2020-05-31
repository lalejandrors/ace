<?php 

namespace Ace\Repositories;

use DB;

class HistoriasRepository{

	//PARA DATATABLES
	public function findHistoriasDatatableSearch($start, $length, $search, $usuarioId){

	    return DB::table('historia_clinicas')->select('historia_clinicas.id', 'historia_clinicas.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'historia_clinicas.created_at')->join('pacientes', 'pacientes.id', '=', 'historia_clinicas.paciente_id')->where('historia_clinicas.user_id', $usuarioId)->where('historia_clinicas.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->offset($start)->limit($length)->orderBy('historia_clinicas.id','DESC')->get();
	}

	public function findHistoriasDatatableSearchNum($search, $usuarioId){

	    return DB::table('historia_clinicas')->select('historia_clinicas.id', 'historia_clinicas.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'historia_clinicas.created_at')->join('pacientes', 'pacientes.id', '=', 'historia_clinicas.paciente_id')->where('historia_clinicas.user_id', $usuarioId)->where('historia_clinicas.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->orderBy('historia_clinicas.id','DESC')->get();
	}

	public function findHistoriasDatatable($start, $length, $usuarioId){

	    return DB::table('historia_clinicas')->select('historia_clinicas.id', 'historia_clinicas.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'historia_clinicas.created_at')->join('pacientes', 'pacientes.id', '=', 'historia_clinicas.paciente_id')->where('historia_clinicas.user_id', $usuarioId)->offset($start)->limit($length)->orderBy('historia_clinicas.id','DESC')->get();
	}

	public function findHistoriasDatatableNum($usuarioId){

	    return DB::table('historia_clinicas')->select('historia_clinicas.id', 'historia_clinicas.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'historia_clinicas.created_at')->join('pacientes', 'pacientes.id', '=', 'historia_clinicas.paciente_id')->where('historia_clinicas.user_id', $usuarioId)->orderBy('historia_clinicas.id','DESC')->get();
	}
	//END PARA DATATABLES

}