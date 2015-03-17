<?php $auth->requireLevel(array(3)); ?>

<?php
	$c = new CRUD('arquivo');
	$id =  (isset($_GET['id']) )? intval($_GET['id']) : NULL;

	if($id){

		$arquivo = $c->findAll('id = "'.$id.'" ')->executeQuery()->fetchAll();

		if( unlink('web/admin/uploads/'.$arquivo->caminho) ){

			$c->delete(' id  = "' . $id . '"')->executeQuery();

			if( $c->getExecutedQuery() )
			{
		   		
				$h->addFlashMessage('success', 'Arquivo removido com sucesso!');
			}
			else
			{
				$h->addFlashMessage('error', 'Não foi possível remover o arquivo!');
			}

		}else{
			$h->addFlashMessage('error', 'Não foi possível remover o arquivo!');
		}

	}
	else
	{
		$h->addFlashMessage('error', 'Não foi possível remover o arquivo!');
	}

	$h->redirectFor('admin/arquivos');