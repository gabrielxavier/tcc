<?php
	$c = new CRUD('usuario');
	$id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL;

	if($id){

		$crudInscricoes = new CRUD('inscricao');
		$inscricoes_aluno = $crudInscricoes->findAll(' id_aluno1 = "'.$id.'" OR id_aluno2 = "'.$id.'" ')->executeQuery()->count();

		if( $inscricoes_aluno > 0  ){

			$h->addFlashMessage('error', 'Você não pode remover este aluno pois existem inscricões associadas a ele!');			

		}else{

			$c->delete(' id  = "' . $id . '"')->executeQuery();

			if( $c->getExecutedQuery() )
			{
	       		
				$crudTurma = new CRUD('turma_aluno');
	        	$crudTurma->delete('id_aluno = "'. $id .'"')->executeQuery();

				$h->addFlashMessage('success', 'Aluno removido com sucesso!');
			}
			else
			{
				$h->addFlashMessage('error', 'Não foi possível remover o aluno!');
			}

		}

	}else
	{
		$h->addFlashMessage('error', 'Não foi possível remover o aluno!');
	}

	$h->redirectFor('admin/alunos');