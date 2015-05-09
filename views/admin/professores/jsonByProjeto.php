<?php
	
	header('Content-Type: application/json');

	$crudProfessores = new CRUD('usuario');
	$id_projeto = isset($_REQUEST['id_projeto'])? intval($_REQUEST['id_projeto']) : '';

	$crudProfessores->findAll('id IN ( SELECT id_professor FROM projeto_professor WHERE id_projeto = "'.$id_projeto.'" )')->executeQuery();


	$professores = array();
	while( $professor =  $crudProfessores->fetchAll() ):
		$professores[] = array( 'id' => $professor->id, 'nome' => $professor->nome, 'disponivel' => $professor->disponivel );
	endwhile;

	echo JSON_ENCODE($professores);

