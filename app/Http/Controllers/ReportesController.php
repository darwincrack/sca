<?php

namespace App\Http\Controllers;

use App\models\ReportesModels;
use App\models\ListaModels;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use Input;
use Illuminate\Support\Facades\Response;
use Entrust;

class ReportesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {

        $data_grupo_personals       =  ListaModels::grupoPersonal();
        $data_personals             =  ListaModels::Personal();
        $data_subgrupo_personals    =  ListaModels::subGrupoPersonal();


        return view('reportes.index', ['data_grupo_personals'=>$data_grupo_personals,'data_personals'=>$data_personals,'data_subgrupo_personals'=>$data_subgrupo_personals]);

    }


    public function anyData()
    {


        $personal  =  ReportesModels::general();

        return Datatables::of($personal)



      ->editColumn('Userid', function ($personal)  {


                      return '<a href="horario/'.$personal->Userid.'" title="Ver horario">'.$personal->Userid.'</a>';

            })

    ->editColumn('fecha', function ($personal) 
    {

                      return date('d-m-Y', strtotime($personal->fecha));
    })


            
            ->addColumn('action', function ($personal)  {

                if(Entrust::hasRole(['admin', 'operador']))
                {
                    if($personal->tipo_falta == "2" or $personal->tipo_falta == "3" or $personal->tipo_falta == "7" or $personal->tipo_falta == "8" or $personal->tipo_falta == "11"){
                     
                        $hora_marcaje    = ($personal->hora_marcaje=='') ? "0" : str_replace(".0000000","",$personal->hora_marcaje);

                        if($personal->justificativos=='')
                        {
                                return '<a href="justificativos/add/'.$personal->Userid.'/'.$personal->Name.'/'.$personal->tipo_falta.'/'.$hora_marcaje.'/'.$personal->fecha.'" class="btn btn-xs btn-primary editar"><i class="glyphicon glyphicon-edit"></i> crear</a>';
                        }
                        else
                        {
                                return '<a href="justificativos/ver/'.$personal->justificativos.'" class="btn btn-xs label-warning-light" title="Ver Justificativo" target="_blank"><i class="fa fa-file-pdf-o"></i> ver</a>';
                        }
                    }
                    else
                    {
                        return'-';
                    }

                     

                }
                else{

                    if($personal->justificativos=='')
                    {
                        return '<i class="fa fa-lock" aria-hidden="true"></i>';
                    }
                    else
                    {
                        return '<a href="justificativos/ver/'.$personal->justificativo.'" class="btn btn-xs label-warning-light" title="Ver Justificativo" target="_blank"><i class="fa fa-file-pdf-o"></i> ver</a>';
                    }


                }
                  

            })



            ->editColumn('hora_marcaje', function ($personal) {
                return str_replace(".0000000","",$personal->hora_marcaje);

            })

            ->editColumn('tipo_falta', function ($personal) {
              //  return $personal->tipo_falta.'xxx';
                $cssjustificativo=($personal->justificativos=='')? '' : '-justificativo';

                switch ($personal->tipo_falta)
                {
                    case 1:
                        return "<span class='falta falta-primary' >ENTRADA A TIEMPO</span>";
                        break;

                    case 2:
                        return "<span class='falta falta-danger$cssjustificativo'>TARDIA</span>";
                        break;
                    case 3:
                        return "<span class='falta  falta-danger$cssjustificativo' >FALTA MARCA ENTRADA</span>";
                        break;
                    case 4:
                        return "<span class='falta falta-primary-almuerzo' >SALIDA ALMUERZO</span>";
                        break;
                    case 5:
                        return "<span class='falta falta-danger$cssjustificativo' >ENTRADA TARDE DEL ALMUERZO</span>";
                        break;
                    case 6:
                        return "<span class='falta falta-primary' >SALIDA A TIEMPO</span>";
                        break;
                    case 7:
                        return "<span class='falta falta-danger$cssjustificativo' >SALIDA PREVIA</span>";
                        break;
                    case 8:
                        return "<span class='falta  falta-danger$cssjustificativo' >FALTA MARCA SALIDA</span>";
                    case 9:


                        return "<span class='falta'data-toggle='popover' data-placement='auto top' data-content='MARCAJE FUERA DE TODOS LOS RANGOS o no posee horario cargado para esta fecha' data-original-title='' title=''>hora fuera de todos los rangos</span>";
                    case 10:
                        return "<span class='falta falta-primary-almuerzo' >ENTRADA ALMUERZO</span>";

                        case 11:
                        return "<span class='falta falta-danger$cssjustificativo' >AUSENCIA</span>";






                    default:
                        return "???";

                }


            })
->editColumn('tiempo_penalizado', function ($personal) {   


$horas = floor($personal->tiempo_penalizado / 3600);
    $minutos = floor(($personal->tiempo_penalizado - ($horas * 3600)) / 60);
    $segundos = $personal->tiempo_penalizado - ($horas * 3600) - ($minutos * 60);
 
    $hora_texto = "";
    if ($horas > 0 ) {
        $hora_texto .= $horas . "h ";
    }
 
    if ($minutos > 0 ) {
        $hora_texto .= $minutos . "m ";
    }
 
    if ($segundos > 0 ) {
        $hora_texto .= $segundos . "s";
    }
 
    return $hora_texto;



})



            ->make(true);

    }



/**busqueda avanzada**/
    public function generalavanzada(Request $request)
    {

        $grupo              =   $request->input("grupo");
        $subgrupo           =   $request->input("subgrupo");
        $personal           =   $request->input("personal");
        $actividad          =   $request->input("actividad");
        $fecha_inicio       =   $request->input("fecha_inicio");
        $fecha_final        =   $request->input("fecha_final");


        $personal  =  ReportesModels::generalavanzada($grupo,$subgrupo,$personal,$actividad,$fecha_inicio,$fecha_final);

        return Datatables::of($personal)

            
    ->editColumn('fecha', function ($personal) 
    {
        return date('d-m-Y', strtotime($personal->fecha));
    })




      ->editColumn('Userid', function ($personal)  {


                      return '<a href="horario/'.$personal->Userid.'" title="Ver horario">'.$personal->Userid.'</a>';

            })


            ->addColumn('action', function ($personal)  {

                if(Entrust::hasRole(['admin', 'operador']))
                {
                    if($personal->tipo_falta == "2" or $personal->tipo_falta == "3" or $personal->tipo_falta == "7" or $personal->tipo_falta == "8" or $personal->tipo_falta == "11"){

                        $hora_marcaje    = ($personal->hora_marcaje=='') ? "0" : str_replace(".0000000","",$personal->hora_marcaje);

                        if($personal->justificativos=='')
                        {
                            return '<a href="justificativos/add/'.$personal->Userid.'/'.$personal->Name.'/'.$personal->tipo_falta.'/'.$hora_marcaje.'/'.$personal->fecha.'" class="btn btn-xs btn-primary editar"><i class="glyphicon glyphicon-edit"></i> crear</a>';
                        }
                        else
                        {
                            return '<a href="justificativos/ver/'.$personal->justificativos.'" class="btn btn-xs label-warning-light" title="Ver Justificativo" target="_blank"><i class="fa fa-file-pdf-o"></i> ver</a>';
                        }
                    }
                    else
                    {
                        return'-';
                    }



                }
                else{

                    if($personal->justificativos=='')
                    {
                        return '<i class="fa fa-lock" aria-hidden="true"></i>';
                    }
                    else
                    {
                        return '<a href="justificativos/ver/'.$personal->justificativos.'" class="btn btn-xs label-warning-light" title="Ver Justificativo" target="_blank"><i class="fa fa-file-pdf-o"></i> ver</a>';
                    }


                }


            })


            ->editColumn('hora_marcaje', function ($personal) {
                return str_replace(".0000000","",$personal->hora_marcaje);

            })

            ->editColumn('tipo_falta', function ($personal) {
              //  return $personal->tipo_falta.'xxx';
                $cssjustificativo=($personal->justificativos=='')? '' : '-justificativo';

                switch ($personal->tipo_falta)
                {
                    case 1:
                        return "<span class='falta falta-primary' >ENTRADA A TIEMPO</span>";
                        break;

                    case 2:
                        return "<span class='falta falta-danger$cssjustificativo'>TARDIA</span>";
                        break;
                    case 3:
                        return "<span class='falta  falta-danger$cssjustificativo' >FALTA MARCA ENTRADA</span>";
                        break;
                    case 4:
                        return "<span class='falta falta-primary-almuerzo' >SALIDA ALMUERZO</span>";
                        break;
                    case 5:
                        return "<span class='falta falta-danger$cssjustificativo' >ENTRADA TARDE DEL ALMUERZO</span>";
                        break;
                    case 6:
                        return "<span class='falta falta-primary' >SALIDA A TIEMPO</span>";
                        break;
                    case 7:
                        return "<span class='falta falta-danger$cssjustificativo' >SALIDA PREVIA</span>";
                        break;
                    case 8:
                        return "<span class='falta  falta-danger$cssjustificativo' >FALTA MARCA SALIDA</span>";
                    case 9:


                        return "<span class='falta'data-toggle='popover' data-placement='auto top' data-content='MARCAJE FUERA DE TODOS LOS RANGOS o no posee horario cargado para esta fecha' data-original-title='' title=''>hora fuera de todos los rangos</span>";
                    case 10:
                        return "<span class='falta falta-primary-almuerzo' >ENTRADA ALMUERZO</span>";

                        case 11:
                        return "<span class='falta falta-danger$cssjustificativo' >AUSENCIA</span>";






                    default:
                        return "???";

                }


            })
->editColumn('tiempo_penalizado', function ($personal) {   


$horas = floor($personal->tiempo_penalizado / 3600);
    $minutos = floor(($personal->tiempo_penalizado - ($horas * 3600)) / 60);
    $segundos = $personal->tiempo_penalizado - ($horas * 3600) - ($minutos * 60);
 
    $hora_texto = "";
    if ($horas > 0 ) {
        $hora_texto .= $horas . "h ";
    }
 
    if ($minutos > 0 ) {
        $hora_texto .= $minutos . "m ";
    }
 
    if ($segundos > 0 ) {
        $hora_texto .= $segundos . "s";
    }
 
    return $hora_texto;



})

            ->make(true);

    }















}
