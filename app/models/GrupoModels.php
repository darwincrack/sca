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


class GrupoModels
{

    static  public function listar()
    {
        $data = DB::table('grupo_personal')
            ->select('id','nombre', 'descripcion', 'activo');
        return $data;

    }


    static public function insertar($nombre,$descripcion)
    {
        DB::table('grupo_personal')->insert(
            ['nombre' => $nombre, 'descripcion' => $descripcion,  'activo' => '1']
        );

    }



    static public function editar($id_grupo,$nombre,$descripcion,$activo)
    {
        DB::table('grupo_personal')
             ->where('id', $id_grupo)
            ->update( ['nombre' => $nombre, 'descripcion' => $descripcion,  'activo' => $activo]);

    }



    static public function show_grupo($id_grupo){


        $data = DB::table('grupo_personal')
            ->where('id', $id_grupo)
            ->select('id','nombre', 'descripcion', 'activo')
            ->first();
        return $data;

    }


}