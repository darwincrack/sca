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

            ->leftJoin('sub_grupo_personal', 'Userinfo.idSubGrupo', '=', 'sub_grupo_personal.id')
            ->leftJoin('grupo_personal', 'Userinfo.idGrupo', '=', 'grupo_personal.id')
            ->orderBy('Userid','desc')
            ->select('Userid as Userid', 'UserCode AS UserCode', 'Name AS Name','grupo_personal.nombre as grupo_nombre', 'sub_grupo_personal.nombre as sub_grupo_nombre', 'Pwd', DB::raw('(select Fingerid from UserFinger where Userid= Userinfo.Userid and Fingerid=0) as huella1'), DB::raw('(select Fingerid from UserFinger where Userid= Userinfo.Userid and Fingerid=1) as huella2, cedula'));

        return $data->get();
        }
        else
        {
            $data = DB::table('Userinfo')
            ->where('Userid', $userID)
                ->leftJoin('sub_grupo_personal', 'Userinfo.idSubGrupo', '=', 'sub_grupo_personal.id')
            ->leftJoin('grupo_personal', 'Userinfo.idGrupo', '=', 'grupo_personal.id')
            ->select('Userid as Userid', 'UserCode AS UserCode', 'Name AS Name', 'idGrupo', 'idSubGrupo','Deptid', 'idGenero','grupo_personal.nombre as grupo_nombre', 'sub_grupo_personal.nombre as sub_grupo_nombre', 'Pwd', 'cedula')
            ->first();
        return $data;

        }
        

    }

    static public function insertar($usuario_nro,$nombre,$departamento,$grupo,$subgrupo,$idgenero,$cedula)
    {

        $userid = PersonalModels::last_userID();

        $lastInsertID= DB::table('Userinfo')->insertGetId(
            ['Userid' => $userid, 'UserCode' => $usuario_nro, 'Name' => $nombre, 'Deptid' => $departamento, 'idGrupo' => $grupo, 'idSubGrupo' => $subgrupo,'idGenero'=>$idgenero,'cedula'=>$cedula]
        );
        return  $userid;

    }


    static public function editar($id_personal,$usuario_nro,$nombre,$departamento,$grupo,$subgrupo,$idgenero,$cedula)
    {



        DB::table('Userinfo')
            ->where('Userid', $id_personal)
            ->update( ['UserCode' => $usuario_nro, 'Name' => $nombre, 'Deptid' => $departamento, 'idGrupo' => $grupo, 'idSubGrupo' => $subgrupo,'idGenero'=>$idgenero,'cedula'=>$cedula]);

    }



    static public function delete($id_personal)
    {


        $data = DB::table('UserShift')
            ->where('Userid', $id_personal)
            ->select('Schid')
            ->first();


        if(count($data)>0){

            
           $schedule_id=$data->Schid;
            DB::table('Schedule')
                ->where('Schid', $schedule_id)
                ->delete();

            DB::update("delete from TimeTable where  Timeid in ((select Timeid from SchTime where Schid='$schedule_id'))");


            DB::table('SchTime')
                ->where('Schid', $schedule_id)
                ->delete();

            DB::table('Lactancia')
                ->where('Schid', $schedule_id)
                ->delete();

        }
        


            DB::table('UserShift')
                ->where('Userid', $id_personal)
                ->delete();




                 DB::table('Userinfo')
                ->where('Userid', $id_personal)
                ->delete();

    }



    static public function last_userID()
    {

        $result=DB::table('Userinfo')->max('Userid');
        return $result+1;
    }




}