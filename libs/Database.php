<?php
class Database {

	private $DB;
	public $conexao;

	function __construct(){
				
		$hostDB = "localhost";
		$userDB = "root";
		$passDB = "root";
		$DB = "projeto_integrador";
		$this->conexao = $this->connectDB($DB,$userDB,$passDB,$hostDB);
	
	}
	
	function connectDB($DB='tcc',$userDB='root',$passDB='root',$hostDB='127.0.0.1'){
		
		$this->conexao = @mysql_connect($hostDB,$userDB,$passDB);
		
		if(!$this->conexao){
			
			echo $this->error = 'Não foi possivel acessar o banco de dados';

			$h = new Helper();	
			$h->addFlashMessage('error','Não foi possivel acessar o banco de dados');
			$h->redirectFor('admin/login/index'); 
			return false;
		
		}else{
	
			$this->selected_db = @mysql_select_db($DB);
			if(!$this->selected_db){
		
				echo $this->error = "Não foi possível conectar ao banco de dados!";	
				return false;
			}

			@mysql_query("SET NAMES 'utf8'");
			@mysql_query('SET character_set_connection=utf8');
			@mysql_query('SET character_set_client=utf8');
			@mysql_query('SET character_set_results=utf8');
		
		}
		
		return $this->conexao;	
		
	}
	
	function getConection()
	{
		return $this->conexao;
	}

	function selectDB($nameDB){
		$this->DB = @mysql_select_db($nameDB);
	}
			
	function showError(){	
		return $this->error;	
	}

}