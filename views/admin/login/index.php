<?php  $project->partial('admin', 'header'); ?>

<div class="container">



      <form class="form-signin" method="post" action="<?=$h->urlFor('admin/login/autentica')?>" role="form">
        <img src="<?php $h->imagePath('logo.png'); ?>" class="align-center">
        
        <h2 class="form-signin-heading">Área Restrita</h2>
        
        <div class="form-group">
	    	<label for="matricula">Matricula</label>
	    	<input type="text" class="form-control" id="matricula" name="matricula">
	 	</div>
        
        <div class="form-group">
		    <label for="senha">Senha</label>
		    <input type="password" class="form-control" id="senha" name="senha">
	    </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>

      </form>

    </div>

<?php  $project->partial('admin', 'footer'); ?>