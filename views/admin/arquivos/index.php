<?php $project->partial('admin', 'header'); ?>

<?php $auth->requireLevel(array(3)); ?>

<?php $c = new CRUD('arquivo'); ?>
<?php $paginationVars = $h->getPaginationVars();  ?>

<div class="container">
  
  <div class="page-header">
        <h1>
          Arquivos
          <div class="btn-group pull-right">
              <a href="<?php echo $h->urlFor('admin/arquivos/editar'); ?>" class="btn btn-success"> <i class="glyphicon glyphicon-plus"></i> Novo</a>
          </div>
        </h1>
  </div>

  <table class="table table-hover table-striped">
    <tr>
      <th>Nome</th>
      <th class="hidden-xs">Data criação</th>
      <th class="hidden-xs">Data atualização</th>
      <th>&nbsp;</th>
    </tr>

    <?php
       $c->findAll();
       
       $total = $c->executeQuery()->count();

       $resultados = $c->addLimit( $paginationVars['limit'] )->executeQuery();
      ?>

    <?php while( $resultado = $c->fetchAll() ): ?>
    
    <tr>
      <td><?php echo $resultado->nome ?></td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->created_at) ?></td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->updated_at) ?></td>
      <td class="actions">
        <a href="<?php echo $h->getUploadsPath($resultado->caminho) ?>" target="_blank" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Baixar"> <i class="glyphicon glyphicon-download"></i></a>
        <a href="<?php echo $h->urlFor('admin/cursos/deletar/'.$resultado->id); ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Remover"> <i class="glyphicon glyphicon-trash" ></i></a>
      </td>
    </tr>

    <?php endwhile; ?>

    <?php if( $c->count() == 0 ):  ?>
    <tr><td colspan="5" align="center">Nenhum resultado foi encontrado.</td></tr>
    <?php endif; ?>
    
  </table>

  <?php $h->pagination( $paginationVars['p'],  $total ); ?>

</div>


<?php $project->partial('admin', 'footer'); ?>