<?php
	
	header('Content-Type: application/json');

	$crudProjetos = new CRUD('projeto');
	$id_turma = isset($_REQUEST['id_turma'])? intval($_REQUEST['id_turma']) : '';

	$crudProjetos->setQuery("SELECT p.* FROM projeto p INNER JOIN projeto_curso pc, turma t WHERE p.id = pc.id_projeto and pc.id_curso = t.id_curso and t.id = '".$id_turma."'")->executeQuery();

	$projetos = array();
	while( $projeto =  $crudProjetos->fetchAll() ):
		$projetos[] = array( 'id' => $projeto->id, 'titulo' => $projeto->titulo );
	endwhile;

	echo JSON_ENCODE($projetos);


