<?php 

namespace Ace\Repositories;

use DB;

class CitatiposRepository{

	//PARA DATATABLES
	public function findCitatiposDatatableSearch($start, $length, $search, $usuarioId){

	    return DB::table('cita_tipos')->select('id', 'nombre', 'color', 'created_at')->where('user_id', $usuarioId)->where('nombre', 'like', '%'.$search.'%')->whereNull('deleted_at')->offset($start)->limit($length)->orderBy('id','DESC')->get();
	}

	public function findCitatiposDatatableSearchNum($search, $usuarioId){

	    return DB::table('cita_tipos')->select('id', 'nombre', 'color', 'created_at')->where('user_id', $usuarioId)->where('nombre', 'like', '%'.$search.'%')->whereNull('deleted_at')->orderBy('id','DESC')->get();
	}

	public function findCitatiposDatatable($start, $length, $usuarioId){

	    return DB::table('cita_tipos')->select('id', 'nombre', 'color', 'created_at')->where('user_id', $usuarioId)->whereNull('deleted_at')->offset($start)->limit($length)->orderBy('id','DESC')->get();
	}

	public function findCitatiposDatatableNum($usuarioId){

	    return DB::table('cita_tipos')->select('id', 'nombre', 'color', 'created_at')->where('user_id', $usuarioId)->whereNull('deleted_at')->orderBy('id','DESC')->get();
	}
	//END PARA DATATABLES

}