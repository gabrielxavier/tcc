<?php
	if( $_POST['palavra_chave'] != '' )
	{
		$h->addFilter('inscricoes', 'palavra_chave', trim($_POST['palavra_chave']));
	}

	if( $_POST['id_situacao'] != '' )
	{
		$h->addFilter('inscricoes', 'id_situacao', intval($_POST['id_situacao']));
	}

	if( $_POST['id_turma'] != '' )
	{
		$h->addFilter('inscricoes', 'id_situacao', intval($_POST['id_turma']));
	}


	$h->redirectFor('admin/inscricoes');