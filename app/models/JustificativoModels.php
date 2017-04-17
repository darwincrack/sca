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


class JustificativoModels
{

    static  public function listar()
    {
        $data = DB::table('UserLeave')
           
            ->join('Userinfo', 'UserLeave.Userid', '=', 'Userinfo.Userid')

            ->leftJoin('LeaveClass', 'UserLeave.LeaveClassid', '=', 'LeaveClass.Classid');
            //->select('Lsh','Classname');
        return $data;

    }


    static public function insertar($Userid,$fecha,$hora,$tipo_falta,$tipojustificativo,$motivo)
    {

    $data_horarioInOut=JustificativoModels::horarioInOut($Userid,$fecha);
     //  $fecha= date('Y-m-d', strtotime($fecha));
 $fecha= date('Y-d-m', strtotime($fecha));
//inasistencia
if($tipo_falta=='11')
{
    $BeginTime=$fecha.' '.$data_horarioInOut->Intime;
    $EndTime= $fecha.' '.$data_horarioInOut->Outtime;
//$BeginTime='2017-04-15 08:00:00.000';
//$EndTime='2017-04-15 15:00:00.000';
}
//entada tarde
elseif($tipo_falta=='2')
{
    $BeginTime  =   $fecha.' '.$data_horarioInOut->Intime;
    $EndTime    =   $fecha.' '.$hora;
}

//No marco entrada
        elseif($tipo_falta=='3')
        {
            $BeginTime  =   $fecha.' '.$data_horarioInOut->Intime;
            $EndTime    =   $fecha.' '.$data_horarioInOut->Intime;
        }


//salida temprano
elseif($tipo_falta=='7')
{
 
    $BeginTime    =   $fecha.' '.$hora;
    $EndTime  =   $fecha.' '.$data_horarioInOut->Outtime;
}

//no marco salida
        elseif($tipo_falta=='8')
        {

            $BeginTime    =   $fecha.' '.$data_horarioInOut->Outtime;
            $EndTime      =   $fecha.' '.$data_horarioInOut->Outtime;
        }
       $id= DB::table('UserLeave')->insertGetId(
            ['Userid' => $Userid, 'BeginTime'=>"$BeginTime",'EndTime'=>"$EndTime",'LeaveClassid'=>$tipojustificativo,'Whys'=>$motivo, 'tipo_falta'=>$tipo_falta]
        );
        return $id;

    }



static public function horarioInOut($Userid, $fecha_marcaje)
{
    $data = DB::table('UserShift')

         ->where('BeginDay', DB::raw("(CASE datepart(DW,'$fecha_marcaje') WHEN 7 THEN 0 ELSE datepart(DW,'$fecha_marcaje') END)"))
         ->where('UserShift.Userid', $Userid)
         ->join('SchTime', 'userShift.Schid', '=', 'SchTime.Schid')
         ->join('TimeTable', 'SchTime.Timeid', '=', 'TimeTable.Timeid')
         ->select('Intime','Outtime')
         ->first();
        return $data;       
}

    static public function editar($id_justificacion,$nombre)
    {
        DB::table('LeaveClass')
             ->where('Classid', $id_justificacion)
            ->update( ['Classname' => $nombre]);

    }



    static public function show_justificacion($id_justificacion){


        $data = DB::table('LeaveClass')
            ->where('Classid', $id_justificacion)
            ->select('Classid','Classname')
            ->first();
        return $data;

    }


    static  public function delete($id_justificativo){

        DB::table('UserLeave')
            ->where('Lsh', $id_justificativo)
            ->delete();
    }


    static public function pdf($id_justificativo)
    {
       $data = DB::table('userLeave')
       ->where('Lsh', $id_justificativo)
       ->join('Userinfo', 'UserLeave.Userid', '=', 'Userinfo.Userid')
       ->leftJoin('grupo_personal', 'Userinfo.idGrupo', '=', 'grupo_personal.id')
       ->leftJoin('LeaveClass', 'UserLeave.LeaveClassid', '=', 'LeaveClass.Classid') 
       ->select('grupo_personal.nombre as departamento','Userinfo.Name','Userinfo.cedula',DB::raw("FORMAT (UserLeave.BeginTime, 'dd-MM-yyyy') as fecha"),DB::raw("FORMAT(cast(UserLeave.BeginTime as time), N'hh\:mm') as hora_entrada"),DB::raw("FORMAT(cast(UserLeave.EndTime as time), N'hh\:mm') as hora_salida"),'UserLeave.tipo_falta','Whys as motivo_omision','LeaveClass.Classname as tipo_justificativo')
         ->first();
         return $data;
    }

}