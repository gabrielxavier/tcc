<?php

	if( $_POST['palavra_chave'] != '' )
	{
		$h->addFilter('inscricoes', 'palavra_chave', trim($_POST['palavra_chave']));


	}else{
		$h->removeFilter('inscricoes', 'palavra_chave');
	}

	if( $_POST['id_situacao'] > 0 )
	{
		$h->addFilter('inscricoes', 'id_situacao', intval($_POST['id_situacao']));
	}else{
		$h->removeFilter('inscricoes', 'id_situacao');
	}

	if( $_POST['id_turma'] > 0 )
	{
		$h->addFilter('inscricoes', 'id_turma', intval($_POST['id_turma']));
	}else{
		$h->removeFilter('inscricoes', 'id_turma');
	}

	$h->redirectFor('admin/inscricoes');