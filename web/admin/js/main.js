$(document).ready(function(){

	 $('[data-toggle="tooltip"]').tooltip();

	 // Ajax loader
	$( document ).ajaxStart(function(){
		$('body').append('<i class="ajax-loader"></i>');
	});

	$( document ).ajaxComplete(function(){
		$('body').find('.ajax-loader').remove();
	});

	if( $('#tags').length ){
		$('#tags').tagsInput({width:'auto', 'defaultText':'Clique para digitar'});
	}

	// Botões cadastros
	$('.btn-new-curso').on('click', function(e){
		e.preventDefault();
		$obj = $('.field-curso').first().clone(true);
		$('.field-curso').last().after($obj);
		$obj.find('select').val('');
	});

	$('.btn-delete-curso').on('click', function(e){
		e.preventDefault();
		if( $('.field-curso').size() > 1 )
			$(this).closest('.field-curso').remove();
	});

	$('.btn-new-turma').on('click', function(e){
		e.preventDefault();
		$obj = $('.field-turma').first().clone(true);
		$('.field-turma').last().after($obj);
		$obj.find('select').val('');
	});

	$('.btn-delete-turma').on('click', function(e){
		e.preventDefault();
		if( $('.field-turma').size() > 1 )
			$(this).closest('.field-turma').remove();
	});


	$('.btn-new-professor').on('click', function(e){
		e.preventDefault();
		$obj = $('.field-professor').first().clone(true);
		$('.field-professor').last().after($obj);
		$obj.find('select').val('');
	});

	$('.btn-delete-professor').on('click', function(e){
		e.preventDefault();
		if( $('.field-professor').size() > 1 )
			$(this).closest('.field-professor').remove();
	});


	// Ajax Cadastros
	$('#id_turma').on('change', function(){
		var id_turma = $(this).val();
		var $select_projeto = $('#id_projeto');

		if( id_turma > 0 )
		{
			$.ajax({
			  type: "POST",
			  url: base + "admin/projetos/jsonByTurma",
			  data: { id_turma: id_turma }
			})
			  .done(function( data ) {

			  		$select_projeto.find('option').remove().end().append( $('<option>', {value : "", text : "Selecione o projeto"}));

			    	$.each( data, function( i, item ) {

			    		$select_projeto.append($('<option>', { 
					        value: item.id,
					        text : item.titulo 
					    }));

					});

			    	$select_projeto.removeClass('disabled');
			  });
		}else{
			$select_projeto.addClass('disabled');
		}

	});

	$('#id_projeto').on('change', function(){
		var id_projeto = $(this).val();
		var $select_orientador = $('#id_orientador');

		if( id_projeto > 0 )
		{
			$.ajax({
			  type: "POST",
			  url: base + "admin/professores/jsonByProjeto",
			  data: { id_projeto: id_projeto }
			})
			  .done(function( data ) {

			  		$select_orientador.find('option').remove().end().append( $('<option>', {value : "", text : "Selecione o orientador"}));

			    	$.each( data, function( i, item ) {

			    		$select_orientador.append($('<option>', { 
					        value: item.id,
					        text : item.nome 
					    }));

					});

			    	$select_orientador.removeClass('disabled');
			  });
		}else{
			$select_orientador.addClass('disabled');
		}

	});

	$('.btn-find-aluno').on('click', function(){
		var $wrapper = $(this).closest('.aluno-wrapper');
		var matricula = $wrapper.find('.aluno-matricula').val();
		
		if( matricula != '' )
		{
			$.ajax({
			  type: "POST",
			  url: base + "admin/alunos/jsonByMatricula",
			  data: { aluno_matricula: matricula }
			})
			  .done(function( data ) {
			  	if(!data)
			  	{
			  		alert('Aluno não encontrado!');
		  			$wrapper.find('.aluno-id').val('');
						$wrapper.find('.aluno-nome').val('');
			  	}else{
			  		$wrapper.find('.aluno-id').val( data.id );
			  		$wrapper.find('.aluno-nome').val( data.nome );
			  	}

			  });
		}else{
			$wrapper.find('.aluno-id').val('');
  			$wrapper.find('.aluno-nome').val('');
		}

	});

	$('.btn-remove-aluno').on('click', function(){
		var $wrapper = $(this).closest('.aluno-wrapper');
		
		$wrapper.find('.aluno-id').val('');
		$wrapper.find('.aluno-nome').val('');
		$wrapper.find('.aluno-matricula').val('');

	});

	$('.table .btn-danger').on('click', function(e){
		if( !confirm("Deseja mesmo remover o registro?") )
		{
			e.preventDefault();
		}
	});

	$('.inscricao-action').on('click', function(){
		situacao_id = $(this).data('situacao-id');
		situacao_nome = $(this).data('situacao-nome');

		$('#inscricao-situacao-nome').html(situacao_nome);
		$('#id_situacao').val(situacao_id);
	});

	$('form').each(function(){
		$(this).validate({
			invalidHandler: validateInvalidHandlers,
			highlight: function (element, errorClass, validClass) {
            	$(element).closest('.form-group').addClass('has-error');
	        },
	        unhighlight: function (element, errorClass, validClass) {
	           $(element).closest('.form-group').removeClass('has-error');
	        }
		});
	});

    $('.modal.auto').modal('show');
});


var isDevice = function(device){

	if( device == 'phone' )
		return $(window).width() < 768;

	if( device == 'tablet' )
		return $(window).width() >= 768 && $(window).width() <= 979;

	if( device == 'desktop' )
		return $(window).width() >= 980;

	return false;
}

function validateInvalidHandlers(event, validator) {

	name = validator.errorList[0].element.name.replace('[', '\\[').replace(']', '\\]');

	if( isDevice('phone') ){
		var offset = $('[name="' + name + '"]').offset();
		$('html, body').animate({
			scrollTop: (offset.top - 100)
		}, 1000);
	}

}

function ajaxLoader()
{
	this.init = function(){
		$('body').on('ajaxStart', this.showLoader);
		$('body').on('ajaxEnd', this.showLoader);
	}

	this.showLoader = function(){}
	this.hideLoader = function(){}
}