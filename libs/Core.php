<?php

class Core {

	private $route;

	public function __construct()
	{

		$this->setRoute();
	}

	private function setRoute()
	{
		$app 	= isset($_GET['app'])? trim($_GET['app']) : 'admin';
		$module = isset($_GET['module'])? trim($_GET['module']) : 'index';
		$view	= isset($_GET['view'])? trim($_GET['view']) : 'index';
		$id 	= isset($_GET['id'])? intval(trim($_GET['id'])) : NULL;

		if( !is_dir("views/" . $app) )
		{
			die('Aplicação não encontrada! ' . "views/" . $app);
		}

		if( !is_dir("views/" . $app . "/" . $module) )
		{
			die('Módulo não encontrado! ' . "views/" . $app . "/" . $module);
		}

		if( !is_file("views/" . $app . "/" . $module . "/" . $view . ".php") )
		{
			die('View não encontrada! ' . "views/" . $app . "/" . $module . "/" . $view . ".php");
		}

		$this->route = array(
			'url' 	 => 'views/' . $app . '/' . $module . '/' . $view . '.php',
			'app' 	 => $app,
			'module' => $module,
			'view'	 => $view,
			'id'	 => $id
		);
	}

	public function getRoute()
	{
		return $this->route;
	}

	public function partial($app, $name)
	{
		include("views/" . $app . "/partials/_" . $name . ".php" );
	}

}