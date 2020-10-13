/**************************** povoar combo Solução ao escolher sistema***********************************/
/*
$("#comboSistema").on('change', function() {
	
	var txt_sistema = $("#comboSistema").val();
	var novoHtml = '<option value="">Escolha</option>';
			$('#comboSolucao').html(novoHtml);
			$('#comboTipoSolucao').html(novoHtml);
			$('#descricaoSolucao').text('');
	// AJAX para mudar o campo de TIPO
	$.ajax({
		url: "../controles/buscarSolucao.php?txt_sistema="+txt_sistema+"", //URL de destino
		dataType: "json", //Tipo de Retorno
		success: function(resultado){ //Se ocorrer tudo certo
			
			for ( n = 0; n < resultado.length; n++){
				novoHtml += '<option value ="' + resultado[n][1] + '">' + resultado[n][1] + '</option>';
			}
			// Atualizar o HTML do TIPO		
			$('#comboSolucao').html(novoHtml);	
		}				
	
	});
		
});
*/

	


