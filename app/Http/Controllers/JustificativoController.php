<?php

namespace App\Http\Controllers;



use App\models\JustificativoModels;
use App\models\LogsistemaModels;
use App\models\ListaModels;
use App\models\ConfiguracionModels;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests\Requests;
use Entrust;
use PDF;
class JustificativoController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('justificativos.index');
    }



    public function anyData()
    {

        $justificativos  =  JustificativoModels::listar();

        return Datatables::of($justificativos)



            ->addColumn('pdf', function ($justificativos)  {

                    return '<a href="../justificativos/ver/'.$justificativos->Lsh.'" class="btn btn-xs btn-primary" title="Ver Justificativo" target="_blank"><i class="fa fa-file-pdf-o"></i> ver</a>';

            })

            ->addColumn('delete', function ($justificativos)  {

                if(Entrust::hasRole(['admin', 'operador']))
                {
                    return '<a class="btn btn-xs btn-danger delete" data-eliminar="'.$justificativos->Lsh.'"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>';


                    
                }
                else{
                    return '<i class="fa fa-lock" aria-hidden="true"></i>';
                }


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
                        return "<span class='falta falta-warning' >AUSENCIA</span>";

                    default:
                        return "---";

                }


            })



            ->make(true);

    }





    public function add($id_usuario,$name,$tipo_falta,$hora_marcaje,$fecha)
    {

        $tiposJustificativos =  ListaModels::tiposJustificativos();
        return view('justificativos.add',['id_usuario'=>$id_usuario, 'name'=>$name,'tipo_falta' =>$tipo_falta,'fecha' =>$fecha,'hora_marcaje' =>$hora_marcaje,'tiposJustificativos'=>$tiposJustificativos]);
    }


    public function store(Request $request)
    {

        $Userid             =   $request->input("Userid");
        $fecha              =   $request->input("fecha");
        $hora               =   $request->input("hora");
        $tipo_falta         =   $request->input("tipo_falta");
        $tipojustificativo  =   $request->input("tipojustificativo");
        $motivo             =   $request->input("motivo");
       


       $id= JustificativoModels::insertar($Userid,$fecha,$hora,$tipo_falta,$tipojustificativo,$motivo);

       if($id==0)
       {
        LogsistemaModels::insertar('JUSTIFICATIVO','INSERT-ERROR','');
        $request->session()->flash('alert-danger', 'No se pudo crear justificativo, ya que el usuario no tiene horario cargado para ese d&iacute;a');
       }
       else
       {
                LogsistemaModels::insertar('JUSTIFICATIVO','INSERT',$id);
        $request->session()->flash('alert-success', 'Justificativo agregado con exito!!');
       }


        return redirect('reportes');
    }



    public function delete($id_justificativo,Request $request)
    {

        JustificativoModels::delete($id_justificativo);
        LogsistemaModels::insertar('JUSTIFICATIVO','ELIMINAR',$id_justificativo);

        $request->session()->flash('alert-success', 'Justificativo eliminado con exito!!');


        return redirect('reportes/justificativos');


    }


        public function pdf($id_justificativo)
    {

$todo_dia='';
$manana='';
$tarde='';
$hora_entrada='';
$hora_salida='';
        $data_configuracion=ConfiguracionModels::listar();
        $data_justificativo=JustificativoModels::pdf($id_justificativo);

        if($data_justificativo->tipo_falta=='2' or $data_justificativo->tipo_falta=='3' or $data_justificativo->tipo_falta=='5')
        {
            $manana='X';
            $hora_entrada=$data_justificativo->hora_entrada;
        }
        elseif($data_justificativo->tipo_falta=='7' or $data_justificativo->tipo_falta=='8')
        {
            $tarde='X';
            $hora_salida=$data_justificativo->hora_salida;
        }
        elseif($data_justificativo->tipo_falta=='9' or $data_justificativo->tipo_falta=='11'){
            $todo_dia='X';
            $hora_entrada=$data_justificativo->hora_entrada;
            $hora_salida=$data_justificativo->hora_salida;
        }
        else
        {
            $hora_entrada=$data_justificativo->hora_entrada;
            $hora_salida=$data_justificativo->hora_salida;
        }

$data = [
        'departamento'          =>  $data_justificativo->departamento,
        'fecha'                 =>  $data_justificativo->fecha,
        'nombre'                =>  $data_justificativo->Name,
        'cedula'                =>  $data_justificativo->cedula,
        'tipo_justificativo'    =>  $data_justificativo->tipo_justificativo,
        'motivo_omision'        =>  $data_justificativo->motivo_omision,
        'todo_dia'              =>  $todo_dia,
        'manana'                =>  $manana,
        'tarde'                 =>  $tarde,
        'hora_entrada'          =>  $hora_entrada,
        'hora_salida'           =>  $hora_salida,
        'nombre_sistema'        =>  $data_configuracion->nombre_sistema,
        'url_logo'              =>  $data_configuracion->path_logo
    ];
        

        $pdf = PDF::loadView('pdf.justificativo',$data, [], [
  'title' => 'Justificativo'
]);
        return $pdf->stream('justificativo.pdf');
    }

}
