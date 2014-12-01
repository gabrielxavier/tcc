<?php

$matricula = isset($_POST['matricula']) ? trim($_POST['matricula']) : '';
$senha 	   = isset($_POST['senha'])? trim($_POST['senha']) : '';
$perfil    = isset($_POST['perfil'])? trim($_POST['perfil']) : '';

if(isset($_POST['matricula'])){
	$success = $auth->login($matricula, $senha);
	if($success){
		$h->redirectFor('admin/index');
	}else{
		$h->redirectFor('admin/login');
	}
}
