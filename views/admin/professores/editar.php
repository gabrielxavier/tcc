<?php $project->partial('admin', 'header'); ?>

<?php $auth->requireLevel(array(3)); ?>

<?php $c = new CRUD('usuario'); ?>
<?php $id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL ?>
<?php 
  if($id)
  {
    $registro = $c->findOneById($id)->executeQuery()->fetchAll();
  }else{
    $registro = new Usuario();
  }
?>

<div class="container">
  
    <div class="page-header">
        <h1>Professores <small><?=(!$id)? 'Adicionar' : 'Editar' ?></small> <a href="<?php echo $h->urlFor('admin/professores'); ?>" class="btn btn-primary pull-right"> <i class="glyphicon glyphicon-list"></i> Lista</a></h1>
    </div>

    <?php $formAction = ($id)? $h->urlFor('admin/professores/editar/'. $id) : $h->urlFor('admin/professores/editar'); ?>
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
                    <label for="email">Email</label>
                    <input type="text" class="form-control required email" id="email" name="email" value="<?=$registro->email?>">
                </div>

                <div class="form-group">
                    <label for="matricula">Matrícula</label>
                    <input type="text" class="form-control required" id="matricula" name="matricula" value="<?=$registro->matricula?>">
                </div>

                <div class="form-group">
                    <label for="titulo">Perfil</label>
                    <select name="id_perfil" class="form-control required">
                        <option value="">Selecione</option>
                        <option value="2" <?php echo ($registro->id_perfil == 2)? 'selected="selected"' :  '' ?>>Professor Orientador</option>
                        <option value="3" <?php echo ($registro->id_perfil == 3)? 'selected="selected"' :  '' ?>>Professor TCC</option>
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

    $professor = new Usuario();
    $professor->id = $_POST['id'];
    $professor->nome = $_POST['nome'];
    $professor->email = $_POST['email'];
    $professor->matricula = $_POST['matricula'];
    $professor->id_perfil = $_POST['id_perfil'];
    $professor->senha = ($_POST['id'])? false : 'false';

    if( $_POST['id'] == '' )
    {
        $id = $c->nextID();
        $c->save($professor)->executeQuery();

        $h->addFlashMessage('success', 'Professor adicionado com sucesso!');
    }
    else
    {
        $c->clearQuery()->update($professor)->executeQuery();
        $id = $professor->id;

        $h->addFlashMessage('success', 'Professor alterado com sucesso!');
    }

    $h->redirectFor('admin/professores');

  }

?>
