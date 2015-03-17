<?php $project->partial('admin', 'header'); ?>

<?php $auth->requireLevel(array(3)); ?>

<?php $c = new CRUD('arquivo'); ?>
<?php $id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL ?>
<?php 
  if($id)
  {
    $registro = $c->findOneById($id)->executeQuery()->fetchAll();
  }else{
    $registro = new Arquivo();
  }
?>

<div class="container">
  
    <div class="page-header">
        <h1>Arquivos <small><?=(!$id)? 'Adicionar' : 'Editar' ?></small> <a href="<?php echo $h->urlFor('admin/arquivos'); ?>" class="btn btn-primary pull-right"> <i class="glyphicon glyphicon-list"></i> Lista</a></h1>
    </div>

    <?php $formAction = ($id)? $h->urlFor('admin/arquivos/editar/'. $id) : $h->urlFor('admin/arquivos/editar'); ?>
    <form action="<?=$formAction?>" enctype="multipart/form-data" method="post">
        <input type="hidden" name="id" value="<?=$id?>">
        <div class="panel panel-primary">
            <?php if($id): ?><div class="panel-heading">#<?=$id?></div><?php endif; ?>
            <div class="panel-body">

                <div class="form-group">
                    <label for="titulo">Nome</label>
                    <input type="text" class="form-control required" id="nome" name="nome" value="<?=$registro->nome?>">
                </div>

                <div class="form-group">
                    <label for="caminho">Arquivo</label>
                    <input type="file" class="form-control required" id="caminho" name="caminho">
                    <div class="help-block">Extensões permitidas ( <?php echo implode(", ", unserialize(FILE_FORMATS)) ?> ).</div>
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

    $arquivo = new Arquivo();
    $arquivo->id = $_POST['id'];
    $arquivo->nome = $_POST['nome'];

    $extensao = pathinfo($_FILES['caminho']['name'], PATHINFO_EXTENSION);

    if( !in_array($extensao, unserialize(FILE_FORMATS) ) )
    {
        $h->addFlashMessage('error', 'Formato de arquivo inválido!');
        $h->redirectFor('admin/arquivos/editar');
    }

    $arquivo->caminho = strtolower('arquivos/'.str_replace(" ","-", $arquivo->nome).'-'.date("YmdHis").'.'.$extensao);

    if (move_uploaded_file($_FILES['caminho']['tmp_name'], 'web/admin/uploads/'.$arquivo->caminho)) {

        if( $_POST['id'] == '' )
        {
            $id = $c->nextID();
            $c->save($arquivo)->executeQuery();

            $h->addFlashMessage('success', 'Arquivo adicionado com sucesso!');
        }
        else
        {
            $c->clearQuery()->update($arquivo)->executeQuery();
            $id = $arquivo->id;

            $h->addFlashMessage('success', 'Arquivo alterado com sucesso!');
        }

        $h->redirectFor('admin/arquivos');

    }
    else
    {
        $h->addFlashMessage('error', 'Erro ao adicionar o arquivo!');
        $h->redirectFor('admin/arquivos/editar');
    }

  }

?>
