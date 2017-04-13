<?php

namespace App\Http\Controllers;



use App\models\LogsistemaModels;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests\Requests;
use Entrust;

class LogsistemaController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('logsistema.index');
    }


    public function anyData()
    {
        $logsistema =  LogsistemaModels::listar();
        return Datatables::of($logsistema)
            ->make(true);
    }





}
