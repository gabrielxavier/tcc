<?php

	if( $_POST['palavra_chave'] != '' )
	{
		$h->addFilter('projetos', 'palavra_chave', trim($_POST['palavra_chave']));


	}else{
		$h->removeFilter('projetos', 'palavra_chave');
	}

	$h->redirectFor('admin/projetos');