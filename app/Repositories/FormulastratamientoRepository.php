<?php 

namespace Ace\Repositories;

use DB;

class FormulastratamientoRepository{

	//PARA DATATABLES
	public function findFormulasTratamientoDatatableSearch($start, $length, $search, $usuarioId){

	    return DB::table('formula_tratamientos')->select('formula_tratamientos.id', 'formula_tratamientos.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'formula_tratamientos.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'formula_tratamientos.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'formula_tratamientos.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'formula_tratamientos.control_id')->leftJoin('sesions', 'sesions.id', '=', 'formula_tratamientos.sesion_id')->where('formula_tratamientos.user_id', $usuarioId)->where('formula_tratamientos.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->offset($start)->limit($length)->orderBy('formula_tratamientos.id','DESC')->get();
	}

	public function findFormulasTratamientoDatatableSearchNum($search, $usuarioId){

	    return DB::table('formula_tratamientos')->select('formula_tratamientos.id', 'formula_tratamientos.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'formula_tratamientos.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'formula_tratamientos.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'formula_tratamientos.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'formula_tratamientos.control_id')->leftJoin('sesions', 'sesions.id', '=', 'formula_tratamientos.sesion_id')->where('formula_tratamientos.user_id', $usuarioId)->where('formula_tratamientos.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->orderBy('formula_tratamientos.id','DESC')->get();
	}

	public function findFormulasTratamientoDatatable($start, $length, $usuarioId){

	    return DB::table('formula_tratamientos')->select('formula_tratamientos.id', 'formula_tratamientos.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'formula_tratamientos.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'formula_tratamientos.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'formula_tratamientos.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'formula_tratamientos.control_id')->leftJoin('sesions', 'sesions.id', '=', 'formula_tratamientos.sesion_id')->where('formula_tratamientos.user_id', $usuarioId)->offset($start)->limit($length)->orderBy('formula_tratamientos.id','DESC')->get();
	}

	public function findFormulasTratamientoDatatableNum($usuarioId){

	    return DB::table('formula_tratamientos')->select('formula_tratamientos.id', 'formula_tratamientos.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'formula_tratamientos.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'formula_tratamientos.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'formula_tratamientos.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'formula_tratamientos.control_id')->leftJoin('sesions', 'sesions.id', '=', 'formula_tratamientos.sesion_id')->where('formula_tratamientos.user_id', $usuarioId)->orderBy('formula_tratamientos.id','DESC')->get();
	}
	//END PARA DATATABLES

}