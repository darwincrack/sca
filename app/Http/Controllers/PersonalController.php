<?php

namespace App\Http\Controllers;

use App\models\PersonalModels;
use App\models\ListaModels;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use Input;
use Illuminate\Support\Facades\Response;

class PersonalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('personal.index');
    }


    public function anyData()
    {

        $personal  =  PersonalModels::listar();

        return Datatables::of($personal)
            ->addColumn('action', function ($personal) {
                return '<a href="personal/editar/'.$personal->Userid.'" class="btn btn-xs btn-primary editar"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
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
                'id_dispositivo' => 'required|numeric',
                'usuario_nro' => 'required|numeric',
            ]);



        $id_dispositivo     =   $request->input("id_dispositivo");
        $usuario_nro        =   $request->input("usuario_nro");
        $nombre             =   $request->input("nombre");
        $departamento       =   $request->input("departamento");
        $grupo              =   $request->input("grupo");
        $subgrupo           =   $request->input("subgrupo");
        $idgenero           =   $request->input("genero");




        PersonalModels::insertar($id_dispositivo,$usuario_nro,$nombre,$departamento,$grupo,$subgrupo,$idgenero);

        $request->session()->flash('alert-success', 'Personal agregado con exito!!');

        return redirect('personal');
    }



    public function store_editar(Request $request)
    {


            $this->validate($request, [
                'nombre' => 'required|max:50',
                'usuario_nro' => 'required|numeric',
            ]);


        $id_personal              =   $request->input("id_personal");
        $usuario_nro              =   $request->input("usuario_nro");
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
