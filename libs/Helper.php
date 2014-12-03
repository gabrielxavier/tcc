<?php
class Helper {
	
	public $projectURL;
	public $perPage;

	public function __construct()
	{
		$this->projectURL = '/projeto-integrador/';
		$this->perPage = 10;
		if ( !isset($_SESSION['filters']) ) { $_SESSION['filters'] = array(); }
	}

	public function appURL()
	{
		return $this->projectURL;
	}

	public function urlFor($params){
		return $this->projectURL . $params;
	}

	public function redirectFor( $params )
	{
		header("Location: ".$this->projectURL . $params);
	}

	public function isUrl( $params )
	{
		return $_SERVER['REQUEST_URI'] == $this->projectURL . $params;
	}


	//Date
	public function dateFromDB($data, $separador="/")
	{
		$data = explode("-", substr($data, 0, 10));
		return $data[2].$separador.$data[1].$separador.$data[0];
	}

	public function dateTimeFromDB($data)
	{
			$data = explode(" ",$data);	
			$hora = $data[1];
			$data = explode("-",$data[0]);
			
			return $data[2]."/".$data[1]."/".$data[0]." ".$hora;	
	}


	//Pagination
	public function getPerPage()
	{
		return $this->perPage;
	}

	public function getPaginationVars()
	{
		$p 	   = ( isset( $_GET['p']) )? intval($_GET['p']) : 1;
		$limit = ( ($p - 1) * $this->getPerPage() ) . ',' . ( $p * $this->getPerPage() );
		
		return array(
						'p' => $p, 
						'limit' => $limit
					);
	}

	public function pagination( $pagina, $total)
	{
		$porPagina = $this->perPage;
		$qtdePaginas = ceil($total/$porPagina);
		$paginaVal = substr($_SERVER['REQUEST_URI'], -1);
		if( !is_numeric($paginaVal) )
		{
			$urlPages = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}else{
			$urlPages = 'http://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['REQUEST_URI'], 0, strlen($_SERVER['REQUEST_URI']) - 1 );
		}
	?>
		<div class="pagination-wrapper">
			<ul class="pagination">
			  <?php if($pagina>1): ?> <li><a href="<?=$urlPages . '1'?>">&laquo;</a></li> <?php endif; ?>
			   <?php 
	            $x = ((ceil( $pagina/$porPagina)-1)*$porPagina)+1;
	            $y = ((ceil( $pagina/$porPagina)-1)*$porPagina)+$porPagina;
	            
	            if($pagina>$porPagina){?>
	            	<li><a href="<?=$urlPages?>1">1</a></li> 
	            	<li><a href="<?=$urlPages . ($x-1) ?>">...</a></li> 
	            <?php }
	                
	            while($x<=$y && $x<=$qtdePaginas){ ?>        
	             	<li <?php if($pagina==$x): ?> class="active" <?php endif; ?>><a href="<?=$urlPages . $x?>"><?=$x?></a></li> 
	            <?php $x++; } ?>
	            
	            <?php if($pagina!=$qtdePaginas && ceil($qtdePaginas/$porPagina)!=ceil($pagina/$porPagina) && $qtdePaginas!=0){?>
	                  <li><a href="<?=$urlPages . ($x+1)?>">...</a></li>
	                  <li><a href="<?=$urlPages . $qtdePaginas;?>"><?=$qtdePaginas;?></a></li>
	            <?php }	?>
			
			  <?php if($pagina<$qtdePaginas): ?><li><a href="<?=$urlPages . ($qtdePaginas)?>">&raquo;</a></li> <?php endif; ?>
			</ul>
		</div>
	<?php
	}

	public function addFilter($module, $key, $value)
	{
		$_SESSION['filters'][$module][$key] = $value;
	}

	public function getFilter($module, $key)
	{	
		return isset($_SESSION['filters'][$module][$key])? $_SESSION['filters'][$module][$key] : false;
	}

	public function removeFilter($module, $key)
	{
		unset($_SESSION['filters'][$module][$key]);
	}

	public function getFilters(){
		return $_SESSION['filters'];
	}

	public function getSituacaoDecorations(){
		return array(
            1 => array('icon'=> 'glyphicon-asterisk', 'color'=>''),
            2 => array('icon'=> 'glyphicon-time', 'color'=>'info'),
            3 => array('icon'=> 'glyphicon-ok', 'color'=>'success'),
            4 => array('icon'=> 'glyphicon-remove', 'color'=>'danger')
        );
	}

	public function addFlashMessage( $type, $message ){
		$_SESSION['flash_messages'][$type][] = $message;
	}

	public function displayFlashMessage()
	{
		if( !isset($_SESSION['flash_messages']) ) return false;

		if( isset($_SESSION['flash_messages']['error']) )
		{
			echo '<div class="alert alert-danger"> <i class="glyphicon glyphicon-exclamation-sign"></i>&nbsp;';
			echo implode('<br />', $_SESSION['flash_messages']['error'] );
			echo '</div>';
		}

		if( isset($_SESSION['flash_messages']['success']) )
		{
			echo '<div class="alert alert-success"> <i class="glyphicon glyphicon-ok-sign"></i>&nbsp;';
			echo implode('<br />', $_SESSION['flash_messages']['success'] );
			echo '</div>';
		}

		if( isset($_SESSION['flash_messages']['warning']) )
		{
			echo '<div class="alert alert-warning"> <i class="glyphicon glyphicon-question-sign"></i>&nbsp;';
			echo implode('<br />', $_SESSION['flash_messages']['warning'] );
			echo '</div>';
		}

		unset($_SESSION['flash_messages']);

	}

}