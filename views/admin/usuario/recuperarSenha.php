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

         $crudUser->update($usuario)->executeQuery();
         if( $crudUser->getExecutedQuery() )
         {
            $h->addFlashMessage('success','Senha enviada com sucesso! '.$nova_senha);
            $h->redirectFor('admin/login/index');
         }else{
            $h->addFlashMessage('error','Não foi possível enviar a senha!');
            $h->redirectFor('admin/login/index');
        }
    }
}

?>