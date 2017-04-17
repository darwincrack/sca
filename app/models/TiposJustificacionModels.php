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


class TiposJustificacionModels
{

    static  public function listar()
    {
        $data = DB::table('LeaveClass')
            ->select('Classid','Classname');
        return $data;

    }


    static public function insertar($nombre)
    {
       $id= DB::table('LeaveClass')->insertGetId(
            ['Classname' => $nombre, 'MinUnit'=>null]
        );
       return $id;

    }



    static public function editar($id_justificacion,$nombre)
    {
        DB::table('LeaveClass')
             ->where('Classid', $id_justificacion)
            ->update( ['Classname' => $nombre]);

    }



    static public function show_justificacion($id_justificacion){


        $data = DB::table('LeaveClass')
            ->where('Classid', $id_justificacion)
            ->select('Classid','Classname')
            ->first();
        return $data;

    }


    static  public function delete($id_justificacion){

        DB::table('LeaveClass')
            ->where('Classid', $id_justificacion)
            ->delete();
    }

}