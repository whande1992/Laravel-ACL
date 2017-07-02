{{--Configura o layout padrão para exibir essa view--}}
@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Grupos
@endsection


@section('main-content')
    <div class="container spark-screen">
        <div class="row">
            <div class="col-md-11 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-user"></i> Perfil de Usuários</div>

                    <div class="panel-body">

                        <a href="#" class="btn btn-app">
                            <i class="fa  fa-plus" data-toggle="modal" data-target="#myModal"></i>
                            Adicionar
                        </a>



                        <div class="panel-body">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class="fa  fa-users"></i> Grupos de Usuários Cadastrados</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-striped">
                                        <tbody>
                                        <tr>
                                            <th style="width: 10px">Código</th>
                                            <th>Nome</th>
                                            <th>Descrição</th>
                                            <th style="width: 40px">Ação</th>
                                        </tr>
                                        <!-- /.box-body -->      @if($roles)
                                            @foreach($roles as $role)
                                                <tr>
                                                    <td>{{ $role->id }}</td>
                                                    <td>{{ $role->nome }}</td>
                                                    <td>{{ $role->descricao }}</td>
                                                    <td><a class="btn btn-default" href="{{ route('actionUpdate',$role->id) }}"><i class="fa fa-lock" aria-hidden="true"></i> Permissões</a>  </td>
                                                    <td><a class="btn btn-default" href="{{ '' }}"><i class="fa fa-delicious" aria-hidden="true"></i> Deletar </a>  </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('gruposdeacesso::modalCreate')

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




