<?php $project->partial('admin', 'header'); ?>

<?php $auth->requireLevel(array(3,2)); ?>

<?php $c = new CRUD('usuario'); ?>
<?php $paginationVars = $h->getPaginationVars();  ?>

<div class="container">
  
  <div class="page-header">
        <h1>
          Alunos
          <div class="btn-group pull-right">
            <?php if($auth->isLevel(3)): ?>
            <a href="<?php echo $h->urlFor('admin/alunos/editar'); ?>" class="btn btn-success"> <i class="glyphicon glyphicon-plus"></i> Adicionar</a>
            <a href="<?php echo $h->urlFor('admin/alunos/importar'); ?>" class="btn btn-default"> <i class="glyphicon glyphicon-arrow-up"></i> Importar</a>
            <?php endif; ?>
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modal-filtro"> <i class="glyphicon glyphicon-search"></i> Filtrar</a>
            <?php if( $h->haveFilters('alunos') ): ?>
              <a href="<?php echo $h->urlFor('admin/alunos/filtrar'); ?>" class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Limpar filtros</a>
            <?php endif; ?>
          </div>
        </h1>
  </div>

  <table class="table table-hover table-striped">
    <tr>
      <th>Matricula</th>
      <th>Nome</th>
      <th>Email</th>
      <th class="hidden-xs">Data criação</th>
      <th class="hidden-xs">Data atualização</th>
      <th>&nbsp;</th>
    </tr>

    <?php
       $c->findAll('id_perfil = 1','usuario.*');

       // Filtros
      if( $h->getFilter('alunos', 'matricula') != '' )
      {
        $c->addWhere(' matricula = "'.$h->getFilter('alunos', 'matricula').'" ');
      }

      if( $h->getFilter('alunos', 'nome') != '' )
      {
        $c->addWhere(' nome LIKE "%'.$h->getFilter('alunos', 'nome').'%" ');
      }

      if( $h->getFilter('alunos', 'id_turma') > 0 )
      {
        $c->addJoin('turma_aluno t_a');
        $c->addWhere(' usuario.id = t_a.id_aluno AND t_a.id_turma = "'.$h->getFilter('alunos', 'id_turma').'" ');
      }
       
      $total = $c->executeQuery()->count();

      $resultados = $c->addLimit( $paginationVars['limit'] )->addOrder(' nome ASC ')->executeQuery();
    ?>

    <?php while( $resultado = $c->fetchAll() ): ?>
    
    <tr>
      <td><?php echo $resultado->matricula ?></td>
      <td><?php echo $resultado->nome ?></td>
      <td><?php echo $resultado->email ?></td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->created_at) ?></td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->updated_at) ?></td>
      <td class="actions">
        <a href="<?php echo $h->urlFor('admin/alunos/visualizar/'.$resultado->id); ?>" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Visualizar"> <i class="glyphicon glyphicon-eye-open"></i></a>
        <?php if($auth->isLevel(3)): ?>
        <a href="<?php echo $h->urlFor('admin/alunos/editar/'.$resultado->id); ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="glyphicon glyphicon-edit"></i></a>
        <a href="<?php echo $h->urlFor('admin/alunos/deletar/'.$resultado->id); ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Remover"> <i class="glyphicon glyphicon-trash" ></i></a>
        <?php endif; ?>
      </td>
    </tr>

    <?php endwhile; ?>

    <?php if( $c->count() == 0 ):  ?>
    <tr><td colspan="5" align="center">Nenhum resultado foi encontrado.</td></tr>
    <?php endif; ?>
    
  </table>

  <?php $h->pagination( $paginationVars['p'],  $total ); ?>

</div>

<!-- Modal -->
<div class="modal fade" id="modal-filtro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo $h->urlFor('admin/alunos/filtrar'); ?>" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Filtro</h4>
      </div>
      <div class="modal-body">
       
          <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $h->getFilter('alunos', 'nome') ?>">
          </div>

           <div class="form-group">
                <label for="matricula">Matrícula</label>
                <input type="text" class="form-control" id="matricula" name="matricula" value="<?php echo $h->getFilter('alunos', 'matricula') ?>">
          </div>

          <div class="form-group">
                <label for="id_turma">Turma</label>
                <select name="id_turma" id="id_turma" class="form-control">
                 <option value="0">Todas</option>
                <?php
                  $crudTurmas = new CRUD('turma');
                  $turmas = $crudTurmas->findAll()->executeQuery();

                  while( $turma = $turmas->fetchAll() ): 
                    $selected = ( $h->getFilter('alunos', 'id_turma') == $turma->id )? 'selected="selected"' : '';
                    echo '<option value="'.$turma->id.'" '.$selected.'>'.$turma->sigla.' - '.$turma->semestre.'</option>';
                  endwhile;
               ?>
                </select>
          </div>
       
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Filtrar</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php $project->partial('admin', 'footer'); ?>