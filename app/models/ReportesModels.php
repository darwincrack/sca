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

class ReportesModels
{

    static  public function general()
    {

 //$data=DB::select(DB::raw("horario"));
 $data=DB::select(DB::raw("
DECLARE @startDate DATE, @endDate DATE
SELECT @startDate = cast(GETDATE() as date), @endDate = cast(GETDATE() as date);

WITH origen AS
(select  Logid, Userid,
CheckTime,

CAST(CheckTime as time) as hora,
CAST(CheckTime as date) as fecha,
datepart(DW,CheckTime) as dia_semana,
(select top 1 '1'  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as time) between TimeTable.BIntime and TimeTable.EIntime and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as rango_entrada,
(select top 1 '1'  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as time) between TimeTable.BOuttime and TimeTable.EOuttime and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as rango_salida,

--hora entrada

(select top 1 TimeTable.Intime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and   BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as hora_entrada,


-- minimo de entrada
(select top 1 TimeTable.BIntime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and   BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as minimo_entrada,


--maximo de entrada
(select top 1 TimeTable.EIntime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and   BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as maximo_entrada,

-- hora de salida
(select top 1 TimeTable.Outtime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and   BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as hora_salida,



-- minimo de salida
(select top 1 TimeTable.BOuttime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and   BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as minimo_salida,


-- maximo salida
(select top 1 TimeTable.EOuttime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and   BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as maximo_salida,




IIF(cast(Checkinout.CheckTime as time) >='11:00' and cast(Checkinout.CheckTime as time)<'11:49' ,'1',NULL) as rango_salida_almuerzo,
IIF(cast(Checkinout.CheckTime as time) >='11:50' and cast(Checkinout.CheckTime as time)<='12:30' ,'1',NULL) as rango_entrada_almuerzo,

(select count(*)  from Lactancia where CAST(Checkinout.CheckTime as date) between Lactancia.BeginDate and Lactancia.EndDate) as Lactancia,


IIF(cast(Checkinout.CheckTime as time) >'12:20' and (cast(Checkinout.CheckTime as time) >='11:00' and cast(Checkinout.CheckTime as time)<='12:30') ,'TRUE','FALSE') as entrada_almuerzo_tarde,

 

 (select count(*) from holiday where CAST(Checkinout.CheckTime as date) between  CAST(BDate as date) and dateadd(day,CASE Days WHEN 1 THEN 0 ELSE Days END,CAST(BDate as date))) as feriado,


-- hora de entrada
 (SELECT cast(CASE WHEN (select count(*)  from Lactancia where CAST(Checkinout.CheckTime as date) between Lactancia.BeginDate and Lactancia.EndDate and periodo='1')=0 THEN 
 (select top 1 Intime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) 
 ELSE 
 (select top 1 dateadd(minute,90,Intime)  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END))  END as time)) as hora_entrada_con_lactancia,

 --entrada_tarde

  IIF (CAST(CheckTime as time)  >  (SELECT cast(CASE WHEN (select count(*)  from Lactancia where CAST(Checkinout.CheckTime as date) between Lactancia.BeginDate and Lactancia.EndDate and periodo='1')=0 THEN 
 (select top 1 dateadd(minute,(select top 1 tiempo_gracia from configuracion),Intime)  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) 
 ELSE 
 (select top 1 dateadd(minute,90,Intime)  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END))  END as time)), 'TRUE', 'FALSE' ) AS entrada_tarde_con_lactancia,

 -- hora de salida
 (SELECT cast(CASE WHEN (select count(*)  from Lactancia where CAST(Checkinout.CheckTime as date) between Lactancia.BeginDate and Lactancia.EndDate and periodo='2')=0 THEN 
 (select top 1 Outtime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) 
 ELSE 
 (select top 1 dateadd(minute,-90,Outtime)  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END))  END as time)) as hora_salida_con_lactancia,


  --salida_temprano

 IIF (CAST(CheckTime as time)  <  (SELECT cast(CASE WHEN (select count(*)  from Lactancia where CAST(Checkinout.CheckTime as date) between Lactancia.BeginDate and Lactancia.EndDate and periodo='2')=0 THEN 
 (select top 1 Outtime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) 
 ELSE 
 (select top 1 dateadd(minute,-90,Outtime)  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END))  END as time)), 'TRUE', 'FALSE' ) AS salida_temprano_con_lactancia


from Checkinout


--from Checkinout 

)
, 

manager_cte as  (
select * from origen where origen.feriado=0
)
,
-- cuando no marco entradas
manager_cte3 as 
(
 select '' as 'logid',cast(CheckTime as date) as 'fecha', Userid,hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',
(SELECT top 1 '1' FROM 
Checkinout v
 where  v.Userid=manager_cte.Userid and 
  cast(v.CheckTime as date) = cast(manager_cte.CheckTime as date) and 
  cast(v.CheckTime as time) between cast(minimo_entrada as time) and
 cast(maximo_entrada as time)) as 'marco_entrada'

from manager_cte

group by Userid,cast(CheckTime as date),minimo_entrada,maximo_entrada, hora_entrada,hora_salida


)
,
manager_cte4 as
(
select * from manager_cte3 where marco_entrada is null
)
,

-- cuando no marco salida
manager_cte5 as
(

 select '' as 'logid',cast(CheckTime as date) as 'fecha', Userid, hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',
(SELECT top 1 '1' FROM 
Checkinout v
 where  v.Userid=manager_cte.Userid and 
  cast(v.CheckTime as date) = cast(manager_cte.CheckTime as date) and 
  cast(v.CheckTime as time) between cast(minimo_salida as time) and
 cast(maximo_salida as time)) as 'marco_salida'

from manager_cte

group by Userid,cast(CheckTime as date),minimo_salida,maximo_salida,hora_entrada,hora_salida

)

,
manager_cte6 as
(
select * from manager_cte5 where marco_salida is null
)


,



-- calcular inasistencia

 Calender AS (
    select  CASE WHEN (DATEPART(WEEKDAY, @startDate) + @@DATEFIRST)%7 IN (0, 1) THEN DATEADD(day,1,@startDate) ELSE @startDate END as CalanderDate, '' as fecha
    UNION ALL
    SELECT DATEADD(day,1,CalanderDate), CASE WHEN (DATEPART(WEEKDAY, DATEADD(day,1,CalanderDate)) + @@DATEFIRST)%7 IN (0, 1) THEN '1' ELSE '0' END as fecha FROM Calender
    WHERE DATEADD(day,1,CalanderDate) <= @endDate  
)
,

--se quitan fines de semana y dias feriados
sinfinesdeseamana AS (
select * from Calender where
CASE WHEN (DATEPART(WEEKDAY, CalanderDate) + @@DATEFIRST)%7 IN (0, 1) THEN 1 ELSE 0 END = 0 

 and (select count(*) from holiday where CAST(CalanderDate as date) between  CAST(BDate as date) and dateadd(day,CASE Days WHEN 1 THEN 0 ELSE Days END,CAST(BDate as date))) =0
)
,

query as (
select Userid as id_usuario, CalanderDate from Checkinout  cross join sinfinesdeseamana
-- where Userid in (55556,1,55555)
group by Userid,CalanderDate
)
,
 inasistencia as
(
select q.id_usuario,q.CalanderDate,

(select count(*)  from UserShift
inner join SchTime on userShift.Schid= SchTime.Schid
inner join TimeTable on Schtime.Timeid= TimeTable.Timeid
 where UserShift.Userid=q.id_usuario and
   CAST(q.CalanderDate as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay=  datepart(DW,q.CalanderDate)) as toca_trabajar


 from query as q

WHERE NOT EXISTS 
        (SELECT cast(Checkinout.CheckTime as date) as CalanderDate  FROM Checkinout  where Userid=q.id_usuario and cast(Checkinout.CheckTime as date) = q.CalanderDate)
)

-- fin de calcular inasistencia
,


--query que unifica todo
 manager_cte2 AS
(

 -- entrada a tiempo
  SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida', CheckTime,Logid as 'log',fecha as 'fecha',Userid,'1' as 'tipo_falta',  NULL as 'tiempo_penalizado' FROM manager_cte where rango_entrada = '1' and entrada_tarde_con_lactancia = 'FALSE'

   UNION all

--entrada tarde
 SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',CheckTime,Logid as 'log',fecha as 'fecha',Userid,'2' as 'tipo_falta', DATEDIFF( second , cast(hora_entrada_con_lactancia as time)   , cast(CheckTime as time) ) as 'tiempo_penalizado' FROM manager_cte where rango_entrada = '1' and entrada_tarde_con_lactancia = 'TRUE'
 
  UNION all
 -- no marco entrada
 select hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',null,null as 'log',fecha as 'fecha',Userid,'3' as 'tipo_falta', NULL as 'tiempo_penalizado'  from manager_cte4


 UNION ALL

  -- salida al almuerzo
  SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',CheckTime,Logid as 'log',fecha as 'fecha',Userid,'4' as 'tipo_falta',  NULL as 'tiempo_penalizado' FROM manager_cte where rango_salida_almuerzo = '1'

     UNION all

--entrada a tiempo del almuerzo
 SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',CheckTime,Logid as 'log',fecha as 'fecha',Userid,'10' as 'tipo_falta', NULL as 'tiempo_penalizado' FROM manager_cte where rango_entrada_almuerzo = '1' and entrada_almuerzo_tarde = 'FALSE'

   UNION all

--entrada tarde del almuerzo
 SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',CheckTime,Logid as 'log',fecha as 'fecha',Userid,'5' as 'tipo_falta', DATEDIFF( second , cast('12:20:00' as time)   , cast(CheckTime as time) ) as 'tiempo_penalizado' FROM manager_cte where rango_entrada_almuerzo = '1' and entrada_almuerzo_tarde = 'TRUE'



  UNION all
 -- salida a tiempo

 SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',CheckTime,Logid as 'log',fecha as 'fecha',Userid,'6' as 'tipo_falta', NULL as 'tiempo_penalizado' FROM manager_cte where rango_salida = '1' and salida_temprano_con_lactancia = 'FALSE'



 UNION all
 -- salida temprano 
 SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',CheckTime,Logid as 'log',fecha as 'fecha',Userid,'7' as 'tipo_falta', DATEDIFF( second , cast(CheckTime as time)  , cast(hora_salida_con_lactancia as time) )  as 'tiempo_penalizado'  FROM manager_cte where rango_salida = '1' and salida_temprano_con_lactancia = 'TRUE'

 -- DATEDIFF( second , cast(CheckTime as time)  , cast(hora_salida_con_lactancia as time) )
  
 
  UNION all

  -- no marco salida
 select hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',NULL,null as 'log',fecha as 'fecha',Userid,'8' as 'tipo_falta', NULL as 'tiempo_penalizado'  from manager_cte6


 UNION all
 
 -- hora fuera de todos los rangos 
 SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',CheckTime,Logid as 'log',fecha as 'fecha',Userid,'9' as 'tipo_falta', NULL as 'tiempo_penalizado' FROM manager_cte where rango_salida is null   and rango_entrada is null and rango_entrada_almuerzo is null and rango_salida_almuerzo is null

 UNION ALL
 -- inasistencia
 select (select top 1 TimeTable.Intime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=inasistencia.id_usuario and   BeginDay= (CASE datepart(DW,inasistencia.CalanderDate) WHEN 7 THEN 0 ELSE datepart(DW,inasistencia.CalanderDate) END))  as 'hora_entrada', (select top 1 TimeTable.Outtime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=inasistencia.id_usuario and   BeginDay= (CASE datepart(DW,inasistencia.CalanderDate) WHEN 7 THEN 0 ELSE datepart(DW,inasistencia.CalanderDate) END)) as 'hora_salida',null,null as log, CalanderDate as fecha, id_usuario as Userid, '11' as 'tipo_falta', NULL as 'tiempo_penalizado' from inasistencia where  toca_trabajar= 1



 --hora entrada



)

 select hora_entrada,hora_salida,cast(CheckTime as time) as hora_marcaje, log,CheckTime,fecha, manager_cte2.Userid, Userinfo.Name, grupo_personal.nombre as grupo, sub_grupo_personal.nombre as subgrupo, tipo_falta,tiempo_penalizado, 
 (select top 1 Lsh from UserLeave where userid=manager_cte2.Userid and tipo_falta= manager_cte2.tipo_falta and cast(BeginTime as date)= manager_cte2.fecha) as justificativos
 from manager_cte2 
 inner join Userinfo
on manager_cte2.Userid= Userinfo.Userid
left join grupo_personal
on Userinfo.idGrupo= grupo_personal.id
left join sub_grupo_personal
on Userinfo.idSubGrupo= sub_grupo_personal.id

where 
fecha = cast(GETDATE() as date)

 group by hora_entrada,hora_salida,fecha,tipo_falta,manager_cte2.Userid,CheckTime,log,tiempo_penalizado,cast(CheckTime as time) ,Userinfo.Name, Userinfo.idSubGrupo, Userinfo.idGrupo, grupo_personal.nombre,sub_grupo_personal.nombre
 order by   cast(fecha as date) desc, manager_cte2.Userid,CheckTime asc, tipo_falta asc;

--entrada a tiempo =1
--TARDIA =2
--FALTA MARCA ENTRADA= 3
--salida al almuerzo =4
--entrada tarde del almuerzo= 5
--salida a tiempo = 6
--SALIDA PREVIA=7
--FALTA MARCA SALIDA=8
--hora fuera de todos los rangos =9
--entrada a tiempo del almuerzo = 10
-- AUSENCIA =11"));
$data= $data;
return collect($data);

        

    }

    static public function insertar($usuario_nro,$nombre,$departamento,$grupo,$subgrupo,$idgenero)
    {

        $userid = PersonalModels::last_userID();

        $lastInsertID= DB::table('Userinfo')->insertGetId(
            ['Userid' => $userid, 'UserCode' => $usuario_nro, 'Name' => $nombre, 'Deptid' => $departamento, 'idGrupo' => $grupo, 'idSubGrupo' => $subgrupo,'idGenero'=>$idgenero]
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

    static public function last_userID()
    {

        $result=DB::table('Userinfo')->max('Userid');
        return $result+1;
    }

























    static  public function generalavanzada($grupo,$subgrupo,$personal,$actividad,$fecha_inicio,$fecha_final)
    {
      $sql= "DECLARE @startDate DATE, @endDate DATE ";

    if($fecha_inicio !="")
    {



     $sql.= "SELECT @startDate = '".date('Y-m-d', strtotime($fecha_inicio))."', @endDate = '".date('Y-m-d', strtotime($fecha_final))."';";

    }
    else
    {
    $sql.= "SELECT @startDate = cast(GETDATE() as date), @endDate = cast(GETDATE() as date);";
    }

 //$data=DB::select(DB::raw("horario"));



$sql.= "WITH origen AS
(select  Logid, Userid,
CheckTime,

CAST(CheckTime as time) as hora,
CAST(CheckTime as date) as fecha,
datepart(DW,CheckTime) as dia_semana,
(select top 1 '1'  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as time) between TimeTable.BIntime and TimeTable.EIntime and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as rango_entrada,
(select top 1 '1'  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as time) between TimeTable.BOuttime and TimeTable.EOuttime and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as rango_salida,

--hora entrada

(select top 1 TimeTable.Intime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and   BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as hora_entrada,


-- minimo de entrada
(select top 1 TimeTable.BIntime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and   BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as minimo_entrada,


--maximo de entrada
(select top 1 TimeTable.EIntime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and   BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as maximo_entrada,

-- hora de salida
(select top 1 TimeTable.Outtime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and   BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as hora_salida,



-- minimo de salida
(select top 1 TimeTable.BOuttime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and   BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as minimo_salida,


-- maximo salida
(select top 1 TimeTable.EOuttime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and   BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) as maximo_salida,




IIF(cast(Checkinout.CheckTime as time) >='11:00' and cast(Checkinout.CheckTime as time)<'11:49' ,'1',NULL) as rango_salida_almuerzo,
IIF(cast(Checkinout.CheckTime as time) >='11:50' and cast(Checkinout.CheckTime as time)<='12:30' ,'1',NULL) as rango_entrada_almuerzo,

(select count(*)  from Lactancia where CAST(Checkinout.CheckTime as date) between Lactancia.BeginDate and Lactancia.EndDate) as Lactancia,


IIF(cast(Checkinout.CheckTime as time) >'12:20' and (cast(Checkinout.CheckTime as time) >='11:00' and cast(Checkinout.CheckTime as time)<='12:30') ,'TRUE','FALSE') as entrada_almuerzo_tarde,

 

 (select count(*) from holiday where CAST(Checkinout.CheckTime as date) between  CAST(BDate as date) and dateadd(day,CASE Days WHEN 1 THEN 0 ELSE Days END,CAST(BDate as date))) as feriado,


-- hora de entrada
 (SELECT cast(CASE WHEN (select count(*)  from Lactancia where CAST(Checkinout.CheckTime as date) between Lactancia.BeginDate and Lactancia.EndDate and periodo='1')=0 THEN 
 (select top 1 Intime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) 
 ELSE 
 (select top 1 dateadd(minute,90,Intime)  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END))  END as time)) as hora_entrada_con_lactancia,

 --entrada_tarde

  IIF (CAST(CheckTime as time)  >  (SELECT cast(CASE WHEN (select count(*)  from Lactancia where CAST(Checkinout.CheckTime as date) between Lactancia.BeginDate and Lactancia.EndDate and periodo='1')=0 THEN 
 (select top 1 dateadd(minute,(select top 1 tiempo_gracia from configuracion),Intime)  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) 
 ELSE 
 (select top 1 dateadd(minute,90,Intime)  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END))  END as time)), 'TRUE', 'FALSE' ) AS entrada_tarde_con_lactancia,

 -- hora de salida
 (SELECT cast(CASE WHEN (select count(*)  from Lactancia where CAST(Checkinout.CheckTime as date) between Lactancia.BeginDate and Lactancia.EndDate and periodo='2')=0 THEN 
 (select top 1 Outtime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) 
 ELSE 
 (select top 1 dateadd(minute,-90,Outtime)  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END))  END as time)) as hora_salida_con_lactancia,


  --salida_temprano

 IIF (CAST(CheckTime as time)  <  (SELECT cast(CASE WHEN (select count(*)  from Lactancia where CAST(Checkinout.CheckTime as date) between Lactancia.BeginDate and Lactancia.EndDate and periodo='2')=0 THEN 
 (select top 1 Outtime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END)) 
 ELSE 
 (select top 1 dateadd(minute,-90,Outtime)  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=Checkinout.Userid and  CAST(Checkinout.CheckTime as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay= (CASE datepart(DW,Checkinout.CheckTime) WHEN 7 THEN 0 ELSE datepart(DW,Checkinout.CheckTime) END))  END as time)), 'TRUE', 'FALSE' ) AS salida_temprano_con_lactancia


from Checkinout


--from Checkinout 

)
, 

manager_cte as  (
select * from origen where origen.feriado=0
)
,
-- cuando no marco entradas
manager_cte3 as 
(
 select '' as 'logid',cast(CheckTime as date) as 'fecha', Userid,hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',
(SELECT top 1 '1' FROM 
Checkinout v
 where  v.Userid=manager_cte.Userid and 
  cast(v.CheckTime as date) = cast(manager_cte.CheckTime as date) and 
  cast(v.CheckTime as time) between cast(minimo_entrada as time) and
 cast(maximo_entrada as time)) as 'marco_entrada'

from manager_cte

group by Userid,cast(CheckTime as date),minimo_entrada,maximo_entrada, hora_entrada,hora_salida


)
,
manager_cte4 as
(
select * from manager_cte3 where marco_entrada is null
)
,

-- cuando no marco salida
manager_cte5 as
(

 select '' as 'logid',cast(CheckTime as date) as 'fecha', Userid, hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',
(SELECT top 1 '1' FROM 
Checkinout v
 where  v.Userid=manager_cte.Userid and 
  cast(v.CheckTime as date) = cast(manager_cte.CheckTime as date) and 
  cast(v.CheckTime as time) between cast(minimo_salida as time) and
 cast(maximo_salida as time)) as 'marco_salida'

from manager_cte

group by Userid,cast(CheckTime as date),minimo_salida,maximo_salida,hora_entrada,hora_salida

)

,
manager_cte6 as
(
select * from manager_cte5 where marco_salida is null
)


,



-- calcular inasistencia

 Calender AS (
    select  CASE WHEN (DATEPART(WEEKDAY, @startDate) + @@DATEFIRST)%7 IN (0, 1) THEN DATEADD(day,1,@startDate) ELSE @startDate END as CalanderDate, '' as fecha
    UNION ALL
    SELECT DATEADD(day,1,CalanderDate), CASE WHEN (DATEPART(WEEKDAY, DATEADD(day,1,CalanderDate)) + @@DATEFIRST)%7 IN (0, 1) THEN '1' ELSE '0' END as fecha FROM Calender
    WHERE DATEADD(day,1,CalanderDate) <= @endDate  
)
,

--se quitan fines de semana y dias feriados
sinfinesdeseamana AS (
select * from Calender where
CASE WHEN (DATEPART(WEEKDAY, CalanderDate) + @@DATEFIRST)%7 IN (0, 1) THEN 1 ELSE 0 END = 0 

 and (select count(*) from holiday where CAST(CalanderDate as date) between  CAST(BDate as date) and dateadd(day,CASE Days WHEN 1 THEN 0 ELSE Days END,CAST(BDate as date))) =0
)
,

query as (
select Userid as id_usuario, CalanderDate from Checkinout  cross join sinfinesdeseamana
-- where Userid in (55556,1,55555)
group by Userid,CalanderDate
)
,
 inasistencia as
(
select q.id_usuario,q.CalanderDate,

(select count(*)  from UserShift
inner join SchTime on userShift.Schid= SchTime.Schid
inner join TimeTable on Schtime.Timeid= TimeTable.Timeid
 where UserShift.Userid=q.id_usuario and
   CAST(q.CalanderDate as date) between UserShift.BeginDate and UserShift.EndDate and  BeginDay=  datepart(DW,q.CalanderDate)) as toca_trabajar


 from query as q

WHERE NOT EXISTS 
        (SELECT cast(Checkinout.CheckTime as date) as CalanderDate  FROM Checkinout  where Userid=q.id_usuario and cast(Checkinout.CheckTime as date) = q.CalanderDate)
)

-- fin de calcular inasistencia
,


--query que unifica todo
 manager_cte2 AS
(

 -- entrada a tiempo
  SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida', CheckTime,Logid as 'log',fecha as 'fecha',Userid,'1' as 'tipo_falta',  NULL as 'tiempo_penalizado' FROM manager_cte where rango_entrada = '1' and entrada_tarde_con_lactancia = 'FALSE'

   UNION all

--entrada tarde
 SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',CheckTime,Logid as 'log',fecha as 'fecha',Userid,'2' as 'tipo_falta', DATEDIFF( second , cast(hora_entrada_con_lactancia as time)   , cast(CheckTime as time) ) as 'tiempo_penalizado' FROM manager_cte where rango_entrada = '1' and entrada_tarde_con_lactancia = 'TRUE'
 
  UNION all
 -- no marco entrada
 select hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',null,null as 'log',fecha as 'fecha',Userid,'3' as 'tipo_falta', NULL as 'tiempo_penalizado'  from manager_cte4


 UNION ALL

  -- salida al almuerzo
  SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',CheckTime,Logid as 'log',fecha as 'fecha',Userid,'4' as 'tipo_falta',  NULL as 'tiempo_penalizado' FROM manager_cte where rango_salida_almuerzo = '1'

     UNION all

--entrada a tiempo del almuerzo
 SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',CheckTime,Logid as 'log',fecha as 'fecha',Userid,'10' as 'tipo_falta', NULL as 'tiempo_penalizado' FROM manager_cte where rango_entrada_almuerzo = '1' and entrada_almuerzo_tarde = 'FALSE'

   UNION all

--entrada tarde del almuerzo
 SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',CheckTime,Logid as 'log',fecha as 'fecha',Userid,'5' as 'tipo_falta', DATEDIFF( second , cast('12:20:00' as time)   , cast(CheckTime as time) ) as 'tiempo_penalizado' FROM manager_cte where rango_entrada_almuerzo = '1' and entrada_almuerzo_tarde = 'TRUE'



  UNION all
 -- salida a tiempo

 SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',CheckTime,Logid as 'log',fecha as 'fecha',Userid,'6' as 'tipo_falta', NULL as 'tiempo_penalizado' FROM manager_cte where rango_salida = '1' and salida_temprano_con_lactancia = 'FALSE'



 UNION all
 -- salida temprano 
 SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',CheckTime,Logid as 'log',fecha as 'fecha',Userid,'7' as 'tipo_falta', DATEDIFF( second , cast(CheckTime as time)  , cast(hora_salida_con_lactancia as time) )  as 'tiempo_penalizado'  FROM manager_cte where rango_salida = '1' and salida_temprano_con_lactancia = 'TRUE'

 -- DATEDIFF( second , cast(CheckTime as time)  , cast(hora_salida_con_lactancia as time) )
  
 
  UNION all

  -- no marco salida
 select hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',NULL,null as 'log',fecha as 'fecha',Userid,'8' as 'tipo_falta', NULL as 'tiempo_penalizado'  from manager_cte6


 UNION all
 
 -- hora fuera de todos los rangos 
 SELECT hora_entrada as 'hora_entrada', hora_salida as 'hora_salida',CheckTime,Logid as 'log',fecha as 'fecha',Userid,'9' as 'tipo_falta', NULL as 'tiempo_penalizado' FROM manager_cte where rango_salida is null   and rango_entrada is null and rango_entrada_almuerzo is null and rango_salida_almuerzo is null

 UNION ALL
 -- inasistencia
 select (select top 1 TimeTable.Intime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=inasistencia.id_usuario and   BeginDay= (CASE datepart(DW,inasistencia.CalanderDate) WHEN 7 THEN 0 ELSE datepart(DW,inasistencia.CalanderDate) END))  as 'hora_entrada', (select top 1 TimeTable.Outtime  from UserShift inner join SchTime on userShift.Schid= SchTime.Schid inner join TimeTable on SchTime.Timeid=TimeTable.Timeid   where UserShift.Userid=inasistencia.id_usuario and   BeginDay= (CASE datepart(DW,inasistencia.CalanderDate) WHEN 7 THEN 0 ELSE datepart(DW,inasistencia.CalanderDate) END)) as 'hora_salida',null,null as log, CalanderDate as fecha, id_usuario as Userid, '11' as 'tipo_falta', NULL as 'tiempo_penalizado' from inasistencia where  toca_trabajar= 1



 --hora entrada



)

 select hora_entrada,hora_salida,cast(CheckTime as time) as hora_marcaje, log,CheckTime,fecha, manager_cte2.Userid, Userinfo.Name, grupo_personal.nombre as grupo, sub_grupo_personal.nombre as subgrupo, tipo_falta,tiempo_penalizado, 
 (select top 1 Lsh from UserLeave where userid=manager_cte2.Userid and tipo_falta= manager_cte2.tipo_falta and cast(BeginTime as date)= manager_cte2.fecha) as justificativos
 from manager_cte2 
 inner join Userinfo
on manager_cte2.Userid= Userinfo.Userid
left join grupo_personal
on Userinfo.idGrupo= grupo_personal.id
left join sub_grupo_personal
on Userinfo.idSubGrupo= sub_grupo_personal.id where";

$sql.=ReportesModels::completarsql($grupo,$subgrupo,$personal,$actividad,$fecha_inicio,$fecha_final);


 $sql.="   group by hora_entrada,hora_salida,fecha,tipo_falta,manager_cte2.Userid,CheckTime,log,tiempo_penalizado,cast(CheckTime as time) ,Userinfo.Name, Userinfo.idSubGrupo, Userinfo.idGrupo, grupo_personal.nombre,sub_grupo_personal.nombre
 order by   cast(fecha as date) desc, manager_cte2.Userid,CheckTime asc, tipo_falta asc
 OPTION(MAXRECURSION 1000);

--entrada a tiempo =1
--TARDIA =2
--FALTA MARCA ENTRADA= 3
--salida al almuerzo =4
--entrada tarde del almuerzo= 5
--salida a tiempo = 6
--SALIDA PREVIA=7
--FALTA MARCA SALIDA=8
--hora fuera de todos los rangos =9
--entrada a tiempo del almuerzo = 10
-- AUSENCIA =11";

 $data=DB::select(DB::raw($sql));
//$data= $data;
return collect($data);

//return $data->toSql();

        

    }

   static private function completarsql($grupo,$subgrupo,$personal,$actividad,$fecha_inicio,$fecha_final){

    if($fecha_inicio !="")
    {



      $sql= " fecha between '".date('Y-m-d', strtotime($fecha_inicio))."' and '".date('Y-m-d', strtotime($fecha_final))."'";

    }
    else
    {
     $sql= " fecha = cast(GETDATE() as date)";
    }

    if($grupo!=""){

      $sql.= " and idGrupo = $grupo";

    }
     if($subgrupo!=""){

      $sql.= " and idSubgrupo = $subgrupo";

    }
      if($personal!=""){

      $sql.= " and manager_cte2.Userid = $personal";

    }


      if(! empty($actividad))
     {
          $todas=FALSE;
              for ($i=0;$i<count($actividad);$i++)    
              {     
                if ($actividad[$i]=='t')
                {
                  $todas=TRUE;
                  break;
                }    
              } 

        if(!$todas)
        {
          $separado_por_comas = implode(",",$actividad);
          $sql.= " and tipo_falta in( $separado_por_comas )";
        }
         
    }




    return $sql;
} 

}