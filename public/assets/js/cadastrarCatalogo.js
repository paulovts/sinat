
/**************************** povoar combo Solução ao escolher sistema***********************************/
$("#comboSistema").on('change', function() {
	
	var codSistema = $("#comboSistema").val();
	var novoHtml = '<option value="">Escolha</option>';
			$('#comboSolucao').html(novoHtml);
			$('#comboTipoSolucao').html(novoHtml);
			$('#descricaoSolucao').text('');
	// AJAX para mudar o campo de TIPO
	$.ajax({
		url: "../../controles/buscarSolucao.php?codSistema="+codSistema+"", //URL de destino
		dataType: "json", //Tipo de Retorno
		success: function(resultado){ //Se ocorrer tudo certo
			
			for ( n = 0; n < resultado.length; n++){
				novoHtml += '<option value ="' + resultado[n][0] + '">' + resultado[n][1] + ' - ' + resultado[n][2] + '</option>';
			}
			// Atualizar o HTML do TIPO		
			$('#comboSolucao').html(novoHtml);	
		}				
	
	});
		
});

/**************************** povoar combo Solução ao escolher sistema***********************************/
$("#comboSolucao").on('change', function() {
	
	var codSolucao = $("#comboSolucao").val();
	var novoHtml = '<option value="">Escolha</option>';
	$('#comboTipoSolucao').html(novoHtml);
	$('#descricaoSolucao').text('');
	// AJAX para mudar o campo de TIPO
	$.ajax({
		url: "../../controles/buscarTipoSolucao.php?codSolucao="+codSolucao+"", //URL de destino
		dataType: "json", //Tipo de Retorno
		success: function(resultado){ //Se ocorrer tudo certo
			
			for ( n = 0; n < resultado.length; n++){
				novoHtml += '<option value ="' + resultado[n][0] + '">' + resultado[n][1] + ' - ' + resultado[n][2] + '</option>';
			}
			// Atualizar o HTML do TIPO		
			$('#comboTipoSolucao').html(novoHtml);
				
		}				
	
	});
		
});

/**************************** trazer da descricao da solucao***********************************/
$("#comboTipoSolucao").on('change', function() {
	
	var codTipoSolucao = $("#comboTipoSolucao").val();
	var descricaoSolucao = '';
	$('#descricaoSolucao').text(descricaoSolucao);

	// AJAX para mudar o campo de TIPO
	$.ajax({
		url: "../../controles/buscarDescricaoTipoSolucao.php?codTipoSolucao="+codTipoSolucao+"", //URL de destino
		dataType: "json", //Tipo de Retorno
		success: function(resultado){ //Se ocorrer tudo certo
			
			for ( n = 0; n < resultado.length; n++){
				descricaoSolucao += resultado[n][0];
			}
			// Atualizar o HTML do TIPO		
			$('#descricaoSolucao').text(descricaoSolucao);	
		}				
	
	});
		
});





