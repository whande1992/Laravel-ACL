<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cadastro de Perfil de Usuários</h4>
                <hr>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
                <form id="frmPerfil" action="{{route('actionCreate')}}" file="true" method="post" enctype='multipart/form-data'  >

                    {{ csrf_field() }}


                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Nome do Perfil</span>
                            <input name="nome" type="text" class="form-control" placeholder="Nome do perfil de usuário" aria-describedby="basic-addon1">
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Descrição</span>
                            <input name="descricao" type="text" class="form-control" placeholder="Descrição do perfil de usuário" aria-describedby="basic-addon1">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button form="frmPerfil" type="submit"  class="btn btn-success" >Salvar</button>
            </div>
        </div>

    </div>
</div>