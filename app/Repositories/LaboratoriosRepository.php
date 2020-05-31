<?php 

namespace Ace\Repositories;

use DB;

class LaboratoriosRepository{

	//PARA DATATABLES
	public function findLaboratoriosDatatableSearch($start, $length, $search, $usuarioId){

	    return DB::table('laboratorios')->select('id', 'nombre', 'created_at')->where('user_id', $usuarioId)->where('nombre', 'like', '%'.$search.'%')->whereNull('deleted_at')->offset($start)->limit($length)->orderBy('id','DESC')->get();
	}

	public function findLaboratoriosDatatableSearchNum($search, $usuarioId){

	    return DB::table('laboratorios')->select('id', 'nombre', 'created_at')->where('user_id', $usuarioId)->where('nombre', 'like', '%'.$search.'%')->whereNull('deleted_at')->orderBy('id','DESC')->get();
	}

	public function findLaboratoriosDatatable($start, $length, $usuarioId){

	    return DB::table('laboratorios')->select('id', 'nombre', 'created_at')->where('user_id', $usuarioId)->whereNull('deleted_at')->offset($start)->limit($length)->orderBy('id','DESC')->get();
	}

	public function findLaboratoriosDatatableNum($usuarioId){

	    return DB::table('laboratorios')->select('id', 'nombre', 'created_at')->where('user_id', $usuarioId)->whereNull('deleted_at')->orderBy('id','DESC')->get();
	}
	//END PARA DATATABLES

}