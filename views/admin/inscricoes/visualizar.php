<?php $project->partial('admin', 'header'); ?>

<?php $c = new CRUD('inscricao'); ?>
<?php $id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL ?>
<?php $id_aluno = $auth->getSessionInfo()['userID'] ?> 
<?php 
  if($id)
  {
    $registro = $c->findOneById($id)->executeQuery()->fetchAll();
    if(!$registro)
         $h->redirectFor('admin/inscricoes');
  }else{
    $h->redirectFor('admin/inscricoes');
  }
?>

<div class="container">
  
    <div class="page-header">
        <h1>
            Inscrições <small>Visualizar</small>
            <div class="btn-group pull-right">
                <?php if( $auth->getSessionInfo()['userLevel'] == 1 && $registro->id_aluno1 == $auth->getSessionInfo()['userID']): ?>
                <a href="<?php echo $h->urlFor('admin/inscricoes/editar/'.$registro->id); ?>" class="btn btn-warning">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <?php endif; ?>
                <a href="<?php echo $h->urlFor('admin/inscricoes'); ?>" class="btn btn-primary">
                    <i class="glyphicon glyphicon-list"></i> Lista
                </a>
            </div>
        </h1>
    </div>

    <table class="table table-hover">
        <tr>
            <th width="180">
                Título
            </th>
            <td>
                <?php echo $registro->titulo ?>
            </td>
        </tr>
        <tr>
            <th>
                Descrição
            </th>
            <td>
                <?php echo nl2br(strip_tags($registro->descricao)) ?>
            </td>
        </tr>
        <tr>
            <th>
                Projeto de referência
            </th>
            <td>    
                <?php 
                    $p = new CRUD('projeto');
                    $projeto = $p->findOneById($registro->id_projeto)->executeQuery()->fetchAll();
                ?>
                <?php echo $projeto->titulo; ?>
            </td>
        </tr>
        <tr>
            <th>
                Orientador
            </th>
            <td>    
                <?php 
                    $o = new CRUD('usuario');
                    $orientador = $o->findOneById($registro->id_orientador)->executeQuery()->fetchAll();
                ?>
                <?php echo $orientador->nome; ?>
            </td>
        </tr>
        <tr>
            <th>
                Aluno 1
            </th>
            <td>    
                <?php 
                    $a = new CRUD('usuario');
                    $aluno1 = $a->findOneById($registro->id_aluno1)->executeQuery()->fetchAll();
                ?>
                <?php echo $aluno1->nome; ?> ( <?php echo $aluno1->matricula; ?> )
            </td>
        </tr>
         <?php if($registro->id_aluno2): ?>
        <tr>
            <th>
                Aluno 2
            </th>
            <td>    
                <?php
                        $aluno2 = $a->clearQuery()->findOneById($registro->id_aluno2)->executeQuery()->fetchAll();
                        echo $aluno2->nome . " ( " . $aluno2->matricula . " ) ";
                    
                ?>
            </td>
        </tr>
        <?php endif ?>
        <tr>
            <th>
                Turma
            </th>
            <td>    
                <?php 
                    $t = new CRUD('turma');
                    $turma = $t->findOneById($registro->id_turma)->executeQuery()->fetchAll();
                ?>
                <?php echo $turma->nome; ?>
            </td>
        </tr>
        <tr>
            <th>
                Criado em
            </th>
            <td>
                <?php echo $h->dateTimeFromDB($registro->created_at) ?>
            </td>
        </tr>
        <tr>
            <th>
                Modificado em
            </th>
            <td>
               <?php echo $h->dateTimeFromDB($registro->updated_at) ?>
            </td>
        </tr>
        <tr>
            <th>
                Situação
            </th>
            <td>
                <?php 
                    $s = new CRUD('situacao');
                    $situacao = $s->findOneById($registro->id_situacao)->executeQuery()->fetchAll();
                ?>
                <?php echo $situacao->valor;?>

            </td>
        </tr>
    </table>
        <div class="btn-toolbar">
            <a href="<?php echo $h->urlFor('admin/inscricoes/imprimir/'.$registro->id); ?>" class="btn btn-primary"> <i class="glyphicon glyphicon-print"></i> Imprimir inscrição</a>
        
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modal-historico">
                <i class="glyphicon glyphicon-calendar"></i> Visualizar histórico de interações
            </a>
            <?php if($situacao->id != 2 && $situacao->id != 3 && $auth->getSessionInfo()['userLevel'] == 1 && $registro->id_aluno1 == $auth->getSessionInfo()['userID']): ?>
                <a href="#" class="btn btn-success inscricao-action" data-situacao-id="2" data-situacao-nome="enviar para aprovação" data-toggle="modal" data-target="#modal-inscricao">
                    <i class="glyphicon glyphicon-send"></i> Enviar para aprovação
                </a>
            <?php endif; ?>
        </div>
        <?php  if( $auth->getSessionInfo()['userLevel'] == 2 && $situacao->id == 2 ): ?>
            <div class="btn-group pull-right">
                <a href="#" class="btn btn-danger inscricao-action" data-situacao-id="4" data-situacao-nome="reprovar" data-toggle="modal" data-target="#modal-inscricao">
                    <i class="glyphicon glyphicon-remove"></i> Reprovar
                </a>
                <a href="#" class="btn btn-success inscricao-action" data-situacao-id="3" data-situacao-nome="aprovar" data-toggle="modal" data-target="#modal-inscricao">
                    <i class="glyphicon glyphicon-ok"></i> Aprovar
                </a>
            </div>
        <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-inscricao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form action="<?php echo $h->urlFor('admin/inscricoes/mudarSituacao/'.$registro->id); ?>" method="post">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirme a ação</h4>
      </div>
      <div class="modal-body">
        <p>Deseja mesmo <strong id="inscricao-situacao-nome"></strong> a inscrição?</p>
        <div class="form-group">
            <label for="comentario">Comentário</label>
            <textarea name="comentario" id="comentario" class="form-control" rows="5"></textarea>
        </div>
      </div>
      <div class="modal-footer">
            <input type="hidden" name="id_situacao" id="id_situacao" value="" />
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Confirmar</button>
      </div>
    </div>
  </div>
  </form>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-historico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Histórico de interações</h4>
      </div>
      <div class="modal-body">
            <?php
            $crudSituacoes = new CRUD('situacao');
            $crudSituacoes->setQuery(
                'SELECT s.id, s.valor,u.nome as nome_autor, i_s.comentario,  i_s.created_at as data_interacao FROM situacao s
                INNER JOIN inscricao_situacao i_s  
                INNER JOIN usuario u 
                WHERE s.id = i_s.id_situacao AND i_s.id_inscricao = "'.$registro->id.'" AND i_s.id_autor = u.id
                ORDER BY i_s.id DESC'
            )->executeQuery(); ?>
            <table class="table table-hover table-striped">
                <tr>
                    <th></th>
                    <th>Data da interação</th>
                    <th>Autor</th>
                    <th>Comentário</th>
                </tr> 
                <?php 
                    $situacao_decorations = array(
                        1 => array('icon'=> 'glyphicon-asterisk', 'color'=>''),
                        2 => array('icon'=> 'glyphicon-time', 'color'=>'info'),
                        3 => array('icon'=> 'glyphicon-ok', 'color'=>'success'),
                        4 => array('icon'=> 'glyphicon-remove', 'color'=>'danger')
                    );
                ?>
                <?php while( $situacao = $crudSituacoes->fetchAll() ): ?>
                    <tr>
                        <td> <i class="glyphicon <?php echo $situacao_decorations[$situacao->id]['icon'] ?>" title="<?php echo $situacao->valor ?>"></i> </td>
                        <td nowrap><?php echo $h->dateTimeFromDB($situacao->data_interacao) ?></td>
                        <td nowrap><?php echo $situacao->nome_autor ?></td>
                        <td><?php echo nl2br($situacao->comentario) ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<?php $project->partial('admin', 'footer'); ?>