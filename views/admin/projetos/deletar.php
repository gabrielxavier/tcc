<?php
	$c = new CRUD('projeto');
	$id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL;

	if($id){
		$c->delete(' id  = "' . $id . '"')->executeQuery();

		if( $c->getExecutedQuery() )
		{
			$h->addFlashMessage('success', 'Projeto removido com sucesso!');
		}
		else
		{
			$h->addFlashMessage('error', 'Não foi possível remover o projeto!');
		}

	}else
	{
		$h->addFlashMessage('error', 'Não foi possível remover o projeto!');
	}

	$h->redirectFor('admin/projetos');