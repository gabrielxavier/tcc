<?php $project->partial('admin', 'header'); ?>

<?php $auth->requireLevel(array(3)); ?>

<?php $c = new CRUD('curso'); ?>
<?php $id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL ?>
<?php 
  if($id)
  {
    $registro = $c->findOneById($id)->executeQuery()->fetchAll();
  }else{
    $registro = new Curso();
  }
?>

<div class="container">
  
    <div class="page-header">
        <h1>Cursos <small><?=(!$id)? 'Adicionar' : 'Editar' ?></small> <a href="<?php echo $h->urlFor('admin/cursos'); ?>" class="btn btn-primary pull-right"> <i class="glyphicon glyphicon-list"></i> Lista</a></h1>
    </div>

    <?php $formAction = ($id)? $h->urlFor('admin/cursos/editar/'. $id) : $h->urlFor('admin/cursos/editar'); ?>
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
                    <label for="titulo">Sigla</label>
                    <input type="text" class="form-control required" id="sigla" name="sigla" value="<?=$registro->sigla?>">
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

    $curso = new Curso();
    $curso->id = $_POST['id'];
    $curso->nome = $_POST['nome'];
    $curso->sigla = $_POST['sigla'];

    if( $_POST['id'] == '' )
    {
        $id = $c->nextID();
        $c->save($curso)->executeQuery();

        $h->addFlashMessage('success', 'Curso adicionado com sucesso!');
    }
    else
    {
        $c->clearQuery()->update($curso)->executeQuery();
        $id = $curso->id;

        $h->addFlashMessage('success', 'Curso alterado com sucesso!');
    }

    $h->redirectFor('admin/cursos');

  }

?>
