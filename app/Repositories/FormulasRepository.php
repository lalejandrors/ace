<?php 

namespace Ace\Repositories;

use DB;

class FormulasRepository{

	//PARA DATATABLES
	public function findFormulasDatatableSearch($start, $length, $search, $usuarioId){

	    return DB::table('formulas')->select('formulas.id', 'formulas.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'formulas.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'formulas.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'formulas.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'formulas.control_id')->leftJoin('sesions', 'sesions.id', '=', 'formulas.sesion_id')->where('formulas.user_id', $usuarioId)->where('formulas.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->offset($start)->limit($length)->orderBy('formulas.id','DESC')->get();
	}

	public function findFormulasDatatableSearchNum($search, $usuarioId){

	    return DB::table('formulas')->select('formulas.id', 'formulas.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'formulas.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'formulas.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'formulas.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'formulas.control_id')->leftJoin('sesions', 'sesions.id', '=', 'formulas.sesion_id')->where('formulas.user_id', $usuarioId)->where('formulas.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->orderBy('formulas.id','DESC')->get();
	}

	public function findFormulasDatatable($start, $length, $usuarioId){

	    return DB::table('formulas')->select('formulas.id', 'formulas.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'formulas.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'formulas.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'formulas.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'formulas.control_id')->leftJoin('sesions', 'sesions.id', '=', 'formulas.sesion_id')->where('formulas.user_id', $usuarioId)->offset($start)->limit($length)->orderBy('formulas.id','DESC')->get();
	}

	public function findFormulasDatatableNum($usuarioId){

	    return DB::table('formulas')->select('formulas.id', 'formulas.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'formulas.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'formulas.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'formulas.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'formulas.control_id')->leftJoin('sesions', 'sesions.id', '=', 'formulas.sesion_id')->where('formulas.user_id', $usuarioId)->orderBy('formulas.id','DESC')->get();
	}
	//END PARA DATATABLES

}