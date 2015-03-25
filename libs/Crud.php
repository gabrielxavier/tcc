<?php
class Crud extends Database {

	private $model;
	private $table;
	private $query;
	private $executedQuery;
	private $whereArray;
	private $joinArray;
	private $limit;
	private $orderBy;

	public function __construct($model)
	{
		parent::__construct();
		$this->table = $model;
		$this->model = str_replace("_", "", ucwords($model));
		$this->loadModel();
	}

	public function clearQuery(){
		$this->query 	  = NULL;
		$this->whereArray = NULL;
		$this->joinArray  = NULL;
		$this->limit      = NULL;
		$this->orderBy    = NULL;

		return $this;
	}

	public function getModel(){
		return $this->model;
	}

	public function setQuery($query)
	{
		$this->query = $query;
		return $this;
	}

	public function getQuery()
	{
		$tempQuery = $this->query;

		if( count($this->joinArray) > 0 ){
			foreach( $this->joinArray as $join )
			{
				$tempQuery .= " INNER JOIN ". $join;
			}
		}

		if( count( $this->whereArray ) > 0 )
		{
			$tempQuery .= " WHERE " . implode(" AND ", $this->whereArray );
		}
		
		if( $this->orderBy ){
			$tempQuery .= " ORDER BY " . $this->orderBy;
		} 

		if( $this->limit > 0 ){
			$tempQuery .= " LIMIT " . $this->limit;
		} 

		return $tempQuery;
	}

	private function loadModel()
	{	
		if( !class_exists($this->getModel()) ){
			include_once("models/". $this->getModel() .".php");
		}
	}

	public function save( $registro )
	{
		$this->clearQuery();
		$campos = array();
		$valores = array();
		$registro->created_at = date("Y-m-d H:i:s");
		$coluns = get_object_vars($registro);
		unset($coluns['id']);
		unset($coluns['updated_at']);

		foreach( $coluns as $chave => $valor)
		{
			if( $this->injection( $valor ) != NULL ){
				$campos[]  = $chave;
				$valores[] = "'".strip_tags( $this->injection( $valor ) )."'";
			}
		}

		$campos  = join(',', $campos);
		$valores = join(",", $valores);
		
		$this->query = "INSERT INTO $this->table ($campos) values ($valores);";

		return $this;

	}

	public function update( $registro )
	{	
		$this->clearQuery();
		$registro->updated_at = date("Y-m-d H:i:s");
		$coluns = get_object_vars($registro);
		unset($coluns['id']);
		unset($coluns['created_at']);

		foreach ($coluns as $chave=>$valor){
			if( $this->injection($valor) != NULL ){	
				$alts[] = $chave." = '".strip_tags($this->injection($valor))."' ";
			}
		}
		$lista_alts = join(",", $alts);
		
		$this->query = "UPDATE $this->table SET $lista_alts WHERE id = " . $registro->id;

		return $this;
	}

	public function delete( $clausula = '1=2' )
	{
		$this->query = "DELETE FROM $this->table";

		$this->addWhere( $clausula );

		return $this;
	}

	public function find($coluns = "*"){
		$this->query = "SELECT $coluns FROM $this->table ";
	}

	public function findAll($clausula = "", $coluns = "*")
	{
		$this->query = "SELECT $coluns FROM $this->table ";

		if( $clausula != "" )
			$this->addWhere( $clausula );
		
		return $this;
	}

	public function fetchAll()
	{
		return @mysql_fetch_object($this->executedQuery);
	}

	public function findOneById($id, $coluns = "*")
	{
		$this->query = "SELECT $coluns FROM $this->table ";

		$this->addWhere(" id = '".$id."'");

		return $this;
	}

	public function executeQuery()
	{	
		$this->executedQuery = mysql_query( $this->getQuery() ); 
		return $this;
	}

	public function addWhere($where)
	{
		$this->whereArray[] = $where;

		return $this;
	}

	public function addJoin($join){
		$this->joinArray[] = $join;

		return $this;
	}

	public function addLimit($limit)
	{
		$this->limit = $limit;

		return $this;
	}

	public function addOrder($order)
	{
		$this->orderBy = $order;

		return $this;
	}

	public function count()
	{
		return mysql_num_rows($this->executedQuery);
	}

	public function nextID(){
		$this->setQuery("SHOW TABLE STATUS LIKE '$this->table'");
		$exe = $this->executeQuery();
		$obj = $this->fetchAll();
		return $obj->Auto_increment;
	}

	public function getExecutedQuery()
	{
		return $this->executedQuery;
	}
	
	public function injection($str){
		if ( get_magic_quotes_gpc() ){
			return $str;
		}else{
			return addslashes($str);
		}
	}

	public function getError(){
		return @mysql_error();
	}
}