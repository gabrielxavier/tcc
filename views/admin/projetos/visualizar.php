<?php $project->partial('admin', 'header'); ?>

<?php $c = new CRUD('projeto'); ?>
<?php $id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL ?>
<?php $id_aluno = $auth->getSessionInfo('userID') ?> 
<?php 
  if($id)
  {
    $registro = $c->findOneById($id)->executeQuery()->fetchAll();
    if(!$registro)
         $h->redirectFor('admin/projetos');
  }else{
    $h->redirectFor('admin/projetos');
  }
?>

<div class="container">
  
    <div class="page-header">
        <h1>
            Projetos <small>Visualizar</small>
            <div class="btn-group pull-right">
                <?php if( $auth->getSessionInfo('userLevel') == 3): ?>
                <a href="<?php echo $h->urlFor('admin/projetos/editar/'.$registro->id); ?>" class="btn btn-warning">
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
                Título
            </th>
            <td>
                <?php echo $registro->titulo ?>
            </td>
        </tr>
        <tr>
            <th>
                Descrição
            </th>
            <td>
                <?php echo nl2br(strip_tags($registro->descricao)) ?>
            </td>
        </tr>
        <tr>
            <th>
                Tags
            </th>
            <td>
                <?php 
                $tags = explode( ',', $registro->tags); 
                foreach ($tags as $tag) {
                    echo '<span class="label label-success">'.$tag.'</span> ';
                }
                ?>
            </td>
        </tr>
        <tr>
            <th>
                Orientadores
            </th>
            <td>    
                <?php 
                    $crudOrientadores = new CRUD('usuario');
                    $crudOrientadores
                    ->findAll(' ( id_perfil = 2 OR id_perfil = 3 ) ', ' usuario.nome, usuario.email ')
                    ->addJoin('projeto_professor')
                    ->addWhere('projeto_professor.id_projeto = "'.$id.'"')
                    ->addWhere(' projeto_professor.id_professor = usuario.id ')
                    ->executeQuery();

                    while( $orientador = $crudOrientadores->fetchAll() ):
                ?>
                    <span class="block"> <?=$orientador->nome?> (<?=$orientador->email?>) </span>
                <?php
                    endwhile;
                ?>
            </td>
        </tr>
        <tr>
            <th>
                Cursos
            </th>
            <td>    
                <?php 
                    $crudCursos = new CRUD('curso');
                    $crudCursos
                    ->findAll()
                    ->addJoin('projeto_curso')
                    ->addWhere('projeto_curso.id_projeto = "'.$id.'"')
                    ->addWhere(' projeto_curso.id_curso = curso.id ')
                    ->executeQuery();

                    while( $curso = $crudCursos->fetchAll() ):
                ?>
                    <span class="block"> <?=$curso->sigla?> (<?=$curso->nome?>) </span>
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
        <tr>
            <th>
                Ativo
            </th>
            <td>
                <?php echo ($registro->ativo) ? 'Sim' : 'Não' ?>
            </td>
        </tr>
        <?php endif; ?>
    </table>

</div>

<?php $project->partial('admin', 'footer'); ?>