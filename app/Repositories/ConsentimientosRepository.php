<?php 

namespace Ace\Repositories;

use DB;

class ConsentimientosRepository{

	//PARA DATATABLES
	public function findConsentimientosDatatableSearch($start, $length, $search, $usuarioId){

	    return DB::table('consentimientos')->select('consentimientos.id', 'consentimientos.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'consentimientos.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'consentimientos.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'consentimientos.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'consentimientos.control_id')->leftJoin('sesions', 'sesions.id', '=', 'consentimientos.sesion_id')->where('consentimientos.user_id', $usuarioId)->where('consentimientos.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->offset($start)->limit($length)->orderBy('consentimientos.id','DESC')->get();
	}

	public function findConsentimientosDatatableSearchNum($search, $usuarioId){

	    return DB::table('consentimientos')->select('consentimientos.id', 'consentimientos.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'consentimientos.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'consentimientos.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'consentimientos.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'consentimientos.control_id')->leftJoin('sesions', 'sesions.id', '=', 'consentimientos.sesion_id')->where('consentimientos.user_id', $usuarioId)->where('consentimientos.numero', 'like', '%'.$search.'%')->orWhere('pacientes.identificacion', 'like', '%'.$search.'%')->orWhere('pacientes.nombres', 'like', '%'.$search.'%')->orWhere('pacientes.apellidos', 'like', '%'.$search.'%')->orderBy('consentimientos.id','DESC')->get();
	}

	public function findConsentimientosDatatable($start, $length, $usuarioId){

	    return DB::table('consentimientos')->select('consentimientos.id', 'consentimientos.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'consentimientos.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'consentimientos.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'consentimientos.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'consentimientos.control_id')->leftJoin('sesions', 'sesions.id', '=', 'consentimientos.sesion_id')->where('consentimientos.user_id', $usuarioId)->offset($start)->limit($length)->orderBy('consentimientos.id','DESC')->get();
	}

	public function findConsentimientosDatatableNum($usuarioId){

	    return DB::table('consentimientos')->select('consentimientos.id', 'consentimientos.numero', 'pacientes.identificacion', 'pacientes.nombres', 'pacientes.apellidos', 'consentimientos.created_at', 'historia_clinicas.numero as historia', 'historia_clinicas.id as historiaId', 'controls.numero as control', 'controls.id as controlId', 'sesions.numero as sesion', 'sesions.id as sesionId')->join('pacientes', 'pacientes.id', '=', 'consentimientos.paciente_id')->leftJoin('historia_clinicas', 'historia_clinicas.id', '=', 'consentimientos.historiaClinica_id')->leftJoin('controls', 'controls.id', '=', 'consentimientos.control_id')->leftJoin('sesions', 'sesions.id', '=', 'consentimientos.sesion_id')->where('consentimientos.user_id', $usuarioId)->orderBy('consentimientos.id','DESC')->get();
	}
	//END PARA DATATABLES

}