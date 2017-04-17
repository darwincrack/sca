<?php

namespace App\Http\Controllers;



use App\models\TiposJustificacionModels;
use App\models\LogsistemaModels;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests\Requests;
use Entrust;

class TiposJustificacionController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('tiposjustificacion.index');
    }


    public function anyData()
    {

        $justificaciones =  TiposJustificacionModels::listar();

        return Datatables::of($justificaciones)
            ->addColumn('action', function ($justificacion) {
            
                if(Entrust::hasRole(['admin', 'operador']))
                {

                    return '<a href="tiposjustificacion/editar/'.$justificacion->Classid.'" class="btn btn-xs btn-primary editar"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                }
                else
                {
                    return '<i class="fa fa-lock" aria-hidden="true"></i>';
                }

            })




            ->addColumn('delete', function ($justificacion)  {

                if(Entrust::hasRole(['admin', 'operador']))
                {
                    return '<a href="tiposjustificacion/delete/'.$justificacion->Classid.'" class="btn btn-xs btn-danger delete"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>';
                }
                else{
                    return '<i class="fa fa-lock" aria-hidden="true"></i>';
                }


            })

            ->make(true);

    }

    public function add()
    {

        return view('tiposjustificacion.add');
    }


    public function store(Request $request)
    {

        $nombre             =   $request->input("nombre");
       


        $id=TiposJustificacionModels::insertar($nombre);
        LogsistemaModels::insertar('TIPOS JUSTIFICACION','INSERT',$id);

        $request->session()->flash('alert-success', 'Justificacion agregado con exito!!');

        return redirect('tiposjustificacion');
    }



    public function editar($id_justificacion)
    {


       $data_justificaciones         =  TiposJustificacionModels::show_justificacion($id_justificacion);


        if (count($data_justificaciones)==0){
            return redirect('tiposjustificacion');
        }
        return view('tiposjustificacion.editar', ['id_justificacion'=>$id_justificacion, 'data_justificaciones' =>$data_justificaciones]);


    }



    public function store_editar(Request $request)
    {

            $nombre                 =   $request->input("nombre");

            $id_justificacion               =   $request->input("id_justificacion");


            TiposJustificacionModels::editar($id_justificacion,$nombre);
        LogsistemaModels::insertar('TIPOS JUSTIFICACION','EDIT',$id_justificacion);

            $request->session()->flash('alert-success', 'Tipo de Justificacion editado con exito!!');

            return redirect('tiposjustificacion');
    }


    public function delete($id_justificacion,Request $request)
    {

        TiposJustificacionModels::delete($id_justificacion);
        LogsistemaModels::insertar('TIPOS JUSTIFICACION','DELETE');


        $request->session()->flash('alert-success', 'Tipo de Justificacion eliminado con exito!!');


        return redirect('tiposjustificacion');


    }

}
