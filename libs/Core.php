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
		$h = new Helper();

		if( !is_dir("views/" . $app) )
		{
			die('Aplicação não encontrada! ' . "views/" . $app);
		}

		if( !is_dir("views/" . $app . "/" . $module) )
		{
			$h->addFlashMessage('error','Módulo não encontrado!');
			$h->redirectFor($app.'/index');
		}

		if( !is_file("views/" . $app . "/" . $module . "/" . $view . ".php") )
		{
			$h->addFlashMessage('error','Página não encontrada!');
			$h->redirectFor($app.'/index');
		}

		$this->route = array(
			'url' 	 => 'views/' . $app . '/' . $module . '/' . $view . '.php',
			'urlString'  => $app . '/' . $module . '/' . $view .'/' . $id,
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
		$h = new Helper();	
		$auth = new RestrictArea();
		include("views/" . $app . "/_partials/_" . $name . ".php" );
	}

}