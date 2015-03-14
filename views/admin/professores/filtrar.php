<?php

	if( $_POST['matricula'] != '' )
	{
		$h->addFilter('professores', 'matricula', $_POST['matricula']);
	}else{
		$h->removeFilter('professores', 'matricula');
	}

	if( $_POST['nome'] != '' )
	{
		$h->addFilter('professores', 'nome', $_POST['nome']);
	}else{
		$h->removeFilter('professores', 'nome');
	}


	$h->redirectFor('admin/professores');