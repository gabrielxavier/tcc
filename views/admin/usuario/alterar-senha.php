<?php $project->partial('admin', 'header'); ?>

<div class="container">
  
    <div class="page-header">
        <h1>Meus Dados <small>alterar senha</small> </h1>
    </div>

    <form action="<?=$h->urlFor('admin/usuario/alterar-senha')?>" method="POST">
        <div class="panel panel-primary">
            <div class="panel-body">
                
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="titulo">Informe a senha atual</label>
                            <input type="password" class="form-control required" id="senha_atual" name="senha_atual">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="titulo">Informe a nova senha</label>
                            <input type="password" class="form-control required" data-rule-minlength="6" id="senha_nova" name="senha_nova">
                        </div>
                    </div>
                </div>

                 <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="titulo">Informe a nova senha novamente</label>
                            <input type="password" class="form-control required" equalto="#senha_nova" id="senha_confirma" name="senha_confirma">
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-footer">
              <button type="submit" class="btn btn-success"> <i class="glyphicon glyphicon-floppy-disk"></i> Salvar </button> 
            </div>
        </div>
    </form>   

<?php $project->partial('admin', 'footer'); ?>


<?php 
  
  if( isset($_POST['senha_atual']) && $_POST['senha_atual'] != '')
  {

    if( $_POST['senha_nova'] != $_POST['senha_confirma'] )
    {
        $h->addFlashMessage('error','As novas senhas informadas não conferem!');
        $h->redirectFor('admin/usuario/alterar-senha');
    }else {

        $crudUser = new CRUD('usuario');
        $crudUser->findAll()->addWhere(' id = "'.$auth->getSessionInfo('userID').'" and senha = "'.md5($_POST['senha_atual']).'"')->executeQuery();
        if( $crudUser->count() < 1 )
        {
            $h->addFlashMessage('error','A senha antiga não confere!');
            $h->redirectFor('admin/usuario/alterar-senha');
        }else{

            $usuario = new Usuario();
            $usuario->id = $auth->getSessionInfo('userID');
            $usuario->senha = md5($_POST['senha_nova']);

            $crudUser->update($usuario)->executeQuery();
            if( $crudUser->getExecutedQuery() )
            {
                $h->addFlashMessage('success','Senha alterada com sucesso!');
                $h->redirectFor('admin/index');
            }else{
                $h->addFlashMessage('error','Não foi possível alterar a senha!');
                $h->redirectFor('admin/usuario/alterar-senha');
            }

        }


    }

  }

?>
