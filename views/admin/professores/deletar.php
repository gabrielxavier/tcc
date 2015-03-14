<?php
	$c = new CRUD('usuario');
	$id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL;

	if($id){

		$crudProfessores = new CRUD('projeto_professor');
		$projetos_professor = $crudProfessores->findAll(' id_professor = "'.$id.'" ')->executeQuery()->count();

		$crudInscricoes = new CRUD('inscricao');
		$inscricoes_professor = $crudInscricoes->findAll(' id_orientador = "'.$id.'" ')->executeQuery()->count();

		if( $projetos_professor > 0 || $inscricoes_professor > 0 ){

			$h->addFlashMessage('error', 'Você não pode remover este professor pois existem registros associados a ele!');			

		}else{

			$c->delete(' id  = "' . $id . '"')->executeQuery();

			if( $c->getExecutedQuery() )
			{
	       		
				$h->addFlashMessage('success', 'Professor removido com sucesso!');
			}
			else
			{
				$h->addFlashMessage('error', 'Não foi possível remover o professor!');
			}

		}

	}else
	{
		$h->addFlashMessage('error', 'Não foi possível remover o professor!');
	}

	$h->redirectFor('admin/professores');