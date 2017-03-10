<?php

namespace App\Http\Controllers;



use App\models\GrupoModels;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests\Requests;
use Entrust;

class GrupoController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('grupo.index');
    }


    public function anyData()
    {

        $grupos =  GrupoModels::listar();

        return Datatables::of($grupos)
            ->addColumn('action', function ($grupo) {
            
                if(Entrust::hasRole(['admin', 'operador']))
                {

                    return '<a href="grupo/editar/'.$grupo->id.'" class="btn btn-xs btn-primary editar"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                }
                else
                {
                    return '-';
                }

            })


            ->editColumn('activo', function ($grupo) {
                if($grupo->activo=='1'){
                    return 'SI';
                }
                else{
                    return 'NO';
                }

            })



            ->make(true);

    }

    public function add()
    {

        return view('grupo.add');
    }


    public function store(Request $request)
    {

        $nombre             =   $request->input("nombre");
        $descripcion        =   $request->input("descripcion");


        GrupoModels::insertar($nombre,$descripcion);

        $request->session()->flash('alert-success', 'Grupo agregado con exito!!');

        return redirect('grupo');
    }



    public function editar($id_grupo)
    {


       $data_grupos         =  GrupoModels::show_grupo($id_grupo);


        if (count($data_grupos)==0){
            return redirect('grupo');
        }
        return view('grupo.editar', ['id_grupo'=>$id_grupo, 'data_grupos' =>$data_grupos]);


    }



    public function store_editar(Request $request)
    {

            $nombre                 =   $request->input("nombre");
            $descripcion            =   $request->input("descripcion");
            $activo                 =   $request->input("activo");
            $id_grupo               =   $request->input("id_grupo");


            GrupoModels::editar($id_grupo,$nombre,$descripcion,$activo);

            $request->session()->flash('alert-success', 'Grupo editado con exito!!');

            return redirect('grupo');
    }




}
