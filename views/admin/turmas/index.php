<?php $project->partial('admin', 'header'); ?>

<?php $c = new CRUD('turma'); ?>
<?php $paginationVars = $h->getPaginationVars();  ?>

<div class="container">
  
  <div class="page-header">
        <h1>Turmas</h1>
  </div>

  <table class="table table-hover table-striped">
    <tr>
      <th>Sigla</th>
      <th>Nome</th>
      <th class="hidden-xs">Data criação</th>
      <th class="hidden-xs">Data atualização</th>
      <th></th>
    </tr>

    <?php
       $c->findAll();
       
       $total = $c->executeQuery()->count();

       $resultados = $c->addLimit( $paginationVars['limit'] )->executeQuery();
      ?>

    <?php while( $resultado = $c->fetchAll() ): ?>
    
    <tr>
      <td><?php echo $resultado->sigla ?></td>
      <td><?php echo $resultado->nome ?></td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->created_at) ?></td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->updated_at) ?></td>
      <td class="actions" width="100">
        <a href="<?php echo $h->urlFor('admin/turmas/call/'.$resultado->id); ?>" class="btn btn-info"> <i class="glyphicon glyphicon-send"></i> Enviar acesso </a>
      </td>
    </tr>

    <?php endwhile; ?>
    
  </table>

  <?php $h->pagination( $paginationVars['p'],  $total ); ?>

</div>


<?php $project->partial('admin', 'footer'); ?>