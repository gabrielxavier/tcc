<?php $project->partial('admin', 'header'); ?>

<?php 
     $c = new CRUD('usuario');
     $usuario = $c->findAll(' id = "'.$auth->getSessionInfo('userID').'" ')->executeQuery()->fetchAll();
?>

<div class="container">
  
    <div class="page-header">
        <h1>Meus Dados <small>alterar cadastro</small> </h1>
    </div>

    <form action="<?=$h->urlFor('admin/usuario/alterarCadastro')?>" method="POST">
        <div class="panel panel-primary">
            <div class="panel-body">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="titulo">Matrícula</label>
                            <input type="text" class="form-control" value="<?php echo $usuario->matricula ?>" readonly>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control required email" id="email" name="email" value="<?php echo $usuario->email ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="telefone_residencial">Telefone Residencial</label>
                            <input type="text" class="form-control phone" id="telefone_residencial" name="telefone_residencial" value="<?php echo $usuario->telefone_residencial ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="telefone_comercial">Telefone Comercial</label>
                            <input type="text" class="form-control phone" id="telefone_comercial" name="telefone_comercial" value="<?php echo $usuario->telefone_comercial ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="telefone_celular">Telefone Celular</label>
                            <input type="text" class="form-control celphone" id="telefone_celular" name="telefone_celular" value="<?php echo $usuario->telefone_celular ?>">
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-footer">
              <button type="submit" class="btn btn-success" name="salvar"> <i class="glyphicon glyphicon-floppy-disk"></i> Salvar </button> 
            </div>
        </div>
    </form>   

<?php $project->partial('admin', 'footer'); ?>


<?php 
  
  if( isset($_POST['salvar']) )
  {
    
    $aluno = new Usuario();
    $aluno->id = $auth->getSessionInfo('userID');
    $aluno->email = $_POST['email'];
    $aluno->telefone_residencial = $_POST['telefone_residencial'];
    $aluno->telefone_comercial = $_POST['telefone_comercial'];
    $aluno->telefone_celular = $_POST['telefone_celular'];
    
    $c->update($aluno)->executeQuery();

    if( $c->getExecutedQuery() )
    {
       $h->addFlashMessage('success', 'Cadastro alterado com sucesso!');
    }else{
        $h->addFlashMessage('error', 'Erro ao alterar o cadastro!');
    }

    $h->redirectFor('admin/usuario/alterarCadastro');

  }

?>
