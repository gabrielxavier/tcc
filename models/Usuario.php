<?php

class Usuario extends AbstractModel
{
	public $nome;
	public $matricula;
	public $email;
	public $telefone_residencial;
	public $telefone_comercial;
	public $telefone_celular;
	public $senha;
	public $id_perfil;
	public $disponivel;
	public $ultimo_acesso;
}