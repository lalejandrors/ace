<?php 

namespace Ace\Repositories;

use DB;

class FormatosRepository{

	//PARA DATATABLES
	public function findFormatosDatatableSearch($start, $length, $search, $usuarioId){

	    return DB::table('formatos')->select('id', 'nombre', 'created_at')->where('user_id', $usuarioId)->where('nombre', 'like', '%'.$search.'%')->whereNull('deleted_at')->offset($start)->limit($length)->orderBy('id','DESC')->get();
	}

	public function findFormatosDatatableSearchNum($search, $usuarioId){

	    return DB::table('formatos')->select('id', 'nombre', 'created_at')->where('user_id', $usuarioId)->where('nombre', 'like', '%'.$search.'%')->whereNull('deleted_at')->orderBy('id','DESC')->get();
	}

	public function findFormatosDatatable($start, $length, $usuarioId){

	    return DB::table('formatos')->select('id', 'nombre', 'created_at')->where('user_id', $usuarioId)->whereNull('deleted_at')->offset($start)->limit($length)->orderBy('id','DESC')->get();
	}

	public function findFormatosDatatableNum($usuarioId){

	    return DB::table('formatos')->select('id', 'nombre', 'created_at')->where('user_id', $usuarioId)->whereNull('deleted_at')->orderBy('id','DESC')->get();
	}
	//END PARA DATATABLES

}