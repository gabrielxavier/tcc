<?php $project->partial('admin', 'header'); ?>

<?php $auth->requireLevel(array(3)); ?>

<div class="container">
  
    <div class="page-header">
        <h1>Alunos <small>Importar</small> <a href="<?php echo $h->urlFor('admin/alunos'); ?>" class="btn btn-primary pull-right"> <i class="glyphicon glyphicon-list"></i> Lista</a></h1>
         <p>Faça download de um arquivo exemplo clicando <a href="<?php echo $h->getWebPath() . 'alunos.csv' ?>" target="_blank">aqui</a>.</p>
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
                    <label for="arquivo">Arquivo </label>
                    <input type="file" name="arquivo" id="arquivo" class="form-control required" data-rule-extension="csv">
                    <span class="help-block">São permitidos somente arquivos no formato CSV.</span>
                </div>
                
            </div>
            <div class="panel-footer">
              <button type="submit" name="importar" class="btn btn-success"> <i class="glyphicon glyphicon-arrow-up"></i> Importar </button> 
            </div>
        </div>
    </form>   

</div>

<?php  if( isset($_POST['importar']) ):    ?>

<div class="modal fade auto" id="modal-importacao" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Detalhes da importação</h4>
        </div>
        <div class="modal-body">
    
        <table class="table table-hover table-striped">
            <tr>
                <th>Matrícula</th>
                <th>Nome</th>
                <th>Email</th>
            </tr>
            <?php

                if( $_FILES['arquivo']['type'] == 'text/csv' )
                {
                    $file = $_FILES['arquivo']['tmp_name']; 
                    $handle = fopen($file,"r"); 
                    $sucesso = 0;
                    $erro = 0;

                    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
                    {
                        $crudAlunos = new CRUD('usuario');

                        $aluno = new Usuario();
                        $aluno->nome                      = utf8_encode($data[0]);
                        $aluno->email                     = $data[1];
                        $aluno->matricula                 = $data[2];
                        $aluno->telefone_residencial      = isset($data[3]) ? $data[3] : '';
                        $aluno->telefone_comercial        = isset($data[4]) ? $data[4] : '';
                        $aluno->telefone_celular          = isset($data[5]) ? $data[5] : '';
                        $aluno->id_perfil      = 1;
                        $aluno->senha          = 0;

                        $id_aluno = $crudAlunos->nextID();

                        $crudAlunos->save($aluno)->executeQuery();

                        ?>

                       <tr data-toggle="tooltip" data-placement="top" title="<?php echo !$crudAlunos->getExecutedQuery() ? $crudAlunos->getError() : '' ?>" class="<?php echo ( $crudAlunos->getExecutedQuery() )? 'success' : 'danger' ?>">
                            <td><?php echo $aluno->matricula ?></td>
                            <td><?php echo $aluno->nome ?></td>
                            <td><?php echo $aluno->email ?></td>
                        </tr>

                        <?php

                        if( $crudAlunos->getExecutedQuery() )
                        {   
                            $crudTurma = new CRUD('turma_aluno');
                            $turmaAluno = new Turmaaluno();
                            $turmaAluno->id_aluno = $id_aluno;
                            $turmaAluno->id_turma = intval($_POST['id_turma']);
                            $crudTurma->save($turmaAluno)->executeQuery();

                            $sucesso++;
                        }else{
                            $erro++;
                        }

                    }

                    fclose($handle);
                }
                else
                {
                    $h->addFlashMessage('error', 'Erro ao importar os dados, formato de arquivo inválido!');
                    $h->redirectFor('admin/alunos/importar');
                }
            ?>
            
        </table>
        <table class="table">
            <tr>
                <th colspan="2">Resumo</th>
                <td class="success"><i class="glyphicon glyphicon-ok" data-toggle="tooltip" data-placement="top" title="Sucesso"> <?php echo $sucesso ?></td>
                <td class="danger"><i class="glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="top" title="Erro"></i> <?php echo $erro ?></td>
                <td class="info"><i class="glyphicon glyphicon-glass" data-toggle="tooltip" data-placement="top" title="Total"></i> <?php echo ($sucesso + $erro) ?></td>
            </tr>
        </table>
       
        </div>
        <div class="modal-footer">
            <a href="<?=$h->urlFor('admin/alunos');?>" class="btn btn-primary">Listar alunos</a>
            <a href="<?=$h->urlFor('admin/alunos/importar');?>" class="btn btn-success">Importar novamente</a>
      </div>
    </div>
  </div>
</div>

<?php endif; ?>


<?php $project->partial('admin', 'footer'); ?>