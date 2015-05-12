<?php $auth->requireLevel(array(1,2,3)); ?>

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
            $crudInscricao->findOneById(intval($_GET['id']), 'id, titulo, id_aluno1, id_aluno2, id_orientador, id_situacao')->executeQuery();
            $inscricaoDB = $crudInscricao->fetchAll();

            $crudSituacao = new CRUD('situacao');
            $situacao = $crudSituacao->findOneById($inscricaoDB->id_situacao,'valor')->executeQuery()->fetchAll();

            $mail = new PHPMailer;
            $mail->CharSet = "UTF-8";
            $mail->setFrom('noexists@gmail.com', 'Portal@TCC');
            $mail->Subject = 'Interação de inscrição';
            $html = '<p>Olá, a inscrição <strong>'.$inscricaoDB->titulo.'</strong>, foi alterada para a situação <strong>'.$situacao->valor.'</strong>.';
            $html .= '<p>Clique no link ao lado para visualizar: <a href="http:'.$h->urlFor('admin/inscricoes/visualizar/'. $inscricaoDB->id, true).'">http:'.$h->urlFor('admin/inscricoes/visualizar/'. $inscricaoDB->id, true).'</a></p>';
            $html .= '<p>Para sua segurança não responda este e-mail.</p>';
            $html .= '<p>--</p>';
            $html .= '<p>Portal @TCC</p>';
            $mail->msgHTML($html);

            $crudUsuarios = new CRUD('usuario');
            $arrayUsuarios = array_filter(array($inscricaoDB->id_aluno1, $inscricaoDB->id_aluno2, $inscricaoDB->id_orientador ));
            $crudUsuarios->findAll(' id IN ('.implode(',',$arrayUsuarios).') ')->executeQuery();

            while( $usuarioEnvolvido =  $crudUsuarios->fetchAll() )
            {
                $mail->addAddress($usuarioEnvolvido->email, $usuarioEnvolvido->nome);
            }

            $mail->send();

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

   


