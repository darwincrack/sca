<?php

namespace App\Http\Controllers;

use App\models\ConfiguracionModels;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use Input;
use Illuminate\Support\Facades\Response;
use Entrust;

use Illuminate\Support\Collection as Collection;


class ConfiguracionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $data_configuracion  =  ConfiguracionModels::listar();

        return view('configuracion.index',['data_configuracion'=>$data_configuracion]);
    }








    public function store_editar(Request $request)
    {


        $this->validate($request, [
            'tiempo_gracia' => 'required|numeric',
            'nombre_sistema' => 'required|max:50',
            'nombre_corto_sistema' => 'required|max:5',
 
        ]);


        $tiempo_gracia              =   $request->input("tiempo_gracia");
        $nombre_sistema             =   $request->input("nombre_sistema");
        $nombre_corto_sistema       =   $request->input("nombre_corto_sistema");
        $prioridad                  =   $request->input("prioridad");
        $file                       =   $request->file("logo");
        $logo_old                   =   $request->input("logo_old");
        $quitar_logo                =   $request->input("quitar_logo");
        $base64_img                 =   $request->input("base64_img");


        if($request->hasFile('logo')){
            $nombre_logo=$file->getClientOriginalName();
            $file->move('assets/img',$file->getClientOriginalName());

            $path = 'assets/img/'.$nombre_logo;
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64_img = 'data:image/' . $type . ';base64,' . base64_encode($data);



        }
        else{
            $nombre_logo= $logo_old;
           // $base64_img= 
        }


        if($quitar_logo=='1')
        {
            $nombre_logo='';
            $base64_img='';
        }





        ConfiguracionModels::editar($tiempo_gracia,$nombre_sistema,$nombre_corto_sistema,$prioridad,$nombre_logo,$base64_img);


        ConfiguracionController::set_session($request,$tiempo_gracia,$nombre_sistema,$nombre_corto_sistema,$prioridad,$nombre_logo);

 /*       $request->session()->put('nombre_largo_sistema',$nombre_sistema);
        $request->session()->put('nombre_corto_sistema',$nombre_corto_sistema);
        $request->session()->put('prioridad',$prioridad);
        $request->session()->put('logo',$nombre_logo);*/


        $request->session()->flash('alert-success', 'Configuracion guardada con exito!!');

        return redirect('configuracion');
    }






    public function diasferiados()
    {

        return view('configuracion.diasferiados.index');
    }





    public function anyData()
    {

        $feriados  =  ConfiguracionModels::diasferiados();

        return Datatables::of($feriados)



            ->addColumn('action', function ($feriado)  {

                if(Entrust::hasRole(['admin', 'operador']))
                {
                    return '<a href="diasferiados/editar/'.$feriado->Holidayid.'" class="btn btn-xs btn-primary editar"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                }
                else{
                    return '-';
                }


            })


            ->addColumn('delete', function ($feriado)  {

                if(Entrust::hasRole(['admin', 'operador']))
                {
                    return '<a class="btn btn-xs btn-danger delete" data-eliminar="'.$feriado->Holidayid.'"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>';
               

                }
                else{
                    return '<i class="fa fa-lock" aria-hidden="true"></i>';
                }


            })



            ->editColumn('BDate', function ($feriado) {

                    return date('d/m/Y', strtotime($feriado->BDate));



            })



            ->make(true);

    }







    public function add_diasferiados()
    {


        return view('configuracion.diasferiados.add');


    }





    public function store_diasferiados(Request $request)
    {

        $this->validate($request, [
                'nombre' => 'required|max:30',
                'dia_feriado' => 'required|date_format:"d-m-Y"',
                'dias' => 'required|numeric',
            ]
        );



        $nombre        =   $request->input("nombre");
        $dia_feriado   =   $request->input("dia_feriado");
        $dias          =   $request->input("dias");


        if($dia_feriado !='')
        {
            $dia_feriado     =   date('Y-m-d', strtotime($dia_feriado));
        }
        else
        {
            $dia_feriado     =   NULL;
        }


        ConfiguracionModels::insertar_diaferiado($nombre,$dia_feriado,$dias);

        $request->session()->flash('alert-success', 'Dia feriado agregado con exito!!');

        return redirect('configuracion/diasferiados');
    }




    public function editar_diasferiados($id_feriado)
    {

        $data_feriados         =  ConfiguracionModels::diasferiados($id_feriado);

        if (count($data_feriados)==0){
            return redirect('personal');
        }

        return view('configuracion.diasferiados.editar', ['id_feriado' =>$id_feriado,'data_feriados' => $data_feriados ]);


    }




    public function store_editar_diasferiados(Request $request)
    {

        $this->validate($request, [
                'nombre' => 'required|max:30',
                'dia_feriado' => 'required|date_format:"d-m-Y"',
                'dias' => 'required|numeric',
 
            ]
        );


        $id_feriado    =   $request->input("id_feriado");
        $nombre        =   $request->input("nombre");
        $dia_feriado   =   $request->input("dia_feriado");
        $dias          =   $request->input("dias");





        if($dia_feriado !='')
        {
            $dia_feriado     =   date('Y-m-d', strtotime($dia_feriado));
        }
        else
        {
            $dia_feriado     =   NULL;
        }





        ConfiguracionModels::editar_diaferiado($id_feriado,$nombre,$dia_feriado,$dias);

        $request->session()->flash('alert-success', 'Dia feriado editado con exito!!');

        return redirect('configuracion/diasferiados/editar/'.$id_feriado);
    }



    public function delete_diasferiados($id_feriado,Request $request)
    {

        ConfiguracionModels::delete_diaferiado($id_feriado);


        $request->session()->flash('alert-success', 'Dia feriado eliminado con exito!!');


        return redirect('configuracion/diasferiados');


    }

    static public function set_session($request)
    {
        $data_configuracion  =  ConfiguracionModels::listar();

        $request->session()->put('nombre_largo_sistema',trim($data_configuracion->nombre_sistema));
        $request->session()->put('nombre_corto_sistema',trim($data_configuracion->nombre_corto_sistema));
        $request->session()->put('prioridad',trim($data_configuracion->prioridad));
        $request->session()->put('logo',trim($data_configuracion->path_logo));
        $request->session()->put('logo_base64',trim($data_configuracion->base64_img));

    }


    static public function install()
    {


    }




}
