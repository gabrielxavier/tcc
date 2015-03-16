<?php $project->partial('admin', 'header'); ?>

<?php $c = new CRUD('turma'); ?>
<?php $id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL ?>
<?php 
  if($id)
  {
    $registro = $c->findOneById($id)->executeQuery()->fetchAll();
  }else{
    $registro = new Turma();
  }
?>

<div class="container">
  
    <div class="page-header">
        <h1>Turmas <small><?=(!$id)? 'Adicionar' : 'Editar' ?></small> <a href="<?php echo $h->urlFor('admin/turmas'); ?>" class="btn btn-primary pull-right"> <i class="glyphicon glyphicon-list"></i> Lista</a></h1>
    </div>

    <?php $formAction = ($id)? $h->urlFor('admin/turmas/editar/'. $id) : $h->urlFor('admin/turmas/editar'); ?>
    <form action="<?=$formAction?>" method="POST">
        <input type="hidden" name="id" value="<?=$id?>">
        <div class="panel panel-primary">
            <?php if($id): ?><div class="panel-heading">#<?=$id?></div><?php endif; ?>
            <div class="panel-body">

                <div class="form-group">
                    <label for="titulo">Nome</label>
                    <input type="text" class="form-control required" id="nome" name="nome" value="<?=$registro->nome?>">
                </div>

                <div class="form-group">
                    <label for="sigla">Sigla</label>
                    <input type="text" class="form-control required" id="sigla" name="sigla" value="<?=$registro->sigla?>">
                </div>

                <div class="form-group">
                    <label for="sigla">Semestre</label>
                    <input type="text" class="form-control required" id="semestre" name="semestre" value="<?=$registro->semestre?>">
                </div>

                 <div class="form-group">
                    <label for="id_curso">Curso</label>
                    <select name="id_curso" id="id_curso" class="form-control required">
                     <option value=""></option>
                    <?php
                      $crudCursos = new CRUD('curso');
                      $cursos = $crudCursos->findAll()->executeQuery();

                      while( $curso = $cursos->fetchAll() ): 
                        $selected = ( $registro->id_curso == $curso->id )? 'selected="selected"' : '';
                        echo '<option value="'.$curso->id.'" '.$selected.'>'.$curso->nome.'</option>';
                      endwhile;
                   ?>
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
  
  if( isset($_POST['nome']) )
  {

    $turma = new Turma();
    $turma->id = $_POST['id'];
    $turma->nome = $_POST['nome'];
    $turma->sigla = $_POST['sigla'];
    $turma->semestre = $_POST['semestre'];
    $turma->id_curso = $_POST['id_curso'];

    if( $_POST['id'] == '' )
    {
        $id = $c->nextID();
        $c->save($turma)->executeQuery();

        $h->addFlashMessage('success', 'Turma adicionada com sucesso!');
    }
    else
    {
        $c->clearQuery()->update($turma)->executeQuery();
        $id = $turma->id;

        $h->addFlashMessage('success', 'Turma alterada com sucesso!');
    }

    $h->redirectFor('admin/turmas');

  }

?>
