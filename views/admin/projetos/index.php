<?php $project->partial('admin', 'header'); ?>

<?php $c = new CRUD('projeto'); ?>
<?php $paginationVars = $h->getPaginationVars();  ?>

<div class="container">
  
  <div class="page-header">
        <h1>
          Projetos 

          <div class="btn-group pull-right">
            <?php if( $auth->getSessionInfo('userLevel') == 3): ?>
              <a href="<?php echo $h->urlFor('admin/projetos/editar'); ?>" class="btn btn-success"> <i class="glyphicon glyphicon-plus"></i> Novo</a>
            <?php endif; ?>
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modal-filtro"> <i class="glyphicon glyphicon-search"></i> Filtrar</a>
            <?php if( $h->haveFilters('projetos') ): ?>
              <a href="<?php echo $h->urlFor('admin/projetos/filtrar'); ?>" class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Limpar filtros</a>
            <?php endif; ?>
          </div>
        </h1>
  </div>

  <table class="table table-hover table-striped">
    <tr>
      <th>Título</th>
      <th class="hidden-xs">Tags</th>
      <th class="hidden-xs">Data criação</th>
      <th class="hidden-xs">Data atualização</th>
      <th>&nbsp;</th>
    </tr>

    <?php
       $c->findAll(' 1 = 1 ', 'projeto.*');

       // Controle de usuários 
      if( $auth->getSessionInfo('userLevel') == 1 )
       {
        $c->addJoin('projeto_curso pc');
        $c->addJoin('turma t');
        $c->addJoin('turma_aluno ta');
        $c->addWhere('projeto.id = pc.id_projeto');
        $c->addWhere('t.id_curso = pc.id_curso');
        $c->addWhere('t.id = ta.id_turma');
        $c->addWhere('ta.id_aluno = "'.$auth->getSessionInfo('userID').'"');
        
        $c->addWhere(' projeto.ativo = "1" ');
      }
      else if( $auth->getSessionInfo('userLevel') == 2 )
      {
        $c->addJoin('projeto_professor pf');
        $c->addWhere('pf.id_projeto = projeto.id');
        $c->addWhere('pf.id_professor = "'.$auth->getSessionInfo('userID').'"');

        $c->addWhere(' projeto.ativo = "1" ');
      }

      // Filtros
      if( $h->getFilter('projetos', 'palavra_chave') )
      {
        $c->addWhere(' (titulo LIKE "%'.$h->getFilter('projetos', 'palavra_chave').'%" OR descricao LIKE "%'.$h->getFilter('projetos', 'palavra_chave').'%" OR tags LIKE "%'.$h->getFilter('projetos', 'palavra_chave').'%" ) ');
      }

      // Filtros
      if( $h->getFilter('projetos', 'id_curso') )
      {
        $c->addJoin('projeto_curso');
        $c->addWhere(' projeto_curso.id_curso = "'.$h->getFilter('projetos', 'id_curso').'" ');
        $c->addWhere(' projeto_curso.id_projeto = projeto.id ');
      }
       
       $total = $c->executeQuery()->count();

       $resultados = $c->addLimit( $paginationVars['limit'] )->executeQuery();

      ?>

    <?php while( $resultado = $c->fetchAll() ): ?>
    
    <tr>
      <td><?php echo $resultado->titulo ?></td>
      <td>
          <?php 
            $tags = explode( ',', $resultado->tags); 
             foreach ($tags as $tag) {
                echo '<span class="label label-success">'.$tag.'</span> ';
              }
          ?>
      </td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->created_at) ?></td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->updated_at) ?></td>
      <td class="actions">
        <a href="<?php echo $h->urlFor('admin/projetos/visualizar/'.$resultado->id); ?>" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Visualizar"> <i class="glyphicon glyphicon-eye-open"></i></a>
        <?php if( $auth->getSessionInfo('userLevel') == 3): ?>
          <a href="<?php echo $h->urlFor('admin/projetos/editar/'.$resultado->id); ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="glyphicon glyphicon-edit"></i></a>
          <a href="<?php echo $h->urlFor('admin/projetos/deletar/'.$resultado->id); ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Remover"> <i class="glyphicon glyphicon-trash" ></i></a>
        <?php endif; ?>
      </td>
    </tr>

    <?php endwhile; ?>

    <tfoot>
      <?php if( $c->count() == 0 ):  ?>
      <tr><td colspan="7" align="center">Nenhum resultado foi encontrado.</td></tr>
      <?php else: ?>
      <tr><td colspan="7" align="center"><?php echo $c->count() ?> resultados encontrados.</td></tr>
      <?php endif; ?>
    </tfoot>
    
  </table>

  <?php $h->pagination( $paginationVars['p'],  $total ); ?>

</div>


<!-- Modal -->
<div class="modal fade" id="modal-filtro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo $h->urlFor('admin/projetos/filtrar'); ?>" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Filtro</h4>
      </div>
      <div class="modal-body">
            <div class="form-group">
                  <label for="palavra_chave">Palavra chave</label>
                  <input type="text" class="form-control" id="palavra_chave" name="palavra_chave" value="<?php echo $h->getFilter('projetos', 'palavra_chave') ?>" placeholder="Título/Descrição/Tags">
            </div>

            <?php if($auth->getSessionInfo('userLevel') > 1): ?>
              <div class="form-group">
                    <label for="id_curso">Curso</label>
                    <select name="id_curso" id="id_curso" class="form-control">
                     <option value="0">Todas</option>
                    <?php
                      $crudCursos = new CRUD('curso');
                      $cursos = $crudCursos->findAll()->executeQuery();

                      while( $curso = $cursos->fetchAll() ): 
                        $selected = ( $h->getFilter('projetos', 'id_curso') == $curso->id )? 'selected="selected"' : '';
                        echo '<option value="'.$curso->id.'" '.$selected.'>'.$curso->sigla.' - '.$curso->nome.'</option>';
                      endwhile;
                   ?>
                    </select>
              </div>
            <?php endif; ?>
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