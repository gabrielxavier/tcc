<?php
	$c = new CRUD('inscricao');
	$id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL;

	if($id){
		$c->delete(' id  = "' . $id . '"')->executeQuery();
		
		$crudSituacoes = new CRUD('inscricao_situacao');
		$crudSituacoes->delete(' id_inscricao = "'.$id.'" ')->executeQuery();

		
		if( $c->getExecutedQuery() )
		{
			$h->addFlashMessage('success', 'Inscrição removida com sucesso!');
		}
		else
		{
			$h->addFlashMessage('error', 'Não foi possível remover a inscricão!');
		}

	}else{
		$h->addFlashMessage('error', 'Não foi possível remover a inscricão!');
	}

	$h->redirectFor('admin/inscricoes');