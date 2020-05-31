<?php 

namespace Ace\Repositories;

use DB;

class TratamientosRepository{

	//PARA DATATABLES
	public function findTratamientosDatatableSearch($start, $length, $search, $usuarioId){

	    return DB::table('tratamientos')->select('id', 'nombre', 'created_at')->where('user_id', $usuarioId)->where('nombre', 'like', '%'.$search.'%')->whereNull('deleted_at')->offset($start)->limit($length)->orderBy('id','DESC')->get();
	}

	public function findTratamientosDatatableSearchNum($search, $usuarioId){

	    return DB::table('tratamientos')->select('id', 'nombre', 'created_at')->where('user_id', $usuarioId)->where('nombre', 'like', '%'.$search.'%')->whereNull('deleted_at')->orderBy('id','DESC')->get();
	}

	public function findTratamientosDatatable($start, $length, $usuarioId){

	    return DB::table('tratamientos')->select('id', 'nombre', 'created_at')->where('user_id', $usuarioId)->whereNull('deleted_at')->offset($start)->limit($length)->orderBy('id','DESC')->get();
	}

	public function findTratamientosDatatableNum($usuarioId){

	    return DB::table('tratamientos')->select('id', 'nombre', 'created_at')->where('user_id', $usuarioId)->whereNull('deleted_at')->orderBy('id','DESC')->get();
	}
	//END PARA DATATABLES

}