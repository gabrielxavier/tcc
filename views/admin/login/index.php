<?php  $project->partial('admin', 'header'); ?>

<div class="container">

    <form class="form-signin" method="post" action="<?=$h->urlFor('admin/login/autentica')?>" role="form">
      
      <img src="<?php $h->imagePath('logo.png'); ?>" class="align-center">

      <hr />
      
      <div class="form-group">
  	    <label for="matricula">Matricula</label>
    	  <input type="text" class="form-control required" id="matricula" name="matricula">
     	</div>
      
      <div class="form-group">
        <label for="senha">Senha</label>
        <input type="password" class="form-control required" id="senha" name="senha">
      </div>
      
      <div class="btn-toolbar text-right">
        <button class="btn btn-link" type="button" data-toggle="modal" data-target="#modal-senha">Esqueci a senha</button>
        <button class="btn btn-lg btn-primary" type="submit">Acessar</button>
      </div>

    </form>

  </div>

<!-- Modal -->
<div class="modal fade" id="modal-senha" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <form action="<?php echo $h->urlFor('admin/usuario/recuperarSenha'); ?>" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Esqueci a senha</h4>
      </div>
      <div class="modal-body">
        <p>
          Informe sua matrícula para receber uma nova senha.
        </p>
        <div class="form-group">
              <label for="matricula_recuperar">Matrícula</label>
              <input type="text" class="form-control required" id="matricula_recuperar" name="matricula_recuperar">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">Recuperar senha</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php  $project->partial('admin', 'footer'); ?>