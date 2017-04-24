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


class SubGrupoModels
{

    static  public function listar()
    {
        $data = DB::table('sub_grupo_personal')
               ->join('grupo_personal', 'sub_grupo_personal.id_grupo_personal', '=', 'grupo_personal.id')

            ->select('sub_grupo_personal.id','grupo_personal.nombre as grupo_nombre','sub_grupo_personal.nombre', 'sub_grupo_personal.descripcion', 'sub_grupo_personal.activo');
        return $data;

    }


    static public function insertar($nombre,$descripcion,$id_grupo)
    {
        $id=DB::table('sub_grupo_personal')->insertGetId(
            ['nombre' => $nombre, 'descripcion' => $descripcion,  'activo' => '1','id_grupo_personal'=>$id_grupo, 'created_at' => DB::raw("getdate()"), 'creado_por'=>Auth::user()->id]
        );
        
        return $id;

    }



    static public function editar($id_sub_grupo,$nombre,$descripcion,$activo,$id_grupo)
    {
        DB::table('sub_grupo_personal')
             ->where('id', $id_sub_grupo)
            ->update( ['nombre' => $nombre, 'descripcion' => $descripcion,  'activo' => $activo,'id_grupo_personal'=>$id_grupo , 'updated_at' => DB::raw("getdate()")]);

    }



    static public function show_sub_grupo($id_sub_grupo){


        $data = DB::table('sub_grupo_personal')
            ->where('id', $id_sub_grupo)
            ->select('id','nombre', 'descripcion', 'activo','id_grupo_personal')
            ->first();
        return $data;

    }


}