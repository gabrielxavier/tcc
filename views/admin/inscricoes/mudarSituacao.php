<?php

    if( $_POST['id_situacao'] != '' )
    {
        $c = new CRUD('inscricao_situacao'); 
        $situacao = new Inscricaosituacao();
        $situacao->id_situacao = intval($_POST['id_situacao']);
        $situacao->id_inscricao = intval($_GET['id']);
        $situacao->id_autor = $auth->getSessionInfo('userID');
        $situacao->comentario = $_POST['comentario'];

        $c->save($situacao)->executeQuery();

        $crudInscricao = new CRUD('inscricao');
        
        $inscricao = new Inscricao();
        $inscricao->id = $situacao->id_inscricao;
        $inscricao->id_situacao = intval($_POST['id_situacao']);

        $crudInscricao->update($inscricao)->executeQuery();

        if( $crudInscricao->getExecutedQuery() )
        {   
            //Disparo email
            $inscricao = $crudInscricao->findOneById($_POST['id_situacao'], 'id, titulo, id_aluno1, id_aluno2, id_orientador, id_situacao')->executeQuery()->fetchAll();
            
            $crudSituacao = new CRUD('situacao');
            $situacao = $crudSituacao->findOneById($inscricao->id_situacao,'valor')->executeQuery()->fetchAll();;

            $mail = new PHPMailer;
            $mail->setFrom('gabriel.xavier.joinville@gmail.com', 'Gabriel Xavier');
            $mail->Subject = 'Aviso de interação na inscricao '.$inscricao->titulo;
            $html = 'A inscrição '.$inscricao->titulo.', foi alterada para a situação <strong>'.$situacao->valor.'</strong>.';
            $html .= '( <a href="'.$h->urlFor('admin/inscricoes/visualizar/'.$inscricao->id.'#interacoes', true).'">Clique aqui para visualizar</a> )';
            $mail->msgHTML($html);

            $crudUsuarios = new CRUD('usuario');
            $crudUsuarios->findAll(' id IN ('.$inscricao->id_aluno1.', '.$inscricao->id_aluno2.', '.$inscricao->id_orientador.') ')->executeQuery();
            while( $usuarioEnvolvido =  $crudUsuarios->fetchAll() )
            {
                $mail->addAddress($usuarioEnvolvido->email, $usuarioEnvolvido->nome);
            }

            // $mail->send();

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

   


