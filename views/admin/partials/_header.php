<?php $h = new Helper(); ?>
<?php $auth = new RestrictArea(); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca de Projetos</title>

    <!-- Bootstrap -->
    <link href="<?php echo $h->appURL() ?>web/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $h->appURL() ?>web/admin/css/bootstrap-theme.css" rel="stylesheet">
    <link href="<?php echo $h->appURL() ?>web/admin/css/main.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script>
      var base = '<?php echo $h->appURL() ?>';
    </script>

  </head>
  <body>
      
      <?php if( $auth->isOnline() == true): ?>
      <div class="nav navbar-inverse" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $h->appURL() ?>">Biblioteca de Projetos</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="glyphicon glyphicon-book"></i> Projetos <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                 <?php if( $auth->isLevel(3) ): ?> <li><a href="<?php echo $h->urlFor('admin/projetos/editar'); ?>">Novo</a></li> <?php endif ?>
                <li><a href="<?php echo $h->urlFor('admin/projetos'); ?>">Listar</a></li>
              </ul>
            </li>

            <?php if( $auth->isLevel(3) ): ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="glyphicon glyphicon-user"></i> Alunos <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo $h->urlFor('admin/alunos/importar'); ?>">Importar</a></li>
                  <li><a href="<?php echo $h->urlFor('admin/alunos'); ?>">Listar</a></li>
                </ul>
              </li>
            <?php endif; ?>

            <?php if( $auth->isLevel(3) ): ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="glyphicon glyphicon-briefcase"></i> Professores <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo $h->urlFor('admin/professores/importar'); ?>">Importar</a></li>
                  <li><a href="<?php echo $h->urlFor('admin/professores'); ?>">Listar</a></li>
                </ul>
              </li>
            <?php endif; ?>

            <?php if( $auth->isLevel(3) ): ?>
               <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="glyphicon glyphicon-bookmark"></i> Cursos <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo $h->urlFor('admin/cursos/importar'); ?>">Importar</a></li>
                  <li><a href="<?php echo $h->urlFor('admin/cursos'); ?>">Listar</a></li>
                </ul>
              </li>
            <?php endif; ?>

            <?php if( $auth->isLevel(3) ): ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="glyphicon glyphicon-tags"></i> Turmas <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo $h->urlFor('admin/turmas/importar'); ?>">Importar</a></li>
                  <li><a href="<?php echo $h->urlFor('admin/turmas'); ?>">Listar</a></li>
                </ul>
              </li>
            <?php endif; ?>

              <?php 
                if( $auth->getSessionInfo()['userLevel'] == 2 )
                {
                  $crudSituacoesAbertas = new CRUD('inscricao');
                  $crudSituacoesAbertas->findAll(' id_situacao = 2 ')->executeQuery();
                }
              ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                 <i class="glyphicon glyphicon-tasks"></i> Inscrições <span class="caret"></span>
                 <?php  if( $auth->getSessionInfo()['userLevel'] == 2 ): ?> <span class="badge alert-success"><?php echo $crudSituacoesAbertas->count() ?></span>
                </a> <?php endif; ?>
                <ul class="dropdown-menu" role="menu">
                  <?php  if( $auth->getSessionInfo()['userLevel'] == 1 ): ?> <li><a href="<?php echo $h->urlFor('admin/inscricoes/editar'); ?>">Novo</a></li> <?php endif; ?>
                  <li><a href="<?php echo $h->urlFor('admin/inscricoes'); ?>">Listar</a></li>
                </ul>
              </li>
             
            </ul>
            <ul class="nav navbar-nav navbar-right">
               <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="glyphicon glyphicon-user"></i> <?php echo $auth->getSessionInfo()['userName'] ?> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li>  <a href="<?php echo $h->urlFor('admin/usuario/alterar-senha'); ?>"> <i class="glyphicon glyphicon-lock"></i> Alterar senha</span></a></li>
                  <li>  <a href="<?php echo $h->urlFor('admin/login/logout'); ?>"> <i class="glyphicon glyphicon-off"></i> Sair</span></a></li>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
      <?php endif; ?>

      <div class="container container-messages">
          <?php $h->displayFlashMessage() ?>
      </div>

      <?php
        if( $auth->isOnline() == false && $h->isUrl('admin/login/index') == false && $h->isUrl('admin/login') == false )
        { 
          $h->addFlashMessage('warning','Você precisa fazer o login para continuar navegando.');
          $h->redirectFor('admin/login/index'); 
        }  
      ?>
