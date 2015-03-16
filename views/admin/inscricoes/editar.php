<?php $project->partial('admin', 'header'); ?>

<?php $auth->requireLevel(array(1)); ?>

<?php 
    $c = new CRUD('inscricao');
    $id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL;
    $id_aluno = $auth->getSessionInfo('userID');

  if($id)
  {
    $registro = $c->findOneById($id)->executeQuery()->fetchAll();
    if(!$registro)
         $h->redirectFor('admin/inscricoes');
  }else{
    $registro = new Inscricao();
  }
?>

<div class="container">
  
    <div class="page-header">
        <h1>
            Inscrições <small><?=(!$id)? 'Adicionar' : 'Editar' ?></small> 

            <div class="btn-group pull-right">
                <?php if($id): ?>
                    <a href="<?php echo $h->urlFor('admin/inscricoes/visualizar/'.$id); ?>" class="btn btn-info">
                        <i class="glyphicon glyphicon-eye-open"></i> Visualizar
                    </a>
                <?php endif; ?>
                <a href="<?php echo $h->urlFor('admin/inscricoes'); ?>" class="btn btn-primary">
                    <i class="glyphicon glyphicon-list"></i> Lista
                </a>
            </div>
        </h1>
    </div>

    <?php $formAction = ($id)? $h->urlFor('admin/inscricoes/editar/'. $id) : $h->urlFor('admin/inscricoes/editar'); ?>
    <form action="<?=$formAction?>" method="POST">
        <input type="hidden" name="id" value="<?=$id?>">
        <input type="hidden" name="id_situacao" value="<?php echo ($id)? $registro->id_situacao : '1' ; ?>">
        <input type="hidden" name="semestre" value="<?php echo ($id)? $registro->semestre : date("Y") . '/' .$h->getSemestreAtual(); ?>">
        <div class="panel panel-primary">
            <?php if($id): ?><div class="panel-heading">#<?=$id?></div><?php endif; ?>
            <div class="panel-body">

                <div class="form-group">
                    <label for="titulo">Tema</label>
                    <input type="text" class="form-control required" id="titulo" name="titulo" value="<?=$registro->titulo?>">
                </div>
                <div class="form-group">
                    <label for="descricao">Descricao</label>
                    <textarea name="descricao" id="descricao" cols="30" rows="10" class="form-control required"><?=$registro->descricao?></textarea>
                </div>
                
                <?php 
                    $crudAlunos = new CRUD('usuario');
              
                    if( $registro->id_aluno2 )
                    {
                        $aluno2 = $crudAlunos->findOneById($registro->id_aluno2)->executeQuery()->fetchAll();
                    }else
                    {
                        $aluno2 = new Usuario();
                    }
                ?>
                <div class="row">
                    <input type="hidden" name="id_aluno1" class="aluno-id" value="<?=$auth->getSessionInfo('userID') ?>">
                   
                    <div class="col-lg-6 aluno-wrapper">
                       <div class="form-group">
                            <label for="descricao">Aluno 2</label>
                            <div class="input-group">
                              <input type="text" id="aluno2" placeholder="Matrícula" value="<?=$aluno2->matricula?>" class="form-control aluno-matricula">
                              <span class="input-group-btn">
                                <button class="btn btn-default btn-find-aluno" type="button"><i class="glyphicon glyphicon-search"></i></button>
                                <button class="btn btn-danger btn-remove-aluno" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                              </span>
                            </div>
                        </div>
                         <div class="form-group">
                            <input type="text" id="nome_aluno2" value="<?=$aluno2->nome?>" class="form-control aluno-nome" disabled="disabled">
                            <input type="hidden" name="id_aluno2" class="aluno-id" value="<?=$registro->id_aluno2?>">
                        </div>
                    </div>
                </div>
               

                <div class="form-group">
                    <label for="turma">Turma</label>
                    <?php $t = new CRUD('turma'); ?>                  
                    <select name="id_turma" id="id_turma" class="form-control required">
                        <option value="">Selecione</option>
                    <?php $turmas = $t->findAll(' id IN ( SELECT id_turma FROM turma_aluno WHERE id_aluno = "'.$id_aluno.'" ) ')->executeQuery(); ?>
                    <?php while( $turma = $t->fetchAll() ): ?>
                        <option value="<?=$turma->id?>" <?=($turma->id == $registro->id_turma)?  'selected="selected"' : '' ?>>
                            <?=$turma->sigla.' - '.$turma->nome?>
                        </option>           
                    <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ativo">Projeto referência</label>
                    <select name="id_projeto" id="id_projeto" class="form-control <?=($registro->id_turma<1)? 'disabled':''?> required">
                        <option value="">Selecione a turma</option>
                        <?php 
                                if( $registro->id_turma )
                                {
                                    $crudProjetos = new CRUD('projeto');
                                    $crudProjetos->setQuery("SELECT p.* FROM projeto p INNER JOIN projeto_curso pc, turma t WHERE p.id = pc.id_projeto and pc.id_curso = t.id_curso and t.id = '".$registro->id_turma."' and p.ativo = '1'")->executeQuery();

                                    while( $projeto =  $crudProjetos->fetchAll() ): ?>
                                        <option value="<?=$projeto->id?>" <?=($projeto->id == $registro->id_projeto)? 'selected="selected"':''?>>
                                            <?=$projeto->titulo?>
                                        </option>
                        <?php 
                                    endwhile;
                                }
                        ?>
                    </select>
                </div>

                 <div class="form-group">
                    <label for="ativo">Orientador</label>
                    <select name="id_orientador" id="id_orientador" class="form-control required">
                        <option value="">Selecione o projeto</option>
                         <?php 
                                if( $registro->id_projeto )
                                {
                                    $crudProfessores = new CRUD('usuario');
                                    $crudProfessores->findAll('id IN ( SELECT id_professor FROM projeto_professor WHERE id_projeto = "'.$registro->id_projeto.'" )', ' id, nome ')->executeQuery();

                                    while( $professor =  $crudProfessores->fetchAll() ): ?>
                                        <option value="<?=$professor->id?>" <?=($professor->id == $registro->id_orientador)? 'selected="selected"':''?>>
                                            <?=$professor->nome?>
                                        </option>
                        <?php 
                                    endwhile;
                                }
                        ?>
                    </select>
                </div>

            </div>
            <div class="panel-footer">
              <button type="submit" class="btn btn-success" name="salvar"> <i class="glyphicon glyphicon-floppy-disk"></i> Salvar </button> 
              <button type="submit" class="btn btn-primary" name="salvar_enviar"> <i class="glyphicon glyphicon-floppy-open"></i> Salvar e enviar para aprovação </button> 
            </div>
        </div>
    </form>   

</div>

<?php $project->partial('admin', 'footer'); ?>


<?php 
  
  if( isset($_POST['titulo']) )
  {

    $inscricao = new Inscricao();
    $inscricao->id = $_POST['id'];
    $inscricao->titulo = $_POST['titulo'];
    $inscricao->descricao = $_POST['descricao'];
    $inscricao->id_orientador = $_POST['id_orientador'];
    $inscricao->id_turma = $_POST['id_turma'];
    $inscricao->id_projeto = $_POST['id_projeto'];
    $inscricao->id_aluno1 = $_POST['id_aluno1'];
    $inscricao->id_aluno2 = ($_POST['id_aluno2'])? $_POST['id_aluno2'] : '0';
    $inscricao->id_situacao = isset($_POST['salvar_enviar']) ? 2 : $_POST['id_situacao'];


    if( $_POST['id'] == '' )
    {
        $id = $c->nextID();

        $crudSituacao = new CRUD('inscricao_situacao'); 
        $situacao = new Inscricaosituacao();
        $situacao->id_situacao = 1;
        $situacao->id_inscricao = $id;
        $situacao->id_autor = $auth->getSessionInfo('userID');
        $situacao->comentario = 'Inscrição criada com sucesso.';
        
        $crudSituacao->save($situacao)->executeQuery();
        $c->save($inscricao)->executeQuery();

        $h->addFlashMessage('success', 'Inscrição salva com sucesso!');
    }
    else
    {
        $c->update($inscricao)->executeQuery();
        $id = $inscricao->id;

        $h->addFlashMessage('success', 'Inscrição alterada com sucesso!');
    }

    if( isset($_POST['salvar_enviar']) ) 
    {
        $c = new CRUD('inscricao_situacao'); 
        $situacao = new Inscricaosituacao();
        $situacao->id_situacao = 2;
        $situacao->id_inscricao = $id;
        $situacao->id_autor = $auth->getSessionInfo('userID');
        $situacao->comentario = "Inscrição enviada para aprovação com sucesso.";

        $c->save($situacao)->executeQuery();
    }

   $h->redirectFor('admin/inscricoes');

  }

?>
