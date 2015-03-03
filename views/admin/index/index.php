<?php $project->partial('admin', 'header'); ?>

<div class="container">
	<div class="jumbotron">
	  <h1>Olá <?php echo $auth->getSessionInfo('userName') ?>!</h1>
	  <p>Seja bem vindo ao portal @TCC da Unisociesc.</p>
	</div>
</div>

<?php $project->partial('admin', 'footer'); ?>