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

                    if($personal->justificativo=='')
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


                switch ($personal->tipo_falta)
                {
                    case 1:
                        return "<span class='falta falta-primary' >ENTRADA A TIEMPO</span>";
                        break;

                    case 2:
                        return "<span class='falta falta-danger' >TARDIA</span>";
                        break;
                    case 3:
                        return "<span class='falta  falta-danger' >FALTA MARCA ENTRADA</span>";
                        break;
                    case 4:
                        return "<span class='falta falta-primary' >SALIDA ALMUERZO</span>";
                        break;
                    case 5:
                        return "<span class='falta falta-danger' >ENTRADA TARDE DEL ALMUERZO</span>";
                        break;
                    case 6:
                        return "<span class='falta falta-primary' >SALIDA A TIEMPO</span>";
                        break;
                    case 7:
                        return "<span class='falta falta-danger' >SALIDA PREVIA</span>";
                        break;
                    case 8:
                        return "<span class='falta  falta-danger' >FALTA MARCA SALIDA</span>";
                    case 9:


                        return "<span class='falta'data-toggle='popover' data-placement='auto top' data-content='MARCAJE FUERA DE TODOS LOS RANGOS o no posee horario cargado para esta fecha' data-original-title='' title=''>hora fuera de todos los rangos</span>";
                    case 10:
                        return "<span class='falta falta-primary' >ENTRADA ALMUERZO</span>";

                        case 11:
                        return "<span class='falta falta-danger' >AUSENCIA</span>";

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

                    if($personal->justificativo=='')
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



                switch ($personal->tipo_falta)
                {
                    case 1:
                        return "<span class='falta falta-primary' >ENTRADA A TIEMPO</span>";
                        break;

                    case 2:
                        return "<span class='falta falta-danger' >TARDIA</span>";
                        break;
                    case 3:
                        return "<span class='falta  falta-danger' >FALTA MARCA ENTRADA</span>";
                        break;
                    case 4:
                        return "<span class='falta falta-primary' >SALIDA ALMUERZO</span>";
                        break;
                    case 5:
                        return "<span class='falta falta-danger' >ENTRADA TARDE DEL ALMUERZO</span>";
                        break;
                    case 6:
                        return "<span class='falta falta-primary' >SALIDA A TIEMPO</span>";
                        break;
                    case 7:
                        return "<span class='falta falta-danger' >SALIDA PREVIA</span>";
                        break;
                    case 8:
                        return "<span class='falta  falta-danger' >FALTA MARCA SALIDA</span>";
                    case 9:


                        return "<span class='falta'data-toggle='popover' data-placement='auto top' data-content='MARCAJE FUERA DE TODOS LOS RANGOS o no posee horario cargado para esta fecha' data-original-title='' title=''>hora fuera de todos los rangos</span>";
                    case 10:
                        return "<span class='falta falta-primary' >ENTRADA ALMUERZO</span>";

                    case 11:
                        return "<span class='falta falta-danger' >AUSENCIA</span>";

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





    public function add()
    {

       $data_departamentos      =  ListaModels::departamentos();
        $data_grupo_personals    =  ListaModels::grupoPersonal();
        $data_generos    =  ListaModels::genero();

       // return view('procedencia.add', ['data_tipo_procedencias' => $data_tipo_procedencias, 'data_ciudades' =>$data_ciudades]);
       // return view('personal.add');
         return view('personal.add', ['data_departamentos' => $data_departamentos, 'data_grupo_personals' => $data_grupo_personals , 'data_generos' => $data_generos ]);


    }


    public function select_subgrupo($id_grupo){

        $data_subgrupos     = ListaModels::subGrupoPersonal($id_grupo);

        return Response::json(['success'=>true,'data'=>$data_subgrupos]);
    }





    public function editar($id_personal)
    {

        $data_personal         =  PersonalModels::listar($id_personal);

        if (count($data_personal)==0){
            return redirect('personal');
        }


        $data_departamentos          =  ListaModels::departamentos();
        $data_grupo_personals        =  ListaModels::grupoPersonal();
        $data_sub_grupo_personals    =  ListaModels::subGrupoPersonal($data_personal->idSubGrupo);
        $data_generos                =  ListaModels::genero();
        
        return view('personal.editar', ['id_persona' =>$id_personal,'data_departamentos' => $data_departamentos, 'data_grupo_personals' => $data_grupo_personals, 'data_sub_grupo_personals' => $data_sub_grupo_personals, 'data_personal' => $data_personal , 'data_generos' => $data_generos ]);


    }


    public function store(Request $request)
    {

            $this->validate($request, [
                'nombre' => 'required|max:50',

                'UserCode' => 'required|numeric|unique:Userinfo',
            ]
            );




        $usuario_nro        =   $request->input("UserCode");
        $nombre             =   $request->input("nombre");
        $departamento       =   $request->input("departamento");
        $grupo              =   $request->input("grupo");
        $subgrupo           =   $request->input("subgrupo");
        $idgenero           =   $request->input("genero");




        PersonalModels::insertar($usuario_nro,$nombre,$departamento,$grupo,$subgrupo,$idgenero);

        $request->session()->flash('alert-success', 'Personal agregado con exito!!');

        return redirect('personal');
    }



    public function store_editar(Request $request)
    {


            $this->validate($request, [
                'nombre' => 'required|max:50',
                'UserCode' => 'required|numeric',

            ]);


        $id_personal              =   $request->input("id_personal");
        $usuario_nro              =   $request->input("UserCode");
        $nombre                   =   $request->input("nombre");
        $departamento             =   $request->input("departamento");
        $grupo                    =   $request->input("grupo");
        $subgrupo                 =   $request->input("subgrupo");
        $idgenero                 =   $request->input("genero");


        if($grupo==''){
            $grupo=NULL;
        }

        if($subgrupo==''){
            $subgrupo=NULL;
        }




        PersonalModels::editar($id_personal,$usuario_nro,$nombre,$departamento,$grupo,$subgrupo,$idgenero);

        $request->session()->flash('alert-success', 'Personal editado con exito!!');

        return redirect('personal');
    }

}
