<?php  $project->partial('admin', 'header');  ?>
<?php
  $c = new CRUD('inscricao'); $c->findAll();
  $paginationVars = $h->getPaginationVars();
?>

<div class="container">
  
  <div class="page-header">
        <h1>
          Inscrições 
          
          <div class="btn-group pull-right">
            <?php  if( $auth->getSessionInfo('userLevel') == 1 ): ?>
            <a href="<?php echo $h->urlFor('admin/inscricoes/editar'); ?>" class="btn btn-success"> <i class="glyphicon glyphicon-plus"></i> Adicionar</a>
            <?php endif; ?>
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modal-filtro"> <i class="glyphicon glyphicon-search"></i> Filtrar</a>
            <?php if( $h->haveFilters('inscricoes') ): ?>
              <a href="<?php echo $h->urlFor('admin/inscricoes/filtrar'); ?>" class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Limpar filtros</a>
            <?php endif; ?>
          </div>
        </h1>
  </div>


   <?php
      // Controle de usuários 
      if( $auth->getSessionInfo('userLevel') == 1 )
       {
        $c->addWhere(' ( id_aluno1 = "'.$auth->getSessionInfo('userID').'" OR id_aluno2 = "'.$auth->getSessionInfo('userID').'"  )');
      }
      else if( $auth->getSessionInfo('userLevel') == 2 )
      {
        $c->addWhere(' id_orientador = "'.$auth->getSessionInfo('userID').'" ');
      }

      // Filtros
      if( $h->getFilter('inscricoes', 'palavra_chave') )
      {
        $c->addWhere(' (titulo LIKE "%'.$h->getFilter('inscricoes', 'palavra_chave').'%" OR descricao LIKE "%'.$h->getFilter('inscricoes', 'palavra_chave').'%" ) ');
      }

      if( $h->getFilter('inscricoes', 'id_situacao') > 0 )
      {
        $c->addWhere(' id_situacao = "'.$h->getFilter('inscricoes', 'id_situacao').'" ');
      }

      if( $h->getFilter('inscricoes', 'id_turma') > 0 )
      {
        $c->addWhere(' id_turma = "'.$h->getFilter('inscricoes', 'id_turma').'" ');
      }

      if( $h->getFilter('inscricoes', 'slug_semestre') != "" )
      {
       $c->addWhere(' semestre = "'.$h->getFilter('inscricoes', 'slug_semestre').'" ');
      }

      $total = $c->executeQuery()->count();

      $resultados = $c->addLimit( $paginationVars['limit'] )->addOrder(' id DESC ')->executeQuery();

      ?>


  <table class="table table-hover table-striped">
    <tr>
      <th></th>
      <th>Tema</th>
      <th class="hidden-xs">Turma</th>
      <th class="hidden-xs">Semestre</th>
      <th class="hidden-xs">Alunos</th>
      <th class="hidden-xs">Data criação</th>
      <th class="hidden-xs">Data atualização</th>
      <th>&nbsp;</th>
    </tr>

    <?php while( $resultado = $c->fetchAll() ): ?>
    <tr class="<?php echo $h->getSituacaoDecorations($resultado->id_situacao, 'color'); ?>">
      <td>
        <?php 
            $s = new CRUD('situacao');
            $situacao = $s->findOneById($resultado->id_situacao)->executeQuery()->fetchAll();
        ?>
        <i class="glyphicon <?php echo $h->getSituacaoDecorations($resultado->id_situacao, 'icon'); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $situacao->valor; ?>">
      </td>
      <td><?php echo $resultado->titulo ?></td>
      <?php 
        $crudTurma = new CRUD('turma');
        $turma = $crudTurma->findOneById($resultado->id_turma)->executeQuery()->fetchAll();
      ?>
      <td class="hidden-xs"><?php echo $turma->sigla; ?></td>
      <td class="hidden-xs"><?php echo $resultado->semestre ?></td>
      <?php
        $crudAlunos = new CRUD('usuario');
        $aluno1 = $crudAlunos->findOneById($resultado->id_aluno1)->executeQuery()->fetchAll();
        
        if( $resultado->id_aluno2 )
        {
          $aluno2 = $crudAlunos->clearQuery()->findOneById($resultado->id_aluno2)->executeQuery()->fetchAll();
        }
      ?>
      <td class="hidden-xs"><?php echo $aluno1->nome . ' ('.$aluno1->matricula.')' ?> <?php echo ($resultado->id_aluno2)? ' <br /> ' . $aluno2->nome . ' ('.$aluno2->matricula.')' : '' ?></td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->created_at) ?></td>
      <td class="hidden-xs"><?php echo $h->dateTimeFromDB($resultado->updated_at) ?></td>
      <td class="actions">
        <a href="<?php echo $h->urlFor('admin/inscricoes/visualizar/'.$resultado->id); ?>" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Visualizar"> <i class="glyphicon glyphicon-eye-open"></i></a>
        <?php  if( $auth->getSessionInfo('userLevel') == 1 && $resultado->id_aluno1 == $auth->getSessionInfo('userID') ): ?>
          <?php if($resultado->id_situacao == 1 || $resultado->id_situacao == 4): ?>
            <a href="<?php echo $h->urlFor('admin/inscricoes/editar/'.$resultado->id); ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Editar"> <i class="glyphicon glyphicon-edit"></i></a>
          <?php endif; ?>
          <a href="<?php echo $h->urlFor('admin/inscricoes/deletar/'.$resultado->id); ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Remover"> <i class="glyphicon glyphicon-trash"></i></a>
        <?php endif; ?>
      </td>
      
    </tr>

    <?php endwhile; ?>
  
    <tfoot>
      <?php if( $c->count() == 0 ):  ?>
      <tr><td colspan="7" align="center">Nenhum resultado foi encontrado.</td></tr>
      <?php else: ?>
      <tr><td colspan="7" align="center"><?php echo $total ?> resultados encontrados.</td></tr>
      <?php endif; ?>
    </tfoot>

  </table>

  <?php if($auth->getSessionInfo('userLevel') > 1): ?>
    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-relatorio"> <i class="glyphicon glyphicon-print"></i> Imprimir relatório</a>
  <?php endif; ?>

  <?php $h->pagination( $paginationVars['p'],  $total ); ?>

</div>

<!-- Modal -->
<div class="modal fade" id="modal-filtro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo $h->urlFor('admin/inscricoes/filtrar'); ?>" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Filtro</h4>
      </div>
      <div class="modal-body">
         
              <div class="form-group">
                    <label for="palavra_chave">Palavra chave</label>
                    <input type="text" class="form-control" id="palavra_chave" name="palavra_chave" value="<?php echo $h->getFilter('inscricoes', 'palavra_chave') ?>" placeholder="Título/Descrição">
              </div>
              <div class="form-group">
                    <label for="id_situacao">Situação</label>
                    <select name="id_situacao" id="id_situacao" class="form-control">
                      <option value="0">Todas</option>
                    <?php
                      $crudSiuacoes = new CRUD('situacao');
                      $situacoes = $crudSiuacoes->findAll()->executeQuery();

                      while( $situacao = $situacoes->fetchAll() ): 
                        $selected = ( $h->getFilter('inscricoes', 'id_situacao') == $situacao->id )? 'selected="selected"' : '';
                        echo '<option value="'.$situacao->id.'" '.$selected.'>'.$situacao->valor.'</option>';
                      endwhile;
                   ?>
                    </select>
              </div>
              <?php if($auth->getSessionInfo('userLevel') > 1): ?>
              <div class="form-group">
                    <label for="id_turma">Turma</label>
                    <select name="id_turma" id="id_turma" class="form-control">
                     <option value="0">Todas</option>
                    <?php
                      $crudTurmas = new CRUD('turma');
                      $turmas = $crudTurmas->findAll()->executeQuery();

                      while( $turma = $turmas->fetchAll() ): 
                        $selected = ( $h->getFilter('inscricoes', 'id_turma') == $turma->id )? 'selected="selected"' : '';
                        echo '<option value="'.$turma->id.'" '.$selected.'>'.$turma->sigla.' - '.$turma->semestre.'</option>';
                      endwhile;
                   ?>
                    </select>
              </div>
              <?php endif; ?>
              <div class="form-group">
                    <label for="slug_semestre">Semestre</label>
                    <select name="slug_semestre" id="slug_semestre" class="form-control">
                      <option value="">Todos</option>
                      <?php for ($ano=PROJECT_START_YEAR; $ano <= date("Y") ; $ano++): ?>
                        <?php for ($semestre=1; $semestre <= 2; $semestre++): ?>
                          <?php if($ano == date("Y") && $semestre > $h->getSemestreAtual() ): break; endif; ?>
                          <option value="<?php echo $ano .  '/' . $semestre ?>" <?php echo ($h->getFilter('inscricoes', 'slug_semestre') == $ano . '/' . $semestre)? 'selected="selected"' : '' ?>>
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

<!-- Modal -->
<div class="modal fade" id="modal-relatorio" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo $h->urlFor('admin/inscricoes/relatorio'); ?>" method="post" target="_blank">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Imprimir relatório</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label class="block">Modelo de exibição</label>
          <div class="radio-inline">
            <label>
              <input type="radio" value="bloco" name="modelo_exibicao" checked="checked">
              Bloco
            </label>
          </div>
          <div class="radio-inline">
            <label>
              <input type="radio" value="linha" name="modelo_exibicao">
              Lista
            </label>
          </div>
        </div>

        <div class="form-group">
          <label class="block">Modelo de impressão</label>
          <div class="radio-inline">
            <label>
              <input type="radio" value="tela" name="modelo_impressao"  checked="checked">
              Tela
            </label>
          </div>
          <div class="radio-inline">
            <label>
              <input type="radio" value="impressao" name="modelo_impressao">
              Impressão
            </label>
          </div>
          <div class="radio-inline">
            <label>
              <input type="radio" value="csv" name="modelo_impressao">
              CSV
            </label>
          </div>
        </div>

        <div class="form-group">
          <label class="block">Ordenar por</label>
          <div class="radio-inline">
            <label>
              <input type="radio" value="titulo" name="ordem" checked="checked">
              Tema
            </label>
          </div>
          <div class="radio-inline">
            <label>
              <input type="radio" value="id_situacao" name="ordem">
              Situação
            </label>
          </div>
          <div class="radio-inline">
            <label>
              <input type="radio" value="created_at" name="ordem">
              Data de criação
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <label class="block">Campos para impressão</label>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="tema" name="campos[]" checked="checked">
                  Tema
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="descricao" name="campos[]" checked="checked">
                  Descrição
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="situacao" name="campos[]" checked="checked">
                  Situação
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="projeto_referencia" name="campos[]" checked="checked">
                  Projeto referência
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="orientador" name="campos[]" checked="checked">
                  Orientador
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="turma" name="campos[]" checked="checked">
                  Turma
                </label>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
              <div class="checkbox">
                  <label>
                    <input type="checkbox" value="aluno1" name="campos[]" checked="checked">
                    Aluno 1
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="aluno2" name="campos[]" checked="checked">
                    Aluno 2
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="semestre" name="campos[]" checked="checked">
                    Semestre
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="created_at" name="campos[]" checked="checked">
                    Data de criação
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="updated_at" name="campos[]" checked="checked"> 
                    Data de modificação
                  </label>
                </div>
            </div> 
          </div>
        </div>

      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Este processo pode levar alguns minutos">Gerar relatório</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php $project->partial('admin', 'footer'); ?>