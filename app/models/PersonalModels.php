<?php
/**
 * Created by PhpStorm.
 * User: desarrollo
 * Date: 20/12/2016
 * Time: 17:20
 */

namespace App\models;

use DB;
use Auth;

class PersonalModels
{

    static  public function listar($userID=FALSE)
    {

        if(!$userID){

            $data = DB::table('Userinfo')
            /*           ->join('ciudad', 'procedencia.id_ciudad', '=', 'ciudad.id_ciudad')
                      ->join('tipo_procedencia', 'procedencia.id_tipo_procedencia', '=', 'tipo_procedencia.id_tipo_procedencia')
                     ->leftJoin('detalles_alquiler_procedencia', 'procedencia.id_procedencia', '=', 'detalles_alquiler_procedencia.id_procedencia')*/
            ->leftJoin('sub_grupo_personal', 'Userinfo.idSubGrupo', '=', 'sub_grupo_personal.id')
            ->leftJoin('grupo_personal', 'Userinfo.idGrupo', '=', 'grupo_personal.id')
            ->orderBy('Userid','desc')
            ->select('Userid as Userid', 'UserCode AS UserCode', 'Name AS Name','grupo_personal.nombre as grupo_nombre', 'sub_grupo_personal.nombre as sub_grupo_nombre');

        return $data->get();
        }
        else
        {
            $data = DB::table('Userinfo')
            ->where('Userid', $userID)
                ->leftJoin('sub_grupo_personal', 'Userinfo.idSubGrupo', '=', 'sub_grupo_personal.id')
            ->leftJoin('grupo_personal', 'Userinfo.idGrupo', '=', 'grupo_personal.id')
            ->select('Userid as Userid', 'UserCode AS UserCode', 'Name AS Name', 'idGrupo', 'idSubGrupo','Deptid', 'idGenero','grupo_personal.nombre as grupo_nombre', 'sub_grupo_personal.nombre as sub_grupo_nombre')
            ->first();
        return $data;

        }
        

    }

    static public function insertar($id_dispositivo,$usuario_nro,$nombre,$departamento,$grupo,$subgrupo,$idgenero)
    {
        $lastInsertID= DB::table('Userinfo')->insertGetId(
            ['Userid' => $id_dispositivo, 'UserCode' => $usuario_nro, 'Name' => $nombre, 'Deptid' => $departamento, 'idGrupo' => $grupo, 'idSubGrupo' => $subgrupo,'idGenero'=>$idgenero]
        );

    }


    static public function editar($id_personal,$usuario_nro,$nombre,$departamento,$grupo,$subgrupo,$idgenero)
    {



        DB::table('Userinfo')
            ->where('Userid', $id_personal)
            ->update( ['UserCode' => $usuario_nro, 'Name' => $nombre, 'Deptid' => $departamento, 'idGrupo' => $grupo, 'idSubGrupo' => $subgrupo,'idGenero'=>$idgenero]);

    }




    static public function show_personal($id_procedencia){

        $data = DB::table('procedencia')
            ->where('procedencia.id_procedencia', $id_procedencia)
            ->join('ciudad', 'procedencia.id_ciudad', '=', 'ciudad.id_ciudad')
            ->join('tipo_procedencia', 'procedencia.id_tipo_procedencia', '=', 'tipo_procedencia.id_tipo_procedencia')
            ->select('procedencia.id_procedencia as id_procedencia', 'procedencia.nombre AS nombre_procedencia', 'tipo_procedencia.nombre AS nombre_tipo_procedencia' , 'tipo_procedencia.id_tipo_procedencia AS id_tipo_procedencia','ciudad.nombre AS nombre_ciudad' ,'ciudad.id_ciudad AS id_ciudad','procedencia.fecha_alquiler','procedencia.activo','motivo', 'alquilado')
            ->first();
        return $data;

    }




}