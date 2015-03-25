<?php

	if( $_POST['palavra_chave'] != '' )
	{
		$h->addFilter('projetos', 'palavra_chave', $_POST['palavra_chave']);

	}else{
		$h->removeFilter('projetos', 'palavra_chave');
	}

	if( $_POST['id_curso'] != '' )
	{
		$h->addFilter('projetos', 'id_curso', $_POST['id_curso']);

	}else{
		$h->removeFilter('projetos', 'id_curso');
	}

	$h->redirectFor('admin/projetos');