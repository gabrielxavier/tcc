<?php
	
	header('Content-Type: application/json');

	$crudProjetos = new CRUD('projeto');
	$id_curso = isset($_REQUEST['id_curso'])? intval($_REQUEST['id_curso']) : '';

	$crudProjetos->findAll('id IN ( SELECT id_projeto FROM projeto_curso WHERE id_curso = "'.$id_curso.'" )')->executeQuery();


	$projetos = array();
	while( $projeto =  $crudProjetos->fetchAll() ):
		$projetos[] = array( 'id' => $projeto->id, 'titulo' => $projeto->titulo );
	endwhile;

	echo JSON_ENCODE($projetos);


