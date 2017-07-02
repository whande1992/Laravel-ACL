<?php
namespace Modules\GruposDeAcesso\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Tests\Controller;

class HelperGrupos
{

// Pega apenas os numeros de uma string
    public static function soNumero($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }


    // Verifica as permissoes de cada perfil para exibir na view de perfil


    public static function checkPermission($idPermission, $idRole)
    {
        if ( $idRole == 1 ) {
            return 'checked';
        }

        $check = DB::table('permission_role')->where('permission_id',$idPermission )
            ->where('role_id', $idRole)->get();

        if ( $check->count() <> 0 ) {
            return 'checked';
        } else {
            return '';
        }
    }



}