<?php $auth->requireLevel(array(3,2)); ?>

<?php

	if( $_POST['matricula'] != '' )
	{
		$h->addFilter('alunos', 'matricula', $_POST['matricula']);
	}else{
		$h->removeFilter('alunos', 'matricula');
	}

	if( $_POST['nome'] != '' )
	{
		$h->addFilter('alunos', 'nome', $_POST['nome']);
	}else{
		$h->removeFilter('alunos', 'nome');
	}

	if( $_POST['id_turma'] > 0 )
	{
		$h->addFilter('alunos', 'id_turma', intval($_POST['id_turma']));
	}else{
		$h->removeFilter('alunos', 'id_turma');
	}

	$h->redirectFor('admin/alunos');