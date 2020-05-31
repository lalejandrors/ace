<?php 

namespace Ace\Repositories;

use DB;

class MedicamentosRepository{

	public function medicamentosAutocomplete($busqueda, $userId){

	    //para obtener los medicamentos en el autocompletar
	    return DB::table('medicamentos')->select('medicamentos.id', DB::raw('CONCAT(medicamentos.nombre, " ", medicamentos.concentracion, " X", medicamentos.unidades, " Unidades - ", presentacions.nombre, " (", laboratorios.nombre, ")") as label'))->join('presentacions', 'presentacions.id', '=', 'medicamentos.presentacion_id')->join('laboratorios', 'laboratorios.id', '=', 'medicamentos.laboratorio_id')->where(DB::raw('CONCAT(medicamentos.nombre, " ", medicamentos.concentracion, " X", medicamentos.unidades, " Unidades - ", presentacions.nombre, " (", laboratorios.nombre, ")")'),'like',"%$busqueda%")->where('medicamentos.user_id',$userId)->where('laboratorios.deleted_at', null)->orderBy('medicamentos.nombre','ASC')->get();//para que funcione el autocomplete de jquery ui, los datos se deben mandar como value y label
	}

	//PARA DATATABLES
	public function findMedicamentosDatatableSearch($start, $length, $search, $usuarioId){

	    return DB::table('medicamentos')->select('medicamentos.id', 'medicamentos.nombre', 'tipo', 'concentracion', 'unidades', 'medicamentos.created_at', 'presentacions.nombre as presentacion', 'laboratorios.nombre as laboratorio')->join('presentacions', 'presentacions.id', '=', 'medicamentos.presentacion_id')->join('laboratorios', 'laboratorios.id', '=', 'medicamentos.laboratorio_id')->where('medicamentos.user_id', $usuarioId)->where('medicamentos.nombre', 'like', '%'.$search.'%')->orWhere('tipo', 'like', '%'.$search.'%')->orWhere('concentracion', 'like', '%'.$search.'%')->orWhere('unidades', 'like', '%'.$search.'%')->orWhere('presentacions.nombre', 'like', '%'.$search.'%')->orWhere('laboratorios.nombre', 'like', '%'.$search.'%')->whereNull('medicamentos.deleted_at')->offset($start)->limit($length)->orderBy('id','DESC')->get();
	}

	public function findMedicamentosDatatableSearchNum($search, $usuarioId){

	    return DB::table('medicamentos')->select('medicamentos.id', 'medicamentos.nombre', 'tipo', 'concentracion', 'unidades', 'medicamentos.created_at', 'presentacions.nombre as presentacion', 'laboratorios.nombre as laboratorio')->join('presentacions', 'presentacions.id', '=', 'medicamentos.presentacion_id')->join('laboratorios', 'laboratorios.id', '=', 'medicamentos.laboratorio_id')->where('medicamentos.user_id', $usuarioId)->where('medicamentos.nombre', 'like', '%'.$search.'%')->orWhere('tipo', 'like', '%'.$search.'%')->orWhere('concentracion', 'like', '%'.$search.'%')->orWhere('unidades', 'like', '%'.$search.'%')->orWhere('presentacions.nombre', 'like', '%'.$search.'%')->orWhere('laboratorios.nombre', 'like', '%'.$search.'%')->whereNull('medicamentos.deleted_at')->orderBy('id','DESC')->get();
	}

	public function findMedicamentosDatatable($start, $length, $usuarioId){

	    return DB::table('medicamentos')->select('medicamentos.id', 'medicamentos.nombre', 'tipo', 'concentracion', 'unidades', 'medicamentos.created_at', 'presentacions.nombre as presentacion', 'laboratorios.nombre as laboratorio')->join('presentacions', 'presentacions.id', '=', 'medicamentos.presentacion_id')->join('laboratorios', 'laboratorios.id', '=', 'medicamentos.laboratorio_id')->where('medicamentos.user_id', $usuarioId)->whereNull('medicamentos.deleted_at')->offset($start)->limit($length)->orderBy('id','DESC')->get();
	}

	public function findMedicamentosDatatableNum($usuarioId){

	    return DB::table('medicamentos')->select('medicamentos.id', 'medicamentos.nombre', 'tipo', 'concentracion', 'unidades', 'medicamentos.created_at', 'presentacions.nombre as presentacion', 'laboratorios.nombre as laboratorio')->join('presentacions', 'presentacions.id', '=', 'medicamentos.presentacion_id')->join('laboratorios', 'laboratorios.id', '=', 'medicamentos.laboratorio_id')->where('medicamentos.user_id', $usuarioId)->whereNull('medicamentos.deleted_at')->orderBy('id','DESC')->get();
	}
	//END PARA DATATABLES

}