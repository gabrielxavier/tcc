<?php $auth->requireLevel(array(3)); ?>

<?php
	$c = new CRUD('curso');
	$id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL;

	if($id){

		$crudTurma = new CRUD('turma');
		$turma_curso = $crudTurma->findAll(' id_curso = "'.$id.'" ')->executeQuery()->count();

		if( $turma_curso > 0 ){

			$h->addFlashMessage('error', 'Você não pode remover este curso pois existem turmas associadas a ele!');			

		}else{

			$c->delete(' id  = "' . $id . '"')->executeQuery();

			if( $c->getExecutedQuery() )
			{
	       		
				$h->addFlashMessage('success', 'Curso removido com sucesso!');
			}
			else
			{
				$h->addFlashMessage('error', 'Não foi possível remover o curso!');
			}

		}

	}else
	{
		$h->addFlashMessage('error', 'Não foi possível remover o curso!');
	}

	$h->redirectFor('admin/cursos');