<?php 

namespace Ace\Repositories;

use DB;

class UsersRepository{

	public function obtenerMedicos(){

	    //para obtener los medicos y llenar el select en la gestion de usuarios, teniendo en cuenta que ignore los que encuentre como eliminados ya que usamos DB
	    return DB::table('users')->join('medicos', 'medicos.id', '=', 'medico_id')->whereNull('medicos.deleted_at')->whereNull('users.deleted_at')->where('perfil_id','1')->orWhere('perfil_id','2')->orderBy('nombres','DESC')->pluck('nombres','medicos.id');
	}

	public function findMedicosUsuariosDatatable($usuarioId){

	    return DB::table('users_medicos')->select('users.nombres', 'users.apellidos')->join('medicos', 'users_medicos.medico_id', '=', 'medicos.id')->join('users', 'medicos.id', '=', 'users.medico_id')->where('user_id', $usuarioId)->whereNull('users.deleted_at')->orderBy('users.id','DESC')->get();
	}

	//PARA DATATABLES
	public function findUsersDatatableSearch($start, $length, $search){

	    return DB::table('users')->select('users.id', 'users.nombres', 'users.apellidos', 'users.username', 'users.perfil_id', 'users.activo', 'perfils.nombre as perfil', 'users.created_at')->join('perfils', 'perfils.id', '=', 'users.perfil_id')->where('users.nombres', 'like', '%'.$search.'%')->orWhere('users.apellidos', 'like', '%'.$search.'%')->orWhere('users.username', 'like', '%'.$search.'%')->orWhere('perfils.nombre', 'like', '%'.$search.'%')->whereNull('users.deleted_at')->offset($start)->limit($length)->orderBy('users.id','DESC')->get();
	}

	public function findUsersDatatableSearchNum($search){

	    return DB::table('users')->select('users.id', 'users.nombres', 'users.apellidos', 'users.username', 'users.perfil_id', 'users.activo', 'perfils.nombre as perfil', 'users.created_at')->join('perfils', 'perfils.id', '=', 'users.perfil_id')->where('users.nombres', 'like', '%'.$search.'%')->orWhere('users.apellidos', 'like', '%'.$search.'%')->orWhere('users.username', 'like', '%'.$search.'%')->orWhere('perfils.nombre', 'like', '%'.$search.'%')->whereNull('users.deleted_at')->orderBy('users.id','DESC')->get();
	}

	public function findUsersDatatable($start, $length){

	    return DB::table('users')->select('users.id', 'users.nombres', 'users.apellidos', 'users.username', 'users.perfil_id', 'users.activo', 'perfils.nombre as perfil', 'users.created_at')->join('perfils', 'perfils.id', '=', 'users.perfil_id')->whereNull('users.deleted_at')->offset($start)->limit($length)->orderBy('users.id','DESC')->get();
	}

	public function findUsersDatatableNum(){

	    return DB::table('users')->select('users.id', 'users.nombres', 'users.apellidos', 'users.username', 'users.perfil_id', 'users.activo', 'perfils.nombre as perfil', 'users.created_at')->join('perfils', 'perfils.id', '=', 'users.perfil_id')->whereNull('users.deleted_at')->orderBy('users.id','DESC')->get();
	}
	//END PARA DATATABLES

}