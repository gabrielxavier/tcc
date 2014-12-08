<?php $project->partial('admin', 'header'); ?>

<?php $c = new CRUD('projeto'); ?>
<?php $paginationVars = $h->getPaginationVars();  ?>

<div class="container">
  
  <div class="page-header">
        <h1>
          Projetos 
          <?php if( $auth->getSessionInfo()['userLevel'] == 3): ?>
            <a href="<?php echo $h->urlFor('admin/projetos/editar'); ?>" class="btn btn-success pull-right"> <i class="glyphicon glyphicon-plus"></i> Novo</a>
          <?php endif; ?>
        </h1>
  </div>

  <table class="table table-hover table-striped">
    <tr>
      <th>Título</th>
      <th class="hidden-xs">Descricao</th>
      <th>Ativo</th>
      <th class="hidden-xs">Data criação</th>
      <th class="hidden-xs">Data atualização</th>
      <th>&nbsp;</th>
    </tr>

    <?php
       $c->findAll(' 1 = 1 ', 'projeto.*');

       // Controle de usuários 
      if( $auth->getSessionInfo()['userLevel'] == 1 )
       {
        $c->addJoin('projeto_curso pc');
        $c->addJoin('turma t');
        $c->addJoin('turma_aluno ta');
        $c->addWhere('projeto.id = pc.id_projeto');
        $c->addWhere('t.id_curso = pc.id_curso');
        $c->addWhere('t.id = ta.id_turma');
        $c->addWhere('ta.id_aluno = "'.$auth->getSessionInfo()['userID'].'"');
        
        $c->addWhere(' projeto.ativo = "1" ');
      }
      else if( $auth->getSessionInfo()['userLevel'] == 2 )
      {
        $c->addJoin('projeto_professor pf');
        $c->addWhere('pf.id_projeto = projeto.id');
        $c->addWhere('pf.id_professor = "'.$auth->getSessionInfo()['userID'].'"');

        $c->addWhere(' projeto.ativo = "1" ');
      }
       
       $total = $c->executeQuery()->count();

       $resultados = $c->addLimit( $paginationVars['limit'] )->executeQuery();

      ?>

    <?php while( $resultado = $c->fetchAll() ): ?>
    
    <tr>
      <td><?php echo $resultado->titulo ?></td>
      <td class="hidden-xs"><?php echo $resultado->descricao ?></td>
      <td><?php echo ($resultado->ativo)? 'Sim' : 'Não' ?></td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->created_at) ?></td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->updated_at) ?></td>
      <td class="actions">
        <a href="<?php echo $h->urlFor('admin/projetos/visualizar/'.$resultado->id); ?>" class="btn btn-info"> <i class="glyphicon glyphicon-eye-open"></i></a>
        <?php if( $auth->getSessionInfo()['userLevel'] == 3): ?>
          <a href="<?php echo $h->urlFor('admin/projetos/editar/'.$resultado->id); ?>" class="btn btn-warning"> <i class="glyphicon glyphicon-edit"></i></a>
          <a href="<?php echo $h->urlFor('admin/projetos/deletar/'.$resultado->id); ?>" class="btn btn-danger"> <i class="glyphicon glyphicon-trash"></i></a>
        <?php endif; ?>
      </td>
    </tr>

    <?php endwhile; ?>

    <?php if( $c->count() == 0 ):  ?>
    <tr><td colspan="7" align="center">Nenhum resultado foi encontrado.</td></tr>
    <?php endif; ?>
    
  </table>

  <?php $h->pagination( $paginationVars['p'],  $total ); ?>

</div>


<?php $project->partial('admin', 'footer'); ?>