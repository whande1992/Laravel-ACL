@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Permissões de acesso dos usuários
@endsection


@section('main-content')
    <div class="container spark-screen">
        <div class="row">
            <div class="col-md-11 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-user"></i> Perfil de Usuários</div>

                    <div class="panel-body">

                        <button form="frmPerfil" class="btn btn-app"> <i class="fa  fa-save"></i>  Salvar</button>
                        <a href="{{route('actionDeleteRole',$role->id)}}"  class="btn btn-app"> <i class="fa fa-minus-circle text-red" aria-hidden="true"></i></i>  Excluir</a>

                        <form id="frmPerfil" action="{{route('actionUpdateRole',$role->id)}}" file="true" method="post" enctype='multipart/form-data'  >

                        {{ csrf_field() }}

                        <!-- Descrição do monitor -->
                            <div class="form-group ">
                                <label>Informações sobre o grupo</label>
                                <div class="input-group">
                                    <span class="input-group-addon "><i class="fa fa-users" aria-hidden="true"></i> Nome </span>
                                    <input name="nome"  type="text" class="form-control" placeholder="Grupo" value="{{$role->nome}}">
                                    <input name="roleId" hidden type="number" value="{{$role->id}}">
                                </div>

                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon "><i class="fa fa-list" aria-hidden="true"></i> Descrição </span>
                                    <input name="descricao"  type="text" class="form-control" placeholder="Descrição do Perfil" value="{{$role->descricao}}">

                                </div>

                            </div>

                            @forelse($permissionsGroups as $permissionsGroup)
                                <div class="panel-body">
                                    <div class="box box-success">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><i class="fa fa-angle-right" aria-hidden="true"></i> {{ $permissionsGroup->nome }}</h3>
                                            <div class="box-tools pull-right">
                                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                            </div><!-- /.box-tools -->
                                        </div><!-- /.box-header -->

                                        <div class="box-body">
                                            @foreach($permissionsGroup->Permissions as $permission)
                                                <label>
                                                    <input name="permission[]"  type="checkbox"  {{  \Modules\GruposDeAcesso\Helpers\HelperGrupos::checkPermission($permission->id, $role->id) }}    value="{{$permission->id}}">
                                                    {{$permission->descricao}}
                                                </label>
                                                <hr>
                                            @endforeach
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div>
                                @empty
                                <p>Nenhum registro foi encontrado.</p>
                            @endforelse
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts_master')

    <script src="{{ asset('/plugins/iCheck/icheck.js') }} "></script>

    <script>
        $(document).ready(function(){
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-red',
                increaseArea: '20%' // optional
            });
        });
    </script>

@endsection

