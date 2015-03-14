<?php $project->partial('admin', 'header'); ?>

<?php $c = new CRUD('turma'); ?>
<?php $paginationVars = $h->getPaginationVars();  ?>

<div class="container">
  
  <div class="page-header">
        <h1>
          Turmas
          <div class="btn-group pull-right">
              <a href="<?php echo $h->urlFor('admin/turmas/editar'); ?>" class="btn btn-success"> <i class="glyphicon glyphicon-plus"></i> Novo</a>
              <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modal-filtro"> <i class="glyphicon glyphicon-search"></i> Filtrar</a>
              <?php if( $h->haveFilters('turmas') ): ?>
                <a href="<?php echo $h->urlFor('admin/turmas/filtrar'); ?>" class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Limpar filtros</a>
              <?php endif; ?>
          </div>
        </h1>
  </div>

  <table class="table table-hover table-striped">
    <tr>
      <th>Sigla</th>
      <th>Nome</th>
      <th>Semestre</th>
      <th class="hidden-xs">Data criação</th>
      <th class="hidden-xs">Data atualização</th>
      <th></th>
    </tr>

    <?php
       $c->findAll();

       // Filtros
      if( $h->getFilter('turmas', 'sigla') != '' )
      {
        $c->addWhere(' sigla = "'.$h->getFilter('turmas', 'sigla').'" ');
      }

      if( $h->getFilter('turmas', 'nome') != '' )
      {
        $c->addWhere(' nome LIKE "%'.$h->getFilter('turmas', 'nome').'%" ');
      }

      if( $h->getFilter('turmas', 'id_curso') != '' )
      {
        $c->addWhere(' id_curso = "'.$h->getFilter('turmas', 'id_curso').'" ');
      }

      if( $h->getFilter('turmas', 'slug_semestre') != "" )
      {
       $c->addWhere(' semestre = "'.$h->getFilter('turmas', 'slug_semestre').'" ');
      }
       
       $total = $c->executeQuery()->count();

       $resultados = $c->addLimit( $paginationVars['limit'] )->executeQuery();
      ?>

    <?php while( $resultado = $c->fetchAll() ): ?>
    
    <tr>
      <td><?php echo $resultado->sigla ?></td>
      <td><?php echo $resultado->nome ?></td>
      <td><?php echo $resultado->semestre ?></td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->created_at) ?></td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->updated_at) ?></td>
      <td class="actions">
        <a href="<?php echo $h->urlFor('admin/turmas/editar/'.$resultado->id); ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="glyphicon glyphicon-edit"></i></a>
        <a href="<?php echo $h->urlFor('admin/turmas/deletar/'.$resultado->id); ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Remover"> <i class="glyphicon glyphicon-trash" ></i></a>
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
      <form action="<?php echo $h->urlFor('admin/turmas/filtrar'); ?>" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Filtro</h4>
      </div>
      <div class="modal-body">
       
          <div class="form-group">
              <label for="sigla">Sigla</label>
              <input type="text" class="form-control" id="sigla" name="sigla" value="<?php echo $h->getFilter('turmas', 'sigla') ?>">
          </div>

          <div class="form-group">
              <label for="nome">Nome</label>
              <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $h->getFilter('turmas', 'nome') ?>">
          </div>
          
          <div class="form-group">
                <label for="id_curso">Curso</label>
                <select name="id_curso" id="id_curso" class="form-control">
                 <option value="0">Todos</option>
                <?php
                  $crudCursos = new CRUD('curso');
                  $cursos = $crudCursos->findAll()->executeQuery();

                  while( $curso = $cursos->fetchAll() ): 
                    $selected = ( $h->getFilter('turmas', 'id_curso') == $curso->id )? 'selected="selected"' : '';
                    echo '<option value="'.$curso->id.'" '.$selected.'>'.$curso->sigla.' - '.$curso->nome.'</option>';
                  endwhile;
               ?>
                </select>
          </div>

          <div class="form-group">
                <label for="slug_semestre">Semestre</label>
                <select name="slug_semestre" id="slug_semestre" class="form-control">
                  <option value="">Todos</option>
                  <?php for ($ano=PROJECT_START_YEAR; $ano <= date("Y") ; $ano++): ?>
                    <?php for ($semestre=1; $semestre <= 2; $semestre++): ?>
                      <?php if($ano == date("Y") && $semestre > $h->getSemestreAtual() ): break; endif; ?>
                      <option value="<?php echo $ano .  '/' . $semestre ?>" <?php echo ($h->getFilter('turmas', 'slug_semestre') == $ano . '/' . $semestre)? 'selected="selected"' : '' ?>>
                        <?php echo $ano .  '/' . $semestre ?>
                      </option>                
                    <?php endfor; ?>
                  <?php endfor; ?>
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