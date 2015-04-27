<?php 

if( $_POST['matricula_recuperar'] )
{
    $crudUser = new CRUD('usuario');
    $crudUser->findAll()->addWhere(' matricula = "'.trim($_POST['matricula_recuperar']).'"')->executeQuery();
    if( $crudUser->count() < 1 )
    {
        $h->addFlashMessage('error','Matrícula não encontrada!');
        $h->redirectFor('admin/login/index');
    }else{

        $usuarioDB = $crudUser->fetchAll();

        $usuario = new Usuario();
        $usuario->id = $usuarioDB->id;
        $nova_senha = $h->newPassword(6);
        $usuario->senha = md5( $nova_senha );

        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";
        $mail->setFrom('noexists@gmail.com', 'Portal@TCC');
        $mail->Subject = 'Suporte @TCC';
        $html = '<p>Olá <strong>'.$usuarioDB->nome.'</strong>, conforme sua solicitação estamos lhe enviando uma nova senha.';
        $html .= '<p>Sua nova senha é <strong>'. $nova_senha.'</strong></p>';
        $html .= '<p>Para sua segurança não responda este e-mail.</p>';
        $html .= '<p>--</p>';
        $html .= '<p>Portal @TCC</p>';
        $mail->msgHTML($html);
        $mail->addAddress($usuarioDB->email, $usuarioDB->nome);
        $mail->send();

        $crudUser->update($usuario)->executeQuery();
        if( $crudUser->getExecutedQuery() )
        {
            $h->addFlashMessage('success','Uma nova senha foi criada e enviada para seu e-mail com sucesso!');
            $h->redirectFor('admin/login/index');
        }else{
            $h->addFlashMessage('error','Não foi possível enviar a senha!');
            $h->redirectFor('admin/login/index');
        }
    }
}

?>