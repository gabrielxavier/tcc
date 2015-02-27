<?php
    $c = new CRUD('inscricao_situacao'); 
	  $situacao = new Inscricaosituacao();
    $situacao->id_situacao = $_POST['id_situacao'];
    $situacao->id_inscricao = intval($_GET['id']);
    $situacao->id_autor = $auth->getSessionInfo('userID');
    $situacao->comentario = $_POST['comentario'];

    if( $_POST['id_situacao'] != '' )
    {
        $c->save($situacao)->executeQuery();

        $crudInscricao = new CRUD('inscricao');
        
        $inscricao = new Inscricao();
        $inscricao->id = $situacao->id_inscricao;
        $inscricao->id_situacao = $_POST['id_situacao'];

        $crudInscricao->update($inscricao)->executeQuery();

        if( $crudInscricao->getExecutedQuery() )
        {
            $h->addFlashMessage('success', 'Situação alterada com sucesso!');
        }
        else
        {
            $h->addFlashMessage('error', 'Não foi possível alterar a situação!');
        }
        $h->redirectFor('admin/inscricoes/visualizar/'.$_GET['id']);


    }else{
        $h->addFlashMessage('error', 'Não foi possível alterar a situação!');
        $h->redirectFor('admin/inscricoes/');
    }

   


