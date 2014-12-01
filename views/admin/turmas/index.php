<?php $project->partial('admin', 'header'); ?>

<?php $c = new CRUD('turma'); ?>
<?php $paginationVars = $h->getPaginationVars();  ?>

<div class="container">
  
  <div class="page-header">
        <h1>Turmas</h1>
  </div>

  <table class="table table-hover table-striped">
    <tr>
      <th>#</th>
      <th>Sigla</th>
      <th>Nome</th>
      <th>Data criação</th>
      <th>Data atualização</th>
    </tr>

    <?php
       $c->findAll();
       
       $total = $c->executeQuery()->count();

       $resultados = $c->addLimit( $paginationVars['limit'] )->executeQuery();
      ?>

    <?php while( $resultado = $c->fetchAll() ): ?>
    
    <tr>
      <td><?php echo $resultado->id ?></td>
      <td><?php echo $resultado->sigla ?></td>
      <td><?php echo $resultado->nome ?></td>
      <td><?php echo $h->dateTimeFromDB($resultado->created_at) ?></td>
      <td><?php echo $h->dateTimeFromDB($resultado->updated_at) ?></td>
    </tr>

    <?php endwhile; ?>
    
  </table>

  <?php $h->pagination( $paginationVars['p'],  $total ); ?>

</div>


<?php $project->partial('admin', 'footer'); ?>