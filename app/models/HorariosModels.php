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

class HorariosModels
{

    static  public function GetHorario($id_personal)
    {
            $data = DB::table('UserShift')
                ->select('SchTime.BeginDay as dia_semana', 'TimeTable.Intime AS hora_entrada', 'TimeTable.Outtime AS hora_salida', 'UserShift.BeginDate as inicio_ciclo', 'UserShift.EndDate as fin_ciclo')                ->join('Schedule', 'UserShift.Schid', '=', 'Schedule.Schid')
                ->join('SchTime', 'Schedule.Schid', '=', 'SchTime.Schid')
                ->join('TimeTable', 'SchTime.Timeid', '=', 'TimeTable.Timeid')
                ->where('UserShift.Userid', $id_personal);

            return $data->get();
    }





    static public function insertar($id_personal,$domingo_entrada,$domingo_salida,$lunes_entrada, $lunes_salida, $martes_entrada,$martes_salida,$miercoles_entrada,$miercoles_salida, $jueves_entrada,$jueves_salida,$viernes_entrada, $viernes_salida, $sabado_entrada, $sabado_salida, $inicio_asignacion,$fin_asignacion,$lactancia,$tiempo_gracia)

    {


        $lastInsertID_Schedule= DB::table('Schedule')->insertGetId(
            ['Schname' => $id_personal.'_ciclo', 'Cycles' => '1', 'Units' => '1']
        );


        if($domingo_entrada !='' and $domingo_salida !='')
        {
            $timename=$id_personal.'_DOMINGO';


            $lastInsertID= DB::table('TimeTable')->insertGetId(

                ['Timename' => $timename, 'Intime' => $domingo_entrada, 'Outtime' => $domingo_salida, 'BIntime' => HorariosModels::calcular_hora($domingo_entrada,'120','resta'), 'EIntime' => HorariosModels::calcular_hora($domingo_entrada,'120'), 'BOuttime' => HorariosModels::calcular_hora($domingo_salida,'120','resta'),'EOuttime'=>HorariosModels::calcular_hora($domingo_salida,'120'),'Latetime'=>$tiempo_gracia,'Leavetime'=>'0','WorkDays'=>'1','Longtime'=>HorariosModels::calcular_minutos($domingo_entrada,$domingo_salida),'MustIn'=>'1','MustOut'=>'1']

            );

            $lastInsertID= DB::table('SchTime')->insertGetId(
                ['Schid' => $lastInsertID_Schedule, 'BeginDay' => '0', 'Timeid' => $lastInsertID]
            );



        }

        if($lunes_entrada !='' and $lunes_salida !='')
        {
            $timename=$id_personal.'_LUNES';

            $lastInsertID= DB::table('TimeTable')->insertGetId(

                ['Timename' => $timename, 'Intime' => $lunes_entrada, 'Outtime' => $lunes_salida, 'BIntime' => HorariosModels::calcular_hora($lunes_entrada,'120','resta'), 'EIntime' => HorariosModels::calcular_hora($lunes_entrada,'120'), 'BOuttime' => HorariosModels::calcular_hora($lunes_salida,'120','resta'),'EOuttime'=>HorariosModels::calcular_hora($lunes_salida,'120'),'Latetime'=>$tiempo_gracia,'Leavetime'=>'0','WorkDays'=>'1','Longtime'=>HorariosModels::calcular_minutos($lunes_entrada,$lunes_salida),'MustIn'=>'1','MustOut'=>'1']

            );

            $lastInsertID= DB::table('SchTime')->insertGetId(
                ['Schid' => $lastInsertID_Schedule, 'BeginDay' => '1', 'Timeid' => $lastInsertID]
            );


        }

        if($martes_entrada !='' and $martes_salida !='')
        {
            $timename=$id_personal.'_MARTES';

            $lastInsertID= DB::table('TimeTable')->insertGetId(

                ['Timename' => $timename, 'Intime' => $martes_entrada, 'Outtime' => $martes_salida, 'BIntime' => HorariosModels::calcular_hora($martes_entrada,'120','resta'), 'EIntime' => HorariosModels::calcular_hora($martes_entrada,'120'), 'BOuttime' => HorariosModels::calcular_hora($martes_salida,'120','resta'),'EOuttime'=>HorariosModels::calcular_hora($martes_salida,'120'),'Latetime'=>$tiempo_gracia,'Leavetime'=>'0','WorkDays'=>'1','Longtime'=>HorariosModels::calcular_minutos($martes_entrada,$martes_salida),'MustIn'=>'1','MustOut'=>'1']

            );

            $lastInsertID= DB::table('SchTime')->insertGetId(
                ['Schid' => $lastInsertID_Schedule, 'BeginDay' => '2', 'Timeid' => $lastInsertID]
            );
        }



        if($miercoles_entrada !='' and $miercoles_salida !='')
    {
        $timename=$id_personal.'_MIERCOLES';

            $lastInsertID= DB::table('TimeTable')->insertGetId(

                ['Timename' => $timename, 'Intime' => $miercoles_entrada, 'Outtime' => $miercoles_salida, 'BIntime' => HorariosModels::calcular_hora($miercoles_entrada,'120','resta'), 'EIntime' => HorariosModels::calcular_hora($miercoles_entrada,'120'), 'BOuttime' => HorariosModels::calcular_hora($miercoles_salida,'120','resta'),'EOuttime'=>HorariosModels::calcular_hora($miercoles_salida,'120'),'Latetime'=>$tiempo_gracia,'Leavetime'=>'0','WorkDays'=>'1','Longtime'=>HorariosModels::calcular_minutos($miercoles_entrada,$miercoles_salida),'MustIn'=>'1','MustOut'=>'1']

            );

        $lastInsertID= DB::table('SchTime')->insertGetId(
            ['Schid' => $lastInsertID_Schedule, 'BeginDay' => '3', 'Timeid' => $lastInsertID]
        );
    }

        if($jueves_entrada !='' and $jueves_salida !='')
        {
            $timename=$id_personal.'_JUEVES';

            $lastInsertID= DB::table('TimeTable')->insertGetId(

                ['Timename' => $timename, 'Intime' => $jueves_entrada, 'Outtime' => $jueves_salida, 'BIntime' => HorariosModels::calcular_hora($jueves_entrada,'120','resta'), 'EIntime' => HorariosModels::calcular_hora($jueves_entrada,'120'), 'BOuttime' => HorariosModels::calcular_hora($jueves_salida,'120','resta'),'EOuttime'=>HorariosModels::calcular_hora($jueves_salida,'120'),'Latetime'=>$tiempo_gracia,'Leavetime'=>'0','WorkDays'=>'1','Longtime'=>HorariosModels::calcular_minutos($jueves_entrada,$jueves_salida),'MustIn'=>'1','MustOut'=>'1']

            );

            $lastInsertID= DB::table('SchTime')->insertGetId(
                ['Schid' => $lastInsertID_Schedule, 'BeginDay' => '4', 'Timeid' => $lastInsertID]
            );
        }


        if($viernes_entrada !='' and $viernes_salida !='')
        {
            $timename=$id_personal.'_VIERNES';

            $lastInsertID= DB::table('TimeTable')->insertGetId(

                ['Timename' => $timename, 'Intime' => $viernes_entrada, 'Outtime' => $viernes_salida, 'BIntime' => HorariosModels::calcular_hora($viernes_entrada,'120','resta'), 'EIntime' => HorariosModels::calcular_hora($viernes_entrada,'120'), 'BOuttime' => HorariosModels::calcular_hora($viernes_salida,'120','resta'),'EOuttime'=>HorariosModels::calcular_hora($viernes_salida,'120'),'Latetime'=>$tiempo_gracia,'Leavetime'=>'0','WorkDays'=>'1','Longtime'=>HorariosModels::calcular_minutos($viernes_entrada,$viernes_salida),'MustIn'=>'1','MustOut'=>'1']

            );

            $lastInsertID= DB::table('SchTime')->insertGetId(
                ['Schid' => $lastInsertID_Schedule, 'BeginDay' => '5', 'Timeid' => $lastInsertID]
            );
        }

        if($sabado_entrada !='' and $sabado_salida !='')
        {
            $timename=$id_personal.'_SABADO';

            $lastInsertID= DB::table('TimeTable')->insertGetId(

                ['Timename' => $timename, 'Intime' => $sabado_entrada, 'Outtime' => $sabado_salida, 'BIntime' => HorariosModels::calcular_hora($sabado_entrada,'120','resta'), 'EIntime' => HorariosModels::calcular_hora($sabado_entrada,'120'), 'BOuttime' => HorariosModels::calcular_hora($sabado_salida,'120','resta'),'EOuttime'=>HorariosModels::calcular_hora($sabado_salida,'120'),'Latetime'=>$tiempo_gracia,'Leavetime'=>'0','WorkDays'=>'1','Longtime'=>HorariosModels::calcular_minutos($sabado_entrada,$sabado_salida),'MustIn'=>'1','MustOut'=>'1']

            );


            $lastInsertID= DB::table('SchTime')->insertGetId(
                ['Schid' => $lastInsertID_Schedule, 'BeginDay' => '6', 'Timeid' => $lastInsertID]
            );
        }



        $lastInsertID= DB::table('UserShift')->insertGetId(
            ['Userid' => $id_personal, 'Schid' => $lastInsertID_Schedule, 'BeginDate' => $inicio_asignacion, 'EndDate' => $fin_asignacion]
        );





        if($lactancia==1){

        $lastInsertID= DB::table('Lactancia')->insertGetId(
            ['Userid' => $id_personal, 'Schid' => $lastInsertID_Schedule, 'BeginDate' => $inicio_asignacion, 'EndDate' => $fin_asignacion]
        );

        }

    }



    static public function editar($id_personal,$domingo_entrada,$domingo_salida,$lunes_entrada, $lunes_salida, $martes_entrada,$martes_salida,$miercoles_entrada,$miercoles_salida, $jueves_entrada,$jueves_salida,$viernes_entrada, $viernes_salida, $sabado_entrada, $sabado_salida, $inicio_asignacion,$fin_asignacion,$lactancia,$tiempo_gracia)

    {



        $data = DB::table('UserShift')
            ->where('Userid', $id_personal)
            ->select('Schid')
            ->first();


        if(count($data)>0){
            $schedule_id=$data->Schid;


            DB::table('UserShift')
                ->where('Userid', $id_personal)
                ->delete();

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



            HorariosModels::insertar($id_personal,$domingo_entrada,$domingo_salida,$lunes_entrada, $lunes_salida, $martes_entrada,$martes_salida,$miercoles_entrada,$miercoles_salida, $jueves_entrada,$jueves_salida,$viernes_entrada, $viernes_salida, $sabado_entrada, $sabado_salida, $inicio_asignacion,$fin_asignacion,$lactancia,$tiempo_gracia);



        }


    }


public static function lactancia($personaID=False){

    if($personaID)
    {

       $data =   DB::select(DB::raw("select count(*) as activo from lactancia where  CONVERT (date, GETDATE()) between BeginDate and EndDate"));


                return $data;
    }
    else
    {

    }

}



static public function calcular_hora($horaInicial,$minutoAnadir,$operacion=False)
{

    $segundos_horaInicial=strtotime($horaInicial);  
    $segundos_minutoAnadir=$minutoAnadir*60;

    if(trim($operacion)=='resta'){

        $hora= date("H:i",$segundos_horaInicial-$segundos_minutoAnadir);

        }
        else{

        $hora= date("H:i",$segundos_horaInicial+$segundos_minutoAnadir);
     
    }

    return $hora;

}


static public function calcular_minutos($fecha_i, $fecha_f)
{
    $minutos = (strtotime($fecha_i)-strtotime($fecha_f))/60;
    $minutos = abs($minutos); $minutos = floor($minutos);
    return $minutos;
}




}