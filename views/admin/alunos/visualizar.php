<?php $project->partial('admin', 'header'); ?>

<?php $c = new CRUD('usuario'); ?>
<?php $id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL ?>
<?php 
  if($id)
  {
    $registro = $c->findOneById($id)->addWhere(' id_perfil = 1 ')->executeQuery()->fetchAll();
    if(!$registro){
        $h->addFlashMessage('error', 'Aluno não encontrado!');
        $h->redirectFor('admin/alunos');
    }
  }else{
    $h->addFlashMessage('error', 'Aluno não encontrado!');
    $h->redirectFor('admin/alunos');
  }
?>

<div class="container">
  
    <div class="page-header">
        <h1>
            Alunos <small>Visualizar</small>
            <div class="btn-group pull-right">
                <?php if( $auth->getSessionInfo('userLevel') > 2): ?>
                    <a href="<?php echo $h->urlFor('admin/alunos/editar/'.$registro->id); ?>" class="btn btn-warning">
                        <i class="glyphicon glyphicon-edit"></i> Editar
                    </a>
                <?php endif; ?>
                <a href="<?php echo $h->urlFor('admin/projetos'); ?>" class="btn btn-primary">
                    <i class="glyphicon glyphicon-list"></i> Lista
                </a>
            </div>
        </h1>
    </div>

    <table class="table table-hover">
        <tr>
            <th width="180">
                Nome
            </th>
            <td>
                <?php echo $registro->nome ?>
            </td>
        </tr>
        <tr>
            <th>
                Matrícula
            </th>
            <td>
                <?php echo $registro->matricula ?>
            </td>
        </tr>
        <tr>
            <th>
                E-mail
            </th>
            <td>
                <?php echo $registro->email ?>
            </td>
        </tr>
         <tr>
            <th>
                Telefone residencial
            </th>
            <td>
                <?php echo $registro->telefone_residencial ?>
            </td>
        </tr>
        <tr>
            <th>
                Telefone comercial
            </th>
            <td>
                <?php echo $registro->telefone_comercial ?>
            </td>
        </tr>
        <tr>
            <th>
                Telefone celular
            </th>
            <td>
                <?php echo $registro->telefone_celular ?>
            </td>
        </tr>
         <tr>
            <th>
                Último acesso em
            </th>
            <td>
                <?php echo $h->dateTimeFromDB($registro->ultimo_acesso) ?>
            </td>
        </tr>
        <tr>
            <th>
                Turmas
            </th>
            <td>    
                <?php 
                    $crudTurmas = new CRUD('turma');
                    $crudTurmas
                    ->findAll()
                    ->addJoin('turma_aluno')
                    ->addWhere('turma_aluno.id_aluno = "'.$id.'"')
                    ->addWhere(' turma_aluno.id_turma = turma.id ')
                    ->executeQuery();

                    while( $turma = $crudTurmas->fetchAll() ):
                ?>
                    <span class="block"> <?=$turma->sigla?> (<?=$turma->nome?>) - <?=$turma->semestre?> </span>
                <?php
                    endwhile;
                ?>
            </td>
        </tr>
        <?php if( $auth->getSessionInfo('userLevel') == 3): ?>
        <tr>
            <th>
                Criado em
            </th>
            <td>
                <?php echo $h->dateTimeFromDB($registro->created_at) ?>
            </td>
        </tr>
        <tr>
            <th>
                Modificado em
            </th>
            <td>
               <?php echo $h->dateTimeFromDB($registro->updated_at) ?>
            </td>
        </tr>
        <?php endif; ?>
    </table>

</div>

<?php $project->partial('admin', 'footer'); ?>