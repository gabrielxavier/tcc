<?php $project->partial('admin', 'header'); ?>

<?php $auth->requireLevel(array(3)); ?>

<?php $c = new CRUD('usuario'); ?>
<?php $id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL ?>
<?php 
  if($id)
  {
    $registro = $c->findOneById($id)->executeQuery()->fetchAll();
  }else{
    $registro = new Usuario();
  }
?>

<div class="container">
  
    <div class="page-header">
        <h1>Alunos <small><?=(!$id)? 'Adicionar' : 'Editar' ?></small> <a href="<?php echo $h->urlFor('admin/alunos'); ?>" class="btn btn-primary pull-right"> <i class="glyphicon glyphicon-list"></i> Lista</a></h1>
    </div>

    <?php $formAction = ($id)? $h->urlFor('admin/alunos/editar/'. $id) : $h->urlFor('admin/alunos/editar'); ?>
    <form action="<?=$formAction?>" method="POST">
        <input type="hidden" name="id" value="<?=$id?>">
        <div class="panel panel-primary">
            <?php if($id): ?><div class="panel-heading">#<?=$id?></div><?php endif; ?>
            <div class="panel-body">

                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control required" id="nome" name="nome" value="<?=$registro->nome?>">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control required email" id="email" name="email" value="<?=$registro->email?>">
                </div>

                <div class="form-group">
                    <label for="matricula">Matrícula</label>
                    <input type="text" class="form-control required" id="matricula" name="matricula" value="<?=$registro->matricula?>">
                </div>

                <div class="form-group">
                    <label for="telefone_residencial">Telefone Residencial</label>
                    <input type="text" class="form-control phone" id="telefone_residencial" name="telefone_residencial" value="<?=$registro->telefone_residencial?>">
                </div>

                <div class="form-group">
                    <label for="telefone_comercial">Telefone Comercial</label>
                    <input type="text" class="form-control phone" id="telefone_comercial" name="telefone_comercial" value="<?=$registro->telefone_comercial?>">
                </div>

                <div class="form-group">
                    <label for="telefone_celular">Telefone Celular</label>
                    <input type="text" class="form-control celphone" id="telefone_celular" name="telefone_celular" value="<?=$registro->telefone_celular?>">
                </div>

                <div class="form-group">
                    <label for="ativo">Turmas</label>
                    <a href="#" class="btn btn-success pull-right btn-new-turma"> <i class="glyphicon glyphicon-plus"></i> Nova turma</a>
                </div>
                
                <?php
                    $crudTurmas = new CRUD('turma');
                  
                    if($id){
                       
                        $crudTurmasCadastradas = new CRUD('turma_aluno');
                        $turmasCadastradas = $crudTurmasCadastradas->findAll(' id_aluno = "'. $id. '" ')->executeQuery();
                      
                        while( $turmaCadastrada = $crudTurmasCadastradas->fetchAll() )
                        { 
                            $turmaID = $turmaCadastrada->id_turma; 
                            $turmas = $crudTurmas->findAll()->executeQuery(); 
                        ?>
                            
                            <div class="form-group field-turma">
                                <div class="input-group">
                                    <select name="turmas[]" class="form-control">
                                        <option value="">Selecione</option>
                                    <?php while( $turma = $crudTurmas->fetchAll() ): ?>
                                        <option value="<?=$turma->id?>" <?=($turmaID == $turma->id)?'selected="selected"':''?>>
                                            <?=$turma->sigla.' - '.$turma->semestre  ?>
                                        </option>           
                                    <?php endwhile; ?>
                                    </select>
                                     <div class="input-group-btn">
                                        <a href="#" class="btn btn-danger pull-right btn-delete-turma"> <i class="glyphicon glyphicon-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                                
                        <?php } ?>
    
                <?php   }   ?>

                <div class="form-group field-turma">
                    <div class="input-group">
                        <select name="turmas[]" class="form-control">
                            <option value="">Selecione</option>
                        <?php $turmas = $crudTurmas->findAll()->executeQuery(); ?>
                        <?php while( $turma = $crudTurmas->fetchAll() ): ?>
                            <option value="<?=$turma->id?>"> <?=$turma->sigla.' - '.$turma->semestre  ?></option>           
                        <?php endwhile; ?>
                        </select>
                         <div class="input-group-btn">
                            <a href="#" class="btn btn-danger pull-right btn-delete-turma"> <i class="glyphicon glyphicon-trash"></i></a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-footer">
              <button type="submit" class="btn btn-success"> <i class="glyphicon glyphicon-floppy-disk"></i> Salvar </button> 
            </div>
        </div>
    </form>   

</div>

<?php $project->partial('admin', 'footer'); ?>


<?php 
  
  if( isset($_POST['nome']) )
  {

    $aluno = new Usuario();
    $aluno->id = $_POST['id'];
    $aluno->nome = $_POST['nome'];
    $aluno->email = $_POST['email'];
    $aluno->matricula = $_POST['matricula'];
    $aluno->telefone_residencial = $_POST['telefone_residencial'];
    $aluno->telefone_comercial = $_POST['telefone_comercial'];
    $aluno->telefone_celular = $_POST['telefone_celular'];
    $aluno->id_perfil = 1;
    $aluno->senha = ($_POST['id'])? false : 'false';

    if( $_POST['id'] == '' )
    {
        $id = $c->nextID();
        $c->save($aluno)->executeQuery();

        $h->addFlashMessage('success', 'Aluno adicionado com sucesso!');
    }
    else
    {
        $c->clearQuery()->update($aluno)->executeQuery();
        $id = $aluno->id;

        $h->addFlashMessage('success', 'Aluno alterado com sucesso!');
    }

    if( $c->getExecutedQuery() )
    {
        $crudTurma = new CRUD('turma_aluno');
        $crudTurma->delete('id_aluno = "'. $id .'"')->executeQuery();
        foreach ($_POST['turmas'] as $key => $value) {
            if( intval($value) > 0 )
            {
                $turmaAluno = new Turmaaluno();
                $turmaAluno->id_aluno = $id;
                $turmaAluno->id_turma = $value;
                $crudTurma->save($turmaAluno)->executeQuery();
            }
        }
    }

    $h->redirectFor('admin/alunos');

  }

?>
