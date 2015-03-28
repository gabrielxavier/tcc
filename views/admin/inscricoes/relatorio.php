<?php

	if($_POST['modelo_impressao'] != 'csv' )
	{
		$project->partial('admin', 'header');
	}

	// Valida usuario
	$auth->requireLevel(array(2,3));

	// Busca a partir dos filtros
	$c = new CRUD('inscricao'); $c->findAll();

	if( $auth->getSessionInfo('userLevel') == 1 )
	{
		$c->addWhere(' ( id_aluno1 = "'.$auth->getSessionInfo('userID').'" OR id_aluno2 = "'.$auth->getSessionInfo('userID').'"  )');
	}
	else if( $auth->getSessionInfo('userLevel') == 2 )
	{
		$c->addWhere(' id_orientador = "'.$auth->getSessionInfo('userID').'" ');
	}

	// Filtros
	if( $h->getFilter('inscricoes', 'palavra_chave') )
	{
		$c->addWhere(' (titulo LIKE "%'.$h->getFilter('inscricoes', 'palavra_chave').'%" OR descricao LIKE "%'.$h->getFilter('inscricoes', 'palavra_chave').'%" ) ');
	}

	if( $h->getFilter('inscricoes', 'id_situacao') > 0 )
	{
		$c->addWhere(' id_situacao = "'.$h->getFilter('inscricoes', 'id_situacao').'" ');
	}

	if( $h->getFilter('inscricoes', 'id_turma') > 0 )
	{
		$c->addWhere(' id_turma = "'.$h->getFilter('inscricoes', 'id_turma').'" ');
	}

	if( $h->getFilter('inscricoes', 'slug_semestre') != "" )
	{
		$c->addWhere(' semestre = "'.$h->getFilter('inscricoes', 'slug_semestre').'" ');
	}

	$resultados = $c->addOrder(trim($_POST['ordem']).' DESC ')->executeQuery();




	// Exporta em CSV
	if($_POST['modelo_impressao'] == 'csv' ){

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream'); 
		header('Content-Disposition: attachment; filename=relatorio-inscricoes-'.date('YmdHis').'.csv');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		$output = fopen('php://output', 'w');

		$colunas = Array();
		if(in_array('tema', $_POST['campos']))
			$colunas[] = 'Tema';

		if(in_array('descricao', $_POST['campos']))
			$colunas[] = 'Descrição';

		if(in_array('projeto_referencia', $_POST['campos']))
			$colunas[] = 'Projeto de referência';

		if(in_array('orientador', $_POST['campos']))
			$colunas[] = 'Orientador';

		if(in_array('aluno1', $_POST['campos']))
			$colunas[] = 'Aluno 1';

		if(in_array('aluno2', $_POST['campos']))
			$colunas[] = 'Aluno 2';

		if(in_array('turma', $_POST['campos']))
			$colunas[] = 'Turma';

		if(in_array('semestre', $_POST['campos']))
			$colunas[] = 'Semestre';

		if(in_array('created_at', $_POST['campos']))
			$colunas[] = 'Data criação';

		if(in_array('updated_at', $_POST['campos']))
			$colunas[] = 'Data atualização';

		if(in_array('situacao', $_POST['campos']))
			$colunas[] = 'Situação';

		// Escreve as colunas
		fputcsv($output, $colunas, ";");

		while ($registro = $c->fetchAll()){

			$valores = Array();
			if(in_array('tema', $_POST['campos']))
				$valores[] = $registro->titulo;

			if(in_array('descricao', $_POST['campos']))
				$valores[] = $registro->descricao;

			if(in_array('projeto_referencia', $_POST['campos']))
			{
                $p = new CRUD('projeto');
                $projeto = $p->findOneById($registro->id_projeto)->executeQuery()->fetchAll();
				$valores[] = $projeto->titulo;
			}

			if(in_array('orientador', $_POST['campos']))
			{
                $o = new CRUD('usuario');
                $orientador = $o->findOneById($registro->id_orientador)->executeQuery()->fetchAll();
				$valores[] = $orientador->nome;
			}

			$a = new CRUD('usuario');
			if(in_array('aluno1', $_POST['campos']))
			{
                $aluno1 = $a->findOneById($registro->id_aluno1)->executeQuery()->fetchAll();
				$valores[] = $aluno1->nome . ' (' . $aluno1->matricula . ')';
			}

			if(in_array('aluno2', $_POST['campos']))
			{
				if( $registro->id_aluno2 )
				{
                	$aluno2 = $a->findOneById($registro->id_aluno2)->executeQuery()->fetchAll();
					$valores[] = $aluno2->nome . ' (' . $aluno2->matricula . ')';
				}else{
					$valores[] = '';
				}
			}

			if(in_array('turma', $_POST['campos']))
			{
                $t = new CRUD('turma');
                $turma = $t->findOneById($registro->id_turma)->executeQuery()->fetchAll();
				$valores[] = $turma->sigla;
			}

			if(in_array('semestre', $_POST['campos']))
				$valores[] = $registro->semestre;

			if(in_array('created_at', $_POST['campos']))
				$valores[] = $h->dateTimeFromDB($registro->created_at);

			if(in_array('updated_at', $_POST['campos']))
				$valores[] = $h->dateTimeFromDB($registro->updated_at);

			if(in_array('situacao', $_POST['campos']))
			{
				$s = new CRUD('situacao');
                $situacao = $s->findOneById($registro->id_situacao)->executeQuery()->fetchAll();
				$valores[] = $situacao->valor;
			}

			// Escreve os valores
			fputcsv($output, $valores, ';');

		} 

	 
	} else{ ?>

	<div class="container">

		<?php if($_POST['modelo_impressao'] == 'tela' ): ?>
		<div class="page-header hidden-print">
	        <h1>
	            Inscrições <small>Relatório</small>
	        </h1>
	    </div>
		<?php endif ?>

	<?php if( $_POST['modelo_exibicao'] == 'bloco' ): ?>

		<?php while( $registro = $c->fetchAll() ): ?>

			<table class="table table-hover">
			 	<?php if(in_array('tema', $_POST['campos'])): ?>
			        <tr>
			            <th width="180">
			                Tema
			            </th>
			            <td>
			                <?php echo $registro->titulo ?>
			            </td>
			        </tr>
		    	<?php endif; ?>
		    	<?php if(in_array('descricao', $_POST['campos'])): ?>
			        <tr>
			            <th>
			                Descrição
			            </th>
			            <td>
			                <?php echo nl2br(strip_tags($registro->descricao)) ?>
			            </td>
			        </tr>
		   		<?php endif; ?>
		   		<?php if(in_array('projeto_referencia', $_POST['campos'])): ?>
			        <tr>
			            <th>
			                Projeto de referência
			            </th>
			            <td>    
			                <?php 
			                    $p = new CRUD('projeto');
			                    $projeto = $p->findOneById($registro->id_projeto)->executeQuery()->fetchAll();
			                ?>
			                <?php echo $projeto->titulo; ?>
			            </td>
			        </tr>
		    	<?php endif; ?>
		    	<?php if(in_array('orientador', $_POST['campos'])): ?>
			        <tr>
			            <th>
			                Orientador
			            </th>
			            <td>    
			                <?php 
			                    $o = new CRUD('usuario');
			                    $orientador = $o->findOneById($registro->id_orientador)->executeQuery()->fetchAll();
			                ?>
			                <?php echo $orientador->nome; ?>
			            </td>
			        </tr>
		    	<?php endif; ?>
		    	<?php $a = new CRUD('usuario'); ?>
		    	<?php if(in_array('aluno1', $_POST['campos'])): ?>
			        <tr>
			            <th>
			                Aluno 1
			            </th>
			            <td>    
			                <?php 
			                    $aluno1 = $a->findOneById($registro->id_aluno1)->executeQuery()->fetchAll();
			                ?>
			                <?php echo $aluno1->nome; ?> ( <?php echo $aluno1->matricula; ?> )
			            </td>
			        </tr>
		   		<?php endif; ?>
		       	<?php if(in_array('aluno2', $_POST['campos'])): ?>
			        <?php if($registro->id_aluno2): ?>
				        <tr>
				            <th>
				                Aluno 2
				            </th>
				            <td>    
				                <?php
				                    $aluno2 = $a->clearQuery()->findOneById($registro->id_aluno2)->executeQuery()->fetchAll();
				                    echo $aluno2->nome . " ( " . $aluno2->matricula . " ) ";
				                ?>
				            </td>
				        </tr>
			        <?php endif ?>
		    	<?php endif; ?>
		    	<?php if(in_array('turma', $_POST['campos'])): ?>
		        <tr>
		            <th>
		                Turma
		            </th>
		            <td>    
		                <?php 
		                    $t = new CRUD('turma');
		                    $turma = $t->findOneById($registro->id_turma)->executeQuery()->fetchAll();
		                ?>
		                <?php echo $turma->sigla; ?>
		            </td>
		        </tr>
		   		<?php endif; ?>
		   		<?php if(in_array('semestre', $_POST['campos'])): ?>
			        <tr>
			            <th>
			                Semestre
			            </th>
			            <td>    
			                <?php echo $registro->semestre; ?>
			            </td>
			        </tr>
		    	<?php endif; ?>
		    	<?php if(in_array('created_at', $_POST['campos'])): ?>
			        <tr>
			            <th>
			                Criado em
			            </th>
			            <td>
			                <?php echo $h->dateTimeFromDB($registro->created_at) ?>
			            </td>
			        </tr>
		    	<?php endif; ?>
		    	<?php if(in_array('updated_at', $_POST['campos'])): ?>
			        <tr>
			            <th>
			                Modificado em
			            </th>
			            <td>
			               <?php echo $h->dateTimeFromDB($registro->updated_at) ?>
			            </td>
			        </tr>
		    	<?php endif; ?>
		    	<?php if(in_array('situacao', $_POST['campos'])): ?>
			        <tr>
			            <th>
			                Situação
			            </th>
			            <td>
			                <?php 
			                    $s = new CRUD('situacao');
			                    $situacao = $s->findOneById($registro->id_situacao)->executeQuery()->fetchAll();
			                ?>
			                <?php echo $situacao->valor;?>
			            </td>
			        </tr>
			    	<?php endif; ?>
		    </table>
		    
		<?php endwhile; ?>

	<?php else: ?>

		<table class="table table-hover table-striped">
		    <tr>
		    	<?php if(in_array('tema', $_POST['campos'])): ?>
		   			<th>Tema</th>
		   		<?php endif; ?>
		   		<?php if(in_array('descricao', $_POST['campos'])): ?>
		     		<th>Descrição</th>
		     	<?php endif; ?>
		     	<?php if(in_array('projeto_referencia', $_POST['campos'])): ?>
		      		<th>Projeto de referência</th>
		    	<?php endif; ?>
		    	<?php if(in_array('orientador', $_POST['campos'])): ?>
		      		<th>Orientador</th>
		      	<?php endif; ?>
		      	<?php if(in_array('aluno1', $_POST['campos'])): ?>
		      		<th>Aluno 1</th>
		      	<?php endif; ?>
		      	<?php if(in_array('aluno2', $_POST['campos'])): ?>
		      		<th>Aluno 2</th>
		      	<?php endif; ?>
		      	<?php if(in_array('turma', $_POST['campos'])): ?>
		      		<th>Turma</th>
		      	<?php endif; ?>
		      	<?php if(in_array('semestre', $_POST['campos'])): ?>
		      		<th>Semestre</th>
		      	<?php endif; ?>
		      	<?php if(in_array('created_at', $_POST['campos'])): ?>
		      		<th>Data criação</th>
		     	<?php endif; ?>
		      	<?php if(in_array('updated_at', $_POST['campos'])): ?>
		     		<th>Data atualização</th>
		     	<?php endif; ?>
		     	<?php if(in_array('situacao', $_POST['campos'])): ?>
		     		<th>Situação</th>
		     	<?php endif; ?>
		    </tr>

		    <?php while( $registro = $c->fetchAll() ): ?>
		    <tr>
		    	<?php if(in_array('tema', $_POST['campos'])): ?>
		      	<td><?php echo $registro->titulo ?></td>
		      <?php endif; ?>
		      <?php if(in_array('descricao', $_POST['campos'])): ?>
		      	<td><?php echo $registro->descricao ?></td>
	   			<?php endif; ?>
	   			<?php if(in_array('projeto_referencia', $_POST['campos'])): ?>
			      <td>
			      	 <?php 
		                $p = new CRUD('projeto');
		                $projeto = $p->findOneById($registro->id_projeto)->executeQuery()->fetchAll();
		            ?>
		            <?php echo $projeto->titulo; ?>
			      </td>
			    <?php endif; ?>
					<?php if(in_array('orientador', $_POST['campos'])): ?>
			      <td>
			      	<?php 
			            $o = new CRUD('usuario');
			            $orientador = $o->findOneById($registro->id_orientador)->executeQuery()->fetchAll();
			        ?>
			        <?php echo $orientador->nome; ?>
			      </td>
		    	<?php endif; ?>
		      <?php
		        $crudAlunos = new CRUD('usuario');
		        $aluno1 = $crudAlunos->findOneById($registro->id_aluno1)->executeQuery()->fetchAll();
		        
		        if( $registro->id_aluno2 )
		        {
		          $aluno2 = $crudAlunos->clearQuery()->findOneById($registro->id_aluno2)->executeQuery()->fetchAll();
		        }
		      ?>
					<?php if(in_array('aluno1', $_POST['campos'])): ?>
		     		<td><?php echo $aluno1->nome . ' ('.$aluno1->matricula.')' ?></td>
		     	<?php endif; ?>
		     	<?php if(in_array('aluno2', $_POST['campos'])): ?>
		      	<td><?php echo $aluno2->nome . ' ('.$aluno2->matricula.')' ?></td>
		      <?php endif; ?>
		      <?php 
		        $crudTurma = new CRUD('turma');
		        $turma = $crudTurma->findOneById($registro->id_turma)->executeQuery()->fetchAll();
		      ?>
		      <?php if(in_array('turma', $_POST['campos'])): ?>
		      	<td><?php echo $turma->sigla ?></td>
		      <?php endif; ?>
		      <?php if(in_array('semestre', $_POST['campos'])): ?>
		      	<td><?php echo $registro->semestre ?></td>
		      <?php endif; ?>
		      <?php if(in_array('created_at', $_POST['campos'])): ?>
		      	<td><?php echo $h->dateTimeFromDB($registro->created_at) ?></td>
		      <?php endif; ?>
		      <?php if(in_array('updated_at', $_POST['campos'])): ?>
		      	<td><?php echo $h->dateTimeFromDB($registro->updated_at) ?></td>
		      <?php endif; ?>
		      <?php if(in_array('situacao', $_POST['campos'])): ?>
	          <td>
	          <?php 
	              $s = new CRUD('situacao');
	              $situacao = $s->findOneById($registro->id_situacao)->executeQuery()->fetchAll();
	          ?>
	          <?php echo $situacao->valor;?>
	        	</td>
					<?php endif; ?>
		    </tr>

		    <?php endwhile; ?>
		  
		</table>

	<?php endif; ?>

	</div>

<?php } ?>

<?php if($_POST['modelo_impressao'] != 'csv' ): ?>
	<?php  $project->partial('admin', 'footer');  ?>
<?php endif; ?>

<?php if($_POST['modelo_impressao'] == 'impressao' ): ?>
	<script>
        var document_focus = false;
        $(document).ready(function() {
    		window.print();document_focus = true;
    	});
        setInterval(function() {
        	if (document_focus === true) {
        		window.close();
        	}  
        }, 300);
	</script>
<?php endif; ?>