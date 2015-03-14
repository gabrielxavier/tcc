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


	$h->redirectFor('admin/alunos');