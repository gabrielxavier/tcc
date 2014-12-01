<?php $project->partial('admin', 'header'); ?>

<?php $c = new CRUD('projeto'); ?>
<?php $paginationVars = $h->getPaginationVars();  ?>

<div class="container">
  
  <div class="page-header">
        <h1>Projetos <a href="<?php echo $h->urlFor('admin/projetos/editar'); ?>" class="btn btn-success pull-right"> <i class="glyphicon glyphicon-plus"></i> Novo</a></h1>
  </div>

  <table class="table table-hover table-striped">
    <tr>
      <th>#</th>
      <th>Título</th>
      <th>Descricao</th>
      <th>Ativo</th>
      <th>Data criação</th>
      <th>Data atualização</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
    </tr>

    <?php
       $c->findAll();
       
       $total = $c->executeQuery()->count();

       $resultados = $c->addLimit( $paginationVars['limit'] )->executeQuery();
      ?>

    <?php while( $resultado = $c->fetchAll() ): ?>
    
    <tr>
      <td><?php echo $resultado->id ?></td>
      <td><?php echo $resultado->titulo ?></td>
      <td><?php echo $resultado->descricao ?></td>
      <td><?php echo ($resultado->ativo)? 'Sim' : 'Não' ?></td>
      <td><?php echo $h->dateTimeFromDB($resultado->created_at) ?></td>
      <td><?php echo $h->dateTimeFromDB($resultado->updated_at) ?></td>
      <td width="20"><a href="<?php echo $h->urlFor('admin/projetos/editar/'.$resultado->id); ?>" class="btn btn-warning pull-right"> <i class="glyphicon glyphicon-edit"></i></a></td>
      <td width="20"><a href="<?php echo $h->urlFor('admin/projetos/deletar/'.$resultado->id); ?>" class="btn btn-danger pull-right"> <i class="glyphicon glyphicon-trash"></i></a></td>
    </tr>

    <?php endwhile; ?>
    
  </table>

  <?php $h->pagination( $paginationVars['p'],  $total ); ?>

</div>


<?php $project->partial('admin', 'footer'); ?>