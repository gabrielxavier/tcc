<?php $project->partial('admin', 'header'); ?>

<div class="container">
  
    <div class="page-header">
        <h1>Alunos <small>Importar</small> <a href="<?php echo $h->urlFor('admin/alunos'); ?>" class="btn btn-primary pull-right"> <i class="glyphicon glyphicon-list"></i> Lista</a></h1>
    </div>

 
    <form action="<?=$h->urlFor('admin/alunos/importar');?>" enctype="multipart/form-data"  method="post">
        <div class="panel panel-primary">
            <div class="panel-body">

                <div class="form-group">
                    <label for="titulo">Turma</label>
                    <?php $crudTurmas = new CRUD('turma'); ?>
                    <select name="id_turma" class="form-control required">
                        <option value="">Selecione</option>
                    <?php $turmas = $crudTurmas->findAll()->executeQuery(); ?>
                    <?php while( $turma = $crudTurmas->fetchAll() ): ?>
                        <option value="<?=$turma->id?>"> <?=$turma->sigla.' - '.$turma->semestre  ?></option>           
                    <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="arquivo">Arquivo</label>
                    <input type="file" name="arquivo" id="arquivo" class="required">
                    <p class="help-block">Selecione apenas arquivos no formato CSV</p>
                </div>
                
            </div>
            <div class="panel-footer">
              <button type="submit" name="importar" class="btn btn-success"> <i class="glyphicon glyphicon-arrow-up"></i> Importar </button> 
            </div>
        </div>
    </form>   

</div>

<?php 
  
  if( isset($_POST['importar']) )
  {

    $file = $_FILES['arquivo']['tmp_name']; 
    $handle = fopen($file,"r"); 
    
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
    {
        $crudAlunos = new CRUD('usuario');
       
        $aluno = new Usuario();
        $aluno->nome           = utf8_encode($data[0]);
        $aluno->email          = $data[1];
        $aluno->matricula      = $data[2];
        $aluno->id_perfil      = 1;
        $aluno->senha          = 0;

        $id_aluno = $crudAlunos->nextID();

        $crudAlunos->save($aluno)->executeQuery();

        if( $crudAlunos->getExecutedQuery() )
        {   
            $crudTurma = new CRUD('turma_aluno');
            $turmaAluno = new Turmaaluno();
            $turmaAluno->id_aluno = $id_aluno;
            $turmaAluno->id_turma = intval($_POST['id_turma']);
            $crudTurma->save($turmaAluno)->executeQuery();
        }

    }

    fclose($handle);

    $h->addFlashMessage('success', 'Alunos importados com sucesso!');

    $h->redirectFor('admin/alunos');

  }

?>

<?php $project->partial('admin', 'footer'); ?>