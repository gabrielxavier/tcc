<?php
	$c = new CRUD('projeto');
	$id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL;

	if($id){

		$crudInscricao = new CRUD('inscricao');
		$inscricoes_projeto = $crudInscricao->findAll(' id_projeto = "'.$id.'" ')->executeQuery()->count();

		if( $inscricoes_projeto > 0 ){

			$h->addFlashMessage('error', 'Você não pode remover este projeto pois existem inscrições associadas a ele!');			

		}else{

			$c->delete(' id  = "' . $id . '"')->executeQuery();

			if( $c->getExecutedQuery() )
			{

				$crudCurso = new CRUD('projeto_curso');
	        	$crudCurso->delete('id_projeto = "'. $id .'"')->executeQuery();

	        	$crudProfessor = new CRUD('projeto_professor');
	       		$crudProfessor->delete('id_projeto = "'. $id .'"')->executeQuery();
	       		
				$h->addFlashMessage('success', 'Projeto removido com sucesso!');
			}
			else
			{
				$h->addFlashMessage('error', 'Não foi possível remover o projeto!');
			}

		}

	}else
	{
		$h->addFlashMessage('error', 'Não foi possível remover o projeto!');
	}

	$h->redirectFor('admin/projetos');