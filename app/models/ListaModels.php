<?php
/**
 * Created by PhpStorm.
 * User: desarrollo
 * Date: 20/12/2016
 * Time: 17:20
 */

namespace App\models;

use DB;

class ListaModels
{

    static  public function departamentos()
    {
      return  DB::table('Dept')
          ->get();

    }


    static  public function tiposJustificativos()
    {
      return  DB::table('LeaveClass')
          ->get();

    }

    static  public function genero()
    {
        return  DB::table('genero')
            ->where('activo', 1)
            ->get();

    }



    static  public function grupoPersonal()
    {
        return  DB::table('grupo_personal')
            ->where('activo', 1)
            ->get();

    }


    static  public function subGrupoPersonal($value=FALSE)
    {
        if($value)
        {
                $data = DB::table('sub_grupo_personal')
                    ->where('activo', 1)
                    -> where('id_grupo_personal', $value)
                    ->select('id', 'nombre')
                    ->get();
                return $data;
        }

        return  DB::table('sub_grupo_personal')
            ->where('activo', 1)
            ->get();
    }


  /*  static  public function personal()
    {
      return  DB::table('Userinfo')
          ->get();

    }
*/




 static  public function personal($grupo=FALSE, $subgrupo=FALSE)
    {
        $data = DB::table('Userinfo');

          if($grupo==TRUE and $subgrupo==TRUE)
        {
            $data->where('idGrupo', $grupo);
            $data->Where('idSubGrupo', $subgrupo);
        

        }
        elseif($grupo==TRUE or $subgrupo==TRUE)
        {
            $data->where('idGrupo', $grupo);
            $data->orWhere('idSubGrupo', $subgrupo);
        

        }



      return $data->get();
          

    }





    static  public function estatus()
    {
        return  DB::table('estatus')
            ->where('activo', 1)
            ->get();
    }


}