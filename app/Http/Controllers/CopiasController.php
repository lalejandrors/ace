<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Ace\CopiaSeguridad;
use Ace\Repositories\CopiasRepository;
use Validator;
use DB;

class CopiasController extends Controller
{
    private $copias;

    public function __construct(CopiasRepository $copias)
    {
        $this->copias = $copias;
    }

    public function listar()
    {
        $copias = CopiaSeguridad::orderBy('id','DESC')->paginate(4);

        return view('panel.copia.listar', compact('copias'));
    }

    public function crear()
    {   
        return view('panel.copia.crear');
    }

    public function almacenar(Request $request)
    {
        //validamos los campos enviados
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|min:2|max:50',
            'descripcion' => 'nullable|min:2|max:250',
        ], [], [
            'nombre' => '"Nombre"',
            'descripcion' => '"Descripción"',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $copia = CopiaSeguridad::create($request->all());

        $tables = $this->copias->obtenerTablas();//obtenemos el listado de tablas existentes en la base de datos

        foreach ($tables as $table) {
            if($table->Tables_in_ace != 'cie10s' && $table->Tables_in_ace != 'ciudads' && $table->Tables_in_ace != 'departamentos' && $table->Tables_in_ace != 'eps' && $table->Tables_in_ace != 'migrations' && $table->Tables_in_ace != 'perfils' && $table->Tables_in_ace != 'permisos' && $table->Tables_in_ace != 'via_medicamentos' && $table->Tables_in_ace != 'presentacions' && $table->Tables_in_ace != 'copia_seguridads' && $table->Tables_in_ace != 'limite_usuarios'){//descartamos las tablas que no deben variar nunca

                //generamos el path donde se va a crear el backup de la tabla
                $nombreTabla = $table->Tables_in_ace;
                $preCopiaPath = public_path().'/backup'.'/'.$nombreTabla.'COPYCOD'.$copia->id.'.sql';
                $copiaPath = str_replace('\\','/',$preCopiaPath);//cambiamos los slash por los permitidos
                $this->copias->crearBackup($copiaPath, $nombreTabla);
            }
        }

        //se mira si ya se tiene el limite de 100 copias creadas, para eliminar la mas antigua y ahorrar la memoria
        $numeroCopias = CopiaSeguridad::count();

        if((int)$numeroCopias == 101){
            $copiaAEliminar = CopiaSeguridad::orderBy('id','ASC')->first();

            //eliminamos tambien los archivos sql generados anteriormente
            foreach ($tables as $table) {
                if($table->Tables_in_ace != 'cie10s' && $table->Tables_in_ace != 'ciudads' && $table->Tables_in_ace != 'departamentos' && $table->Tables_in_ace != 'eps' && $table->Tables_in_ace != 'migrations' && $table->Tables_in_ace != 'perfils' && $table->Tables_in_ace != 'permisos' && $table->Tables_in_ace != 'via_medicamentos' && $table->Tables_in_ace != 'presentacions' && $table->Tables_in_ace != 'copia_seguridads' && $table->Tables_in_ace != 'limite_usuarios'){//descartamos las tablas que no tienen backup

                    //generamos el path de cada uno de los archivos a eliminar
                    $nombreTabla = $table->Tables_in_ace;
                    $preCopiaPath = public_path().'/backup'.'/'.$nombreTabla.'COPYCOD'.$copiaAEliminar->id.'.sql';
                    $copiaPath = str_replace('\\','/',$preCopiaPath);//cambiamos los slash por los permitidos
                    \File::delete($copiaPath);
                }
            }

            $copiaAEliminar->delete();//elimina el registro en base de datos
        }

        Flash::success('La copia de seguridad ha sido creada de manera exitosa.');
        return redirect()->route('panel.copia.listar');
    }

    public function restablecer($id)
    {
        $copia = CopiaSeguridad::find($id);

        $tables = $this->copias->obtenerTablas();//obtenemos el listado de tablas existentes en la base de datos

        foreach ($tables as $table) {
            if($table->Tables_in_ace != 'cie10s' && $table->Tables_in_ace != 'ciudads' && $table->Tables_in_ace != 'departamentos' && $table->Tables_in_ace != 'eps' && $table->Tables_in_ace != 'migrations' && $table->Tables_in_ace != 'perfils' && $table->Tables_in_ace != 'permisos' && $table->Tables_in_ace != 'via_medicamentos' && $table->Tables_in_ace != 'presentacions' && $table->Tables_in_ace != 'copia_seguridads' && $table->Tables_in_ace != 'limite_usuarios'){//descartamos las tablas que no deben variar nunca

                //generamos el path donde se va a crear el backup de la tabla
                $nombreTabla = $table->Tables_in_ace;
                $preCopiaPath = public_path().'/backup'.'/'.$nombreTabla.'COPYCOD'.$copia->id.'.sql';
                $copiaPath = str_replace('\\','/',$preCopiaPath);//cambiamos los slash por los permitidos
                $this->copias->restaurarBackup($copiaPath, $nombreTabla);
            }
        }

        Flash::success('La copia de seguridad ha sido reestablecida de manera exitosa.');
        return redirect()->route('panel.copia.listar');
    }

    //gestion de copias de seguridad manuales
    public function descargar()
    {
        $con = DB::connection()->getpdo();

        $txtTabla = "";
        $date = date("Y-m-d-H-i-s", time() + 3600*2);
        $archivoBackup = "ace_"."$date".".csv";;
        $queryTablas = $con->prepare("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = 'ace'");
        $queryTablas->execute();

        while($tabla = $queryTablas->fetchObject()){
            $nombreTabla = $tabla->TABLE_NAME;
            
            if($nombreTabla == "cie10s" || $nombreTabla == "ciudads" || $nombreTabla == "departamentos" || $nombreTabla == "eps"
                || $nombreTabla == "migrations"  || $nombreTabla == "perfils" || $nombreTabla == "permisos" || $nombreTabla == "via_medicamentos" || $nombreTabla == "presentacions" || $nombreTabla == "copia_seguridads" || $nombreTabla == "limite_usuarios"){
               continue;
            }

            $queryCamposTabla = $con->prepare("SHOW COLUMNS FROM $nombreTabla");
            $queryCamposTabla->execute();
            $queryValoresTabla = $con->prepare("SELECT * FROM $nombreTabla");
            $queryValoresTabla->execute();

            while($valoresTabla = $queryValoresTabla->fetchObject()){
                $txtTabla .= "*****$nombreTabla";

                foreach ($valoresTabla as $key => $value) {
                    $value2=str_replace("'", "\'", $value);
                    $txtTabla .= "|||||;$value2";
                }
            }
        }

        $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
        $plaintext = $txtTabla;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext, MCRYPT_MODE_CBC, $iv);
        $ciphertext = $iv . $ciphertext;
        $ciphertext_base64 = base64_encode($ciphertext);
        $handle = fopen("$archivoBackup", "w");
        fwrite($handle, $ciphertext_base64);
        fclose($handle);

        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=".$archivoBackup."");

        readfile($archivoBackup);
        unlink($archivoBackup);
    }

    public function cargar(Request $request)
    {     
        //validamos los campos enviados
        $validator = Validator::make($request->all(), [
            'path' => 'required|file|mimes:csv,txt',
        ], [], [
            'path' => '"Archivo .csv"',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $filename = $request['path']->getPathName();
        $handle = fopen($filename, "r");

        while(($line = fgets($handle)) !== false){
            $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
            $ciphertext_dec = base64_decode($line);
            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            $iv_dec = substr($ciphertext_dec, 0, $iv_size);
            $ciphertext_dec = substr($ciphertext_dec, $iv_size);
            $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
        }

        fclose($handle);

        $outerARR = explode("*****", $plaintext_dec);
        $a = array();
        $y=0;

        foreach($outerARR as $arrvalue){
            $x=0;
            $innerarr = explode("|||||;", $arrvalue);

            foreach($innerarr as $v){
                $a[$y][$x++] = $v;
            }

            $y++;
        }

        $i=0;
        $j=0;
        $table_name="";
        $query="";
        $insert = array();
        $truncate = array();

        for ($i = 1; $i < sizeOf($a); $i++) {
          $query="";
          $table_name = $a[$i][0];

            for($j = 1; $j < sizeOf($a[$i]); $j++){

                if($j==sizeOf($a[$i])-1){
                    $query .= "'" . $a[$i][$j] . "'";
                }else{
                    $query .= "'" . $a[$i][$j] . "'" . ",";
                }
            }

            if($query==""){
                continue;
            }else{
                $queryRefactorPre = str_replace("''", "NULL", $query);
                $queryRefactorFinal = str_replace("\x00", "", $queryRefactorPre);
                $insert[] = $table_name . " VALUES ". "(" . $queryRefactorFinal . ")";
                $truncate[] = $a[$i][0];
            }
        }

        $truncate=array_unique($truncate);
        $con = DB::connection()->getpdo();

        DB::update(DB::raw("SET FOREIGN_KEY_CHECKS = 0"));

        foreach($truncate as $value){
            $queryTruncate = $con->prepare("TRUNCATE TABLE ". $value);
            $queryTruncate->execute();
        }

        foreach($insert as $value){
            $queryInsert = $con->prepare("INSERT INTO ". $value);
            $queryInsert->execute();
        }

        DB::update(DB::raw("SET FOREIGN_KEY_CHECKS = 1"));

        Flash::success('La copia de seguridad ha sido reestablecida de manera exitosa.');
        return redirect()->route('panel.copia.listar');
    }

}
