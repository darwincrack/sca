<?php

namespace App\Http\Controllers;



use App\models\SubGrupoModels;
use App\models\LogsistemaModels;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests\Requests;
use App\models\ListaModels;
use Entrust;
class SubGrupoController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('subgrupo.index');
    }


    public function anyData()
    {

        $sub_grupos =  SubGrupoModels::listar();

        return Datatables::of($sub_grupos)
            ->addColumn('action', function ($sub_grupo) {

                if(Entrust::hasRole(['admin', 'operador']))
                {
                    return '<a href="subgrupo/editar/'.$sub_grupo->id.'" class="btn btn-xs btn-primary editar"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                }
                else
                {
                    return '-';
                }
            })


            ->editColumn('activo', function ($sub_grupo) {
                if($sub_grupo->activo=='1'){
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

        $data_grupo_personals    =  ListaModels::grupoPersonal();

        return view('subgrupo.add', ['data_grupo_personals'=>$data_grupo_personals]);
    }


    public function store(Request $request)
    {

        $nombre             =   $request->input("nombre");
        $descripcion        =   $request->input("descripcion");
        $grupo              =   $request->input("grupo");


        SubGrupoModels::insertar($nombre,$descripcion,$grupo);
        LogsistemaModels::insertar('SUBGRUPO','INSERT');

        $request->session()->flash('alert-success', 'Sub Grupo agregado con exito!!');

        return redirect('subgrupo');
    }



    public function editar($id_sub_grupo)
    {


       $data_sub_grupos         =  SubGrupoModels::show_sub_grupo($id_sub_grupo);

 $data_grupo_personals        =  ListaModels::grupoPersonal();
        if (count($data_sub_grupos)==0){
            return redirect('grupo');
        }
        return view('subgrupo.editar', ['id_sub_grupo'=>$id_sub_grupo, 'data_sub_grupos' =>$data_sub_grupos, 'data_grupo_personals' =>$data_grupo_personals]);


    }



    public function store_editar(Request $request)
    {

            $nombre                 =   $request->input("nombre");
            $descripcion            =   $request->input("descripcion");
            $activo                 =   $request->input("activo");
            $id_sub_grupo           =   $request->input("id_sub_grupo");
              $grupo              =   $request->input("grupo");


            SubGrupoModels::editar($id_sub_grupo,$nombre,$descripcion,$activo,$grupo);
        LogsistemaModels::insertar('SUBGRUPO','EDIT');

            $request->session()->flash('alert-success', 'Sub Grupo editado con exito!!');

            return redirect('subgrupo');
    }




}
