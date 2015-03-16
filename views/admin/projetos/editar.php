<?php $project->partial('admin', 'header'); ?>

<?php $auth->requireLevel(array(3)); ?>

<?php $c = new CRUD('projeto'); ?>
<?php $id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL ?>
<?php 
  if($id)
  {
    $registro = $c->findOneById($id)->executeQuery()->fetchAll();
  }else{
    $registro = new Projeto();
  }
?>

<div class="container">
  
    <div class="page-header">
        <h1>Projetos <small><?=(!$id)? 'Adicionar' : 'Editar' ?></small> <a href="<?php echo $h->urlFor('admin/projetos'); ?>" class="btn btn-primary pull-right"> <i class="glyphicon glyphicon-list"></i> Lista</a></h1>
    </div>

    <?php $formAction = ($id)? $h->urlFor('admin/projetos/editar/'. $id) : $h->urlFor('admin/projetos/editar'); ?>
    <form action="<?=$formAction?>" method="POST">
        <input type="hidden" name="id" value="<?=$id?>">
        <div class="panel panel-primary">
            <?php if($id): ?><div class="panel-heading">#<?=$id?></div><?php endif; ?>
            <div class="panel-body">

                <div class="form-group">
                    <label for="titulo">Titulo</label>
                    <input type="text" class="form-control required" id="titulo" name="titulo" value="<?=$registro->titulo?>">
                </div>
                <div class="form-group">
                    <label for="descricao">Descricao</label>
                    <textarea name="descricao" id="descricao" cols="30" rows="10" class="form-control required"><?=$registro->descricao?></textarea>
                </div>
                <div class="form-group">
                    <label for="tags">Tags (Pressione tab para adicionar)</label>
                    <input id="tags" name="tags" type="text" class="tags" value="<?=$registro->tags?>" /></p>
               </div>

                <div class="form-group">
                    <label for="ativo">Cursos</label>
                    <a href="#" class="btn btn-success pull-right btn-new-curso"> <i class="glyphicon glyphicon-plus"></i> Novo curso</a>
                </div>
                
                <?php
                    $crudCursos = new CRUD('curso');
                  
                    if($id){
                       
                        $crudCursosCadastrados = new CRUD('projeto_curso');
                        $cursosCadastrados = $crudCursosCadastrados->findAll(' id_projeto = "'. $id. '" ')->executeQuery();
                      
                        while( $cursoCadastrado = $crudCursosCadastrados->fetchAll() )
                        { 
                            $cursoID = $cursoCadastrado->id_curso; 
                            $cursos = $crudCursos->findAll()->executeQuery(); 
                        ?>
                            
                            <div class="form-group field-curso">
                                <div class="input-group">
                                    <select name="cursos[]" class="form-control">
                                        <option value="">Selecione</option>
                                    <?php while( $curso = $crudCursos->fetchAll() ): ?>
                                        <option value="<?=$curso->id?>" <?=($cursoID == $curso->id)?'selected="selected"':''?>>
                                            <?=$curso->sigla.' - '.$curso->nome?>
                                        </option>           
                                    <?php endwhile; ?>
                                    </select>
                                     <div class="input-group-btn">
                                        <a href="#" class="btn btn-danger pull-right btn-delete-curso"> <i class="glyphicon glyphicon-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                                
                        <?php } ?>
    
                <?php   }   ?>

                <div class="form-group field-curso">
                    <div class="input-group">
                        <select name="cursos[]" class="form-control">
                            <option value="">Selecione</option>
                        <?php $cursos = $crudCursos->findAll()->executeQuery(); ?>
                        <?php while( $curso = $crudCursos->fetchAll() ): ?>
                            <option value="<?=$curso->id?>"><?=$curso->sigla.' - '.$curso->nome?></option>           
                        <?php endwhile; ?>
                        </select>
                         <div class="input-group-btn">
                            <a href="#" class="btn btn-danger pull-right btn-delete-curso"> <i class="glyphicon glyphicon-trash"></i></a>
                        </div>
                    </div>
                </div>
                    
                <div class="form-group">
                    <label for="ativo">Professores</label> <a href="#" class="btn btn-success pull-right btn-new-professor"> <i class="glyphicon glyphicon-plus"></i> Novo professor</a>
                </div>

                <?php
                    $crudProfessor = new CRUD('usuario');

                    if($id){
                       
                        $crudProfessoresCadastrados = new CRUD('projeto_professor');
                        $professoresCadastrados = $crudProfessoresCadastrados->findAll(' id_projeto = "'. $id. '" ')->executeQuery();
                      
                        while( $professorCadastrado = $crudProfessoresCadastrados->fetchAll() )
                        { 
                            $professorID = $professorCadastrado->id_professor; 
                            $professores = $crudProfessor->findAll('id_perfil = "2"')->executeQuery(); 
                        ?>
                            
                            <div class="form-group field-professor">
                                <div class="input-group">
                                    <select name="professores[]" class="form-control">
                                        <option value="">Selecione</option>
                                    <?php while( $professor = $crudProfessor->fetchAll() ): ?>
                                        <option value="<?=$professor->id?>" <?=($professorID == $professor->id)?'selected="selected"':''?>>
                                            <?=$professor->nome.' - '.$professor->matricula?>
                                        </option>           
                                    <?php endwhile; ?>
                                    </select>
                                     <div class="input-group-btn">
                                        <a href="#" class="btn btn-danger pull-right btn-delete-professor"> <i class="glyphicon glyphicon-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                                
                        <?php } ?>
    
                <?php   }   ?>

                <div class="form-group field-professor">
                    <div class="input-group">
                        <select name="professores[]" class="form-control">
                            <option value="">Selecione</option>
                        <?php $professores = $crudProfessor->findAll('id_perfil = "2"')->executeQuery(); ?>
                        <?php while( $professor = $crudProfessor->fetchAll() ): ?>
                            <option value="<?=$professor->id?>"><?=$professor->nome.' - '.$professor->matricula?></option>           
                        <?php endwhile; ?>
                        </select>
                         <div class="input-group-btn">
                            <a href="#" class="btn btn-danger pull-right btn-delete-professor"> <i class="glyphicon glyphicon-trash"></i></a>
                        </div>
                    </div>
                </div>

                 <div class="form-group">
                    <label for="ativo">Ativo</label>
                    <select name="ativo" id="ativo" class="form-control">
                        <option value="1" <?=($registro->ativo)? 'selected="selected"' : ''; ?>>Sim</option>           
                        <option value="0" <?=(!$registro->ativo)? 'selected="selected"' : ''; ?>>Não</option>            
                    </select>
                </div>

            </div>
            <div class="panel-footer">
              <button type="submit" class="btn btn-success"> <i class="glyphicon glyphicon-floppy-disk"></i> Salvar </button> 
            </div>
        </div>
    </form>   

</div>

<?php $project->partial('admin', 'footer'); ?>


<?php 
  
  if( isset($_POST['titulo']) )
  {

    $projeto = new Projeto();
    $projeto->id = $_POST['id'];
    $projeto->titulo = $_POST['titulo'];
    $projeto->descricao = $_POST['descricao'];
    $projeto->tags = $_POST['tags'];
    $projeto->ativo = $_POST['ativo'];

    if( $_POST['id'] == '' )
    {
        $id = $c->nextID();
        $c->save($projeto)->executeQuery();

        $h->addFlashMessage('success', 'Projeto adicionado com sucesso!');
    }
    else
    {
        $c->clearQuery()->update($projeto)->executeQuery();
        $id = $projeto->id;

        $h->addFlashMessage('success', 'Projeto alterado com sucesso!');
    }

    if( $c->getExecutedQuery() )
    {
        $crudCurso = new CRUD('projeto_curso');
        $crudCurso->delete('id_projeto = "'. $id .'"')->executeQuery();
        foreach ($_POST['cursos'] as $key => $value) {
            if( intval($value) > 0 )
            {
                $projetoCurso = new Projetocurso();
                $projetoCurso->id_projeto = $id;
                $projetoCurso->id_curso = $value;
                $crudCurso->save($projetoCurso)->executeQuery();
            }
        }

        $crudProfessor = new CRUD('projeto_professor');
        $crudProfessor->delete('id_projeto = "'. $id .'"')->executeQuery();
        foreach ($_POST['professores'] as $key => $value) {
            if( intval($value) > 0 )
            {
                $projetoProfessor = new Projetoprofessor();
                $projetoProfessor->id_projeto = $id;
                $projetoProfessor->id_professor = $value;
                $crudProfessor->save($projetoProfessor)->executeQuery();
            }
        }
    }

    $h->redirectFor('admin/projetos');

  }

?>
