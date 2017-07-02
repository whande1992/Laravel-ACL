<?php

namespace Modules\GruposDeAcesso\Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\GruposDeAcesso\Entities\PermissionGroup;

class GruposDeAcessoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

       /*Cria grupos de permissão padrão*/
        DB::table('permission_groups')->insert(
               ['id' => 1,'nome' => 'Grupos de usuários e segurança. ' ]
        );
        /*Cadastra permissões*/
        DB::table('permissions')->insert([
            ['id' => 1,'nome' => 'viewGrupos','descricao'=>'Permite visualizar os grupos de usuários.','permissiongroup_id'=>1 ],
            ['id' => 1,'nome' => 'editGrupos','descricao'=>'Permite editar o cadastro de grupos e permissões.','permissiongroup_id'=>1 ],
            ['id' => 1,'nome' => 'createGrupos','descricao'=>'Permite cadastrar um novo grupo/usuário','permissiongroup_id'=>1 ],
        ]);
        /*Cria um grupo padrão de adminsitrador*/
        DB::table('roles')->insert(
            ['id' => 1,'nome' => 'Administrador', 'descricao'=>'Administrador do sistema.' ]
        );

        /*Atualiza ou cria usuario id 1 como admnistrador do sistema*/
        $usuario = User::find(1);
        if($usuario){
            $usuario->name = 'Administrador';
            $usuario->email = 'suporte@autmaster.com.br';
            $usuario->password = bcrypt('@@aut456');
            $usuario->save();
        }else{
            $usuario = new User;
            $usuario->id =1;
            $usuario->name = 'Administrador';
            $usuario->email = 'suporte@autmaster.com.br';
            $usuario->password = bcrypt('@@aut456');
            $usuario->save();
        }

        /*Vincula o usuario adminsitrador a uma role de adminsitrador*/
        DB::table('role_user')->insert(
            ['user_id' => 1,'role_id' => 1 ]
        );
    }
}
