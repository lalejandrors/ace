<?php 

namespace Ace\Repositories;

use DB;

class IncapacidadesRepository{

	//PARA DATATABLES
	public function findIncapacidadesDatatableSearch($start, $length, $search, $usuarioId){

	    return DB::table('incapacidad_medicas')->select('incapacidad_medicas.id', 'incapacidad_medicas.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'incapacidad_medicas.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'incapacidad_medicas.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'incapacidad_medicas.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'incapacidad_medicas.control_id')->leftJoin('sesions', 'sesions.id', '=', 'incapacidad_medicas.sesion_id')->where('incapacidad_medicas.user_id', $usuarioId)->where('incapacidad_medicas.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->offset($start)->limit($length)->orderBy('incapacidad_medicas.id','DESC')->get();
	}

	public function findIncapacidadesDatatableSearchNum($search, $usuarioId){

	    return DB::table('incapacidad_medicas')->select('incapacidad_medicas.id', 'incapacidad_medicas.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'incapacidad_medicas.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'incapacidad_medicas.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'incapacidad_medicas.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'incapacidad_medicas.control_id')->leftJoin('sesions', 'sesions.id', '=', 'incapacidad_medicas.sesion_id')->where('incapacidad_medicas.user_id', $usuarioId)->where('incapacidad_medicas.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->orderBy('incapacidad_medicas.id','DESC')->get();
	}

	public function findIncapacidadesDatatable($start, $length, $usuarioId){

	    return DB::table('incapacidad_medicas')->select('incapacidad_medicas.id', 'incapacidad_medicas.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'incapacidad_medicas.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'incapacidad_medicas.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'incapacidad_medicas.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'incapacidad_medicas.control_id')->leftJoin('sesions', 'sesions.id', '=', 'incapacidad_medicas.sesion_id')->where('incapacidad_medicas.user_id', $usuarioId)->offset($start)->limit($length)->orderBy('incapacidad_medicas.id','DESC')->get();
	}

	public function findIncapacidadesDatatableNum($usuarioId){

	    return DB::table('incapacidad_medicas')->select('incapacidad_medicas.id', 'incapacidad_medicas.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'incapacidad_medicas.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'incapacidad_medicas.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'incapacidad_medicas.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'incapacidad_medicas.control_id')->leftJoin('sesions', 'sesions.id', '=', 'incapacidad_medicas.sesion_id')->where('incapacidad_medicas.user_id', $usuarioId)->orderBy('incapacidad_medicas.id','DESC')->get();
	}
	//END PARA DATATABLES

}