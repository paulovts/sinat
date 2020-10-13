/**************************** validad campos do cadastro de usuario***********************************/
$(document).ready(function() {

    $('#formularioModal').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        locale: 'pt_BR',
        fields: {            
			aceiteTermo: {
                validators: {
                    notEmpty: {
                            message: 'Selecione o aceite para visualizar as fichas.'
                        }
                }
            }
        }
    }).on('success.form.fv', function(e) {
            // The e parameter is same as one
            // in the prevalidate.form.fv event above
			
			e.preventDefault(); // Previne o envio normal para conseguir enviar a caixa mostrando que o responsável foi cadastrado com  sucesso
			
			
			//alert('email: ' + emailUsuario);
			var $form = $(e.target),        // The form instance
                fv    = $(e.target).data('formValidation'); // FormValidation instance
            // Do something ...
				
				fv.defaultSubmit(); // Retoma o envio normal para continuar para o Cadastro do usuario					  		
        
    });

}); // FIM DO DOCUMENT READY

/**************************** povoar combo municipio ao escolher estado***********************************/
$("#estado").on('change', function() {
	var UF = $("#estado").val();
	
	// AJAX para mudar o campo de TIPO
	$.ajax({
		url: "../controles/buscarMunicipio.php?UF="+UF+"", //URL de destino
		dataType: "json", //Tipo de Retorno
		success: function(resultado){ //Se ocorrer tudo certo
			var novoHtml = '<option value=""></option>';
			for ( n = 0; n < resultado.length; n++){
				novoHtml += '<option value ="' + resultado[n][0] + '">' + resultado[n][1] + '</option>';
			}
			// Atualizar o HTML do TIPO		
			$('#municipio').html(novoHtml);	
		}				
	
	});
		
});

/**************************** retirar a class hiddem dependedo da escolha do tipo de usuário***********************************/

$('#tipoUsuario').on('change', function() {
	var tipoUsuario = $('#tipoUsuario').val();
	if(tipoUsuario==1){
		$('#dadosEmpresa').addClass('hide');
		$('#dadosContato').removeClass('hide');
		$('#btnCadUsuario').removeClass('hide');
		$('#nomeContato').focus();
	}else if(tipoUsuario==2){
		$('#dadosEmpresa').removeClass('hide');
		$('#dadosContato').removeClass('hide');
		$('#btnCadUsuario').removeClass('hide');
		$('#nomeContato').focus();
	}else{
		$('#dadosContato').addClass('hide');
		$('#dadosEmpresa').addClass('hide');
		$('#btnCadUsuario').addClass('hide')		
	}
	
	
});

/**************************** visualizar o campo especifique***********************************/
$('#areaAtuacao').on('change',function(){
	
	var areaAtuacao = $('#areaAtuacao').val();
	//alert('areaAtuacao: ' + areaAtuacao);
	if(areaAtuacao == 7){
		$('#divEspecifique').removeClass('hide');
		$('#especifique').focus();	
	}else{
		$('#divEspecifique').addClass('hide');
	}
	
});

