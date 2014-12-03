<?php 
class RestrictArea{
	
		private $redir;
		private $tb_name;
		public $error;
		public $helper;
		
		function __construct() { 	
	
			$this->redir = "index.php";
			$this->error = false;
			$this->helper = new Helper();
		} 
		
		function showError(){
			
			return $this->error;	
		}
		
		public function Login($matricula, $senha, $userCookie=0){

			$crudUsuario = new CRUD('usuario');
			$results = $crudUsuario->findAll(' matricula = "'.$matricula.'" ')->executeQuery()->count();

			if( $results > 0 )
			{
					
					$results =  $crudUsuario->findAll(' matricula = "'.$matricula.'" and senha = "'.md5($senha).'" ')->executeQuery()->count();
		
					if( $results > 0){
						
						session_start();
						
						$usuario = $crudUsuario->fetchAll();

						$_SESSION = array("userName"=>$usuario->nome,"userLevel"=>$usuario->id_perfil,"userID"=>$usuario->id,"sessionID"=>session_id(),"sessionTime"=>time());

						if($userCookie>0){
							
							setcookie("userContinue", md5($usuario->id),time()+172800);
							
						}else{
							setcookie("userContinue", "");
						}
						
						return true;
												
					}else{
						$this->error = "Usuário e senha não conferem!";
						return false;
						
					}
				
			}else{
	
				$this->error = "Usuário não encontrado!";
				return false;
			}
		
		
		}
		
		public function Logout(){
			
			session_destroy();

			return true;
			
		}
		public function isOnline($level = false){
		
		$usuarioLogado = false;
		
		if( isset($_SESSION['sessionID']) && $_SESSION['sessionID'] == session_id() ){

			if( time() - $_SESSION['sessionTime'] > 900 ){
				$this->Logout();
			}else{
				
				$_SESSION['sessionTime'] = time();
				
				$crudUsuario = new CRUD('usuario');
				
				$update = $crudUsuario->setQuery('UPDATE usuario SET ultimo_acesso = "'.date("Y-m-d H:i:s").'" WHERE id = "'.$_SESSION['userID'].'"' )->executeQuery();

				$usuarioLogado = true;

				if( $level  ){
					if( !$this->isLevel($level) ){
						$usuarioLogado = false;
					}
				}

			}
		}else{
				
			$this->error = "Você precisa fazer o login.";

		}


		return $usuarioLogado;
			
		}
		
		public function isLevel($pageLevel){
			
			if($_SESSION['userLevel']<$pageLevel){
		
				$this->error = "Você não possui previlégio para acessar esta página!";	
				return false;
			}else{
				
				return true;	
			}
			
		}

		public function getSessionInfo(){
			return $_SESSION;
		}
		
}