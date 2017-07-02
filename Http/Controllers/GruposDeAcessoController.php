<?php

namespace Modules\GruposDeAcesso\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\GruposDeAcesso\Entities\PermissionGroup;
use Modules\GruposDeAcesso\Entities\Role;
use Modules\GruposDeAcesso\Helpers\HelperGrupos;
use Alert;
use Rafwell\Simplegrid\Grid;

class GruposDeAcessoController extends Controller
{
    /**
     * Exibe todas as roles cadastradas no banco de dados e mostra na index.
     * @return Response
     */
    public function actionIndex()
    {
        /*Pesquisa todas as roles cadastradas para exibir na index*/
        $roles = Role::all();
        return view('gruposdeacesso::index', compact('roles'));
    }

    /**
     * Recebe os dados da nova role e salva no banco de dados.
     * @return Response
     */
    public function actionCreate(Request $request)
    {
        if ( /* Verifica se o nome da Role é diferente do nome padrão admin*/
            $request->nome <> 'Admin' &
            $request->nome <> 'admin' &
            $request->nome <> 'Administrador' &
            $request->nome <> 'administrador'
        ) {

            /*Cadastra uma nova role se o nome for diferente de admin*/
            $role = new Role;
            $role->nome = $request->nome;
            $role->descricao = $request->descricao;
            $role->save();
        } else {
            alert()->success('Você não pode mudar um perfil de administrador', 'Good bye!');
            return back();
        }
        alert()->success('O Grupo' . $request->nome . 'foi cadastrado.', 'Salvo com sucesso!');
        alert('<h1>Grupo criado com sucesso!</h1> Deseja configurar as permissões de ' . $request->nome . ' agora? <a href="' . route('actionUpdate', $role->id) . '" >Sim <i class="glyphicon glyphicon-thumbs-up"></i> </a>')->persistent("Não, Obrigado");
        return back();
    }


    /**
     * Pesquisa a role e direciona os dados atuais para veiew de edição.
     * @return Response
     */
    public function actionUpdate(Request $request = null, $id = null)
    {
        /*Se chegou dados via Request (Post), os dados serão atualizados, senão vai para view.*/
        if ($request->all()) {
            if ($request->roleId <> 1 &      /*Se o nome do perfil for (admin..) nada é gravado da atualização*/
                $request->nome <> 'Admin' &
                $request->nome <> 'admin' &
                $request->nome <> 'Administrador' &
                $request->nome <> 'administrador'
            ) {

                $role = Role::find($request->roleId); /*Pesquisa o Grupo pelo ID */
                $role->nome = $request->nome; /*Atualiza o nome conforme view de edição*/
                $role->update();

                /*Deleta todas as antigas permissões da Role*/
                DB::table('permission_role')->where('role_id', $request->roleId)->delete();

                if ($request->permission) {
                    /*Prepara um array para fazer um insert unico após deletar as permissões antigas*/
                    foreach ($request->permission as $permissao) { /*Recebe todas as permissões ativas ou não da view*/
                        $registros[] = array('permission_id' => $permissao, 'role_id' => $request->roleId);
                    }
                    /*Insere todas as novas permissões de uma só vez com o array preparado com todas as permissões*/
                    DB::table('permission_role')->insert($registros);
                }
                /*Retorna para view*/
                Alert::success('Alterações salvas com sucesso!', 'Salvo!');
                return back();
            } else {
                /*Caso exista tentativa de usar nomes padrão (Admin, Admistrador, volta para Index.)*/
                Alert::info('Não pode usar nomes como Admin ou Adminsitrador', 'Oops!');
                return back();
            }
        } else {
            /*Se o codigo for null ou o id for 1 de administreador, retorna para index (Não pode alterar administrador)*/
            if (empty($id) or $id == 1) {
                Alert::info('Não é possivel editar um Administrador.', 'Oops!');
                return redirect(route('actionIndex'));
            }
            $role = Role::find($id); /*Pesquisa a Role pela ID passada pela URL */
            $permissionsGroups = (PermissionGroup::all()); /*Seleciona todos os Grupos de Permissões Ex: (CISS, COMPRAS..)*/
            return view('gruposdeacesso::roleUpdate', compact('role', 'permissionsGroups'));
        }

    }


}
