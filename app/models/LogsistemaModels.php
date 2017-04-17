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


class LogsistemaModels
{

    static  public function listar()
    {
        $data = DB::table('LogSistema')
            ->join('users', 'LogSistema.Userid', '=', 'users.id');
        return $data;

    }


    static public function insertar($modulo,$accion,$id_modulos)

    {
        DB::table('LogSistema')->insert(
            ['modulo' => $modulo, 'accion' => $accion,  'fecha_creado' => DB::raw("getdate()"), 'Userid'=>Auth::user()->id,'id_modulos'=>$id_modulos]
        );

    }


}