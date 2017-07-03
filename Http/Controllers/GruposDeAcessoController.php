<?php

namespace Modules\GruposDeAcesso\Http\Controllers;


use Validator;
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

            /*Valida as informações se estao de acordo*/
            $validator = Validator::make($request->all(), [
                'nome' => 'required|max:100',
                'descricao' => 'required',
            ]);
            /*Caso tenha erros, retorna com uma mensagem, e ao abrir o model e mostrado os dados digitados */
            if ($validator->fails()) {

                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            /*Cadastra uma nova role se o nome for diferente de admin*/
            $role = new Role;
            $role->nome = $request->nome;
            $role->descricao = $request->descricao;
            $role->save();
        } else {
            alert()->info('Já existe um grupo com perfil administrador, ele possui todas as permissões liberadas
            automaticamente, não é necessário criar outro.', 'Heey, você sabia?')->persistent('Ok, Entendi.');;
            return back();
        }
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
                /*Valida as informações se estao de acordo*/
                $validator = Validator::make($request->all(), [
                    'nome' => 'required|max:100',
                    'descricao' => 'required',
                ]);
                /*Caso tenha erros, retorna com uma mensagem, e ao abrir o model e mostrado os dados digitados */
                if ($validator->fails()) {

                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }
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
                Alert::info('Você não pode usar nomes como Admin ou Adminsitrador, já existe um grupo para essa funcionalidade.', 'Oops! Espere..')->persistent('Ok, Entendi.');
                return back();
            }
        } else {
            /*Se o codigo for null ou o id for 1 de administreador, retorna para index (Não pode alterar administrador)*/
            if (empty($id) or $id == 1) {
                Alert::info('Não é necessário editar um perfil administrador, 
                ele já possui todas as permissões liberadas automaticamente.', 'Oops! você sabia?')->persistent('Ok, Entendi.');
                return redirect(route('actionIndexRole'));
            }
            $role = Role::find($id); /*Pesquisa a Role pela ID passada pela URL */
            $permissionsGroups = (PermissionGroup::all()); /*Seleciona todos os Grupos de Permissões Ex: (CISS, COMPRAS..)*/
            return view('gruposdeacesso::roleUpdate', compact('role', 'permissionsGroups'));
        }

    }

    /**
     * verifica se o codigo é de administrador, e se o mesmo possui usuarios relacionados, após isso é excluido ou
     * retornado para view
     * @return Response
     */
    public function actionDelete($id)
    {
       /*Verifica se esta sendo excluido um perfil de administrator*/
        if($id == 1){
            Alert::info('Você não pode excluir um perfil de administrator, ele é um grupo padrão do sistema. ', 'Heey, Espere!')->persistent('Ok, Entendi.');
            return redirect(route('actionIndexRole'));
        }
        /*Verifica se ainda existem usuarios vinculados ao grupo,
        caso não existe, é excluido as permissões vinculadas a role,
        depois é excluido a role*/
        if (DB::table('role_user')->where('role_id',$id)->count() <> 0 ){
            DB::table('permission_role')->where('role_id',$id)->delete();
            DB::table('roles')->where('id',$id)->delete();

            Alert::success('', 'Excluido com sucesso!!');
        }else{
            Alert::info('Não foi possivel excluir, verifique se existem usuários relacionados a este grupo.', 'Verifique!')->persistent('Ok, Entendi.');
        }
        return redirect(route('actionIndexRole'));
    }


}
