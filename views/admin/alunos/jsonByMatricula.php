<?php
	
	header('Content-Type: application/json');

	$crudAlunos = new CRUD('usuario');
	$aluno_matricula = isset($_REQUEST['aluno_matricula'])? trim($_REQUEST['aluno_matricula']) : '';

	$crudAlunos->findAll(' matricula = "'. $aluno_matricula .'" ', ' id, nome ')->executeQuery();

	$aluno = $crudAlunos->fetchAll();

	echo JSON_ENCODE($aluno);

