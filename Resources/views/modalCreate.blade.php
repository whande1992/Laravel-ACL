<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cadastro de Perfil de Usuários</h4>
                <p>Cadastre o perfil inserindo um nome e uma breve descrição, após o cadastro lembre-se
                de configurar as permissões.</p>

            </div>
            <div class="modal-body">

                <form id="frmPerfil" action="{{route('actionCreateRole')}}" file="true" method="post" enctype='multipart/form-data'  >

                    {{ csrf_field() }}


                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-users" aria-hidden="true"></i> Nome do Perfil</span>
                            <input name="nome" required minlength="3" type="text" value="{{  old('nome')  }}" class="form-control" placeholder="Nome do perfil de usuário" aria-describedby="basic-addon1">
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"  id="basic-addon1"><i class="fa fa-list" aria-hidden="true"></i> Descrição</span>
                            <input name="descricao" required minlength="3" value="{{  old('descricao')  }}" type="text" class="form-control" placeholder="Descrição do perfil de usuário" aria-describedby="basic-addon1">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger " data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
                <button form="frmPerfil" type="submit"  class="btn btn-success" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar</button>
            </div>
        </div>

    </div>
</div>