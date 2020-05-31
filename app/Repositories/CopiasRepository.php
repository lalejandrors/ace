<?php 

namespace Ace\Repositories;

use DB;

class CopiasRepository{

	public function obtenerTablas(){

	    //obtengo el listado de tablas de la base de datos
	    $query = "SHOW TABLES";

	    return DB::select(DB::raw($query));
	}

	public function crearBackup($path, $table){

	    //para crear el backup de la tabla elegida de la base de datos
	    $query = "SELECT * INTO OUTFILE '$path' FROM $table";

	    return DB::select(DB::raw($query));
	}

	public function restaurarBackup($path, $table){

	    //para cargar el backup de la tabla elegida en la base de datos, es necesario truncar la tabla antes de volverla a llenar, ignorando las llaves foraneas
	    $query1 = "SET FOREIGN_KEY_CHECKS = 0";
	    $query2 = "TRUNCATE $table";
	    $query3 = "SET FOREIGN_KEY_CHECKS = 1";
	    $query4 = "LOAD DATA LOCAL INFILE '$path' INTO TABLE $table";

	    DB::update(DB::raw($query1));
	    DB::update(DB::raw($query2));
	    DB::update(DB::raw($query3));

	    return DB::connection()->getpdo()->exec($query4);
	}
}