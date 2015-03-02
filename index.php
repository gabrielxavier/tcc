<?php
	ob_start();
	session_start();
	ini_set('error_reporting', -1);
	ini_set('display_errors', 1);
	ini_set('html_errors', 1);
	date_default_timezone_set("Brazil/East");
	
	include_once("config.php");
	include_once("libs/Helper.php");
	include_once("libs/Database.php");
	include_once("libs/AbstractModel.php");
	include_once("libs/Crud.php");
	include_once("libs/RestrictArea.php");
	include_once("libs/Core.php");
	
	$project = new Core();
	$h = new Helper();
	$auth = new RestrictArea();
  	$route = $project->getRoute();
  
 	include_once($route['url']);
?>
