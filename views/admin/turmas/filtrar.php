<?php $auth->requireLevel(array(3)); ?>

<?php

	if( $_POST['sigla'] != '' )
	{
		$h->addFilter('turmas', 'sigla', $_POST['sigla']);
	}else{
		$h->removeFilter('turmas', 'sigla');
	}

	if( $_POST['nome'] != '' )
	{
		$h->addFilter('turmas', 'nome', $_POST['nome']);
	}else{
		$h->removeFilter('turmas', 'nome');
	}

	if( $_POST['id_curso'] > 0 )
	{
		$h->addFilter('turmas', 'id_curso', intval($_POST['id_curso']));
	}else{
		$h->removeFilter('turmas', 'id_curso');
	}

	if( $_POST['slug_semestre'] != "" )
	{
		$h->addFilter('turmas', 'slug_semestre', $_POST['slug_semestre']);
	}else{
		$h->removeFilter('turmas', 'slug_semestre');
	}

	$h->redirectFor('admin/turmas');