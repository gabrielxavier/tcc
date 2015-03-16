<?php $auth->requireLevel(array(3)); ?>

<?php
	$c = new CRUD('turma');
	$id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL;

	if($id){

		$crudAlunos = new CRUD('turma_aluno');
		$turma_alunos = $crudAlunos->findAll(' id_turma = "'.$id.'" ')->executeQuery()->count();

		$crudAInscricoes = new CRUD('inscricao');
		$inscricoes_turma = $crudAInscricoes->findAll(' id_turma = "'.$id.'" ')->executeQuery()->count();


		if( $turma_alunos > 0 || $inscricoes_turma > 0 ){

			$h->addFlashMessage('error', 'Você não pode remover esta turma pois existem alunos associados a ela!');			

		}else{

			$c->delete(' id  = "' . $id . '"')->executeQuery();

			if( $c->getExecutedQuery() )
			{
	       		
				$h->addFlashMessage('success', 'Turma removida com sucesso!');
			}
			else
			{
				$h->addFlashMessage('error', 'Não foi possível remover a turma!');
			}

		}

	}else
	{
		$h->addFlashMessage('error', 'Não foi possível remover a turma!');
	}

	$h->redirectFor('admin/turmas');