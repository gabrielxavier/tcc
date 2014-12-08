<?php $project->partial('admin', 'header'); ?>

<?php $c = new CRUD('usuario'); ?>
<?php $paginationVars = $h->getPaginationVars();  ?>

<div class="container">
  
  <div class="page-header">
        <h1>Professores</h1>
  </div>

  <table class="table table-hover table-striped">
    <tr>
      <th>Matricula</th>
      <th>Nome</th>
      <th>Email</th>
      <th class="hidden-xs">Data criação</th>
      <th class="hidden-xs">Data atualização</th>
    </tr>

    <?php
       $c->findAll('id_perfil = "2"');
       
       $total = $c->executeQuery()->count();

       $resultados = $c->addLimit( $paginationVars['limit'] )->executeQuery();
      ?>

    <?php while( $resultado = $c->fetchAll() ): ?>
    
    <tr>
      <td><?php echo $resultado->matricula ?></td>
      <td><?php echo $resultado->nome ?></td>
      <td><?php echo $resultado->email ?></td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->created_at) ?></td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->updated_at) ?></td>
    </tr>

    <?php endwhile; ?>
    
  </table>

  <?php $h->pagination( $paginationVars['p'],  $total ); ?>

</div>


<?php $project->partial('admin', 'footer'); ?>