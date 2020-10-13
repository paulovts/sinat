/**************************** validad campos do cadastro de usuario***********************************/
$(document).ready(function() {

    $('#formularioNovaSenha').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        locale: 'pt_BR',
        fields: {			
			senha: {
                validators: {
                    notEmpty: {
							 message: 'Por favor digite uma nova senha'
                    },
					stringLength: {
							min:6,
							max:20,
							message: 'Por favor digite de 6 a 20 caracteres'
                    }
                }
            },
			confirmaSenha: {
                validators: {
                    notEmpty: {
							 message: 'Por favor confirme sua senha'
                    },
                    identical: {
                        field: 'senha',
                        message: 'N&atilde;o confere com a senha'
                    }
                
                }
            },
			cpf: {
                validators: {
                    notEmpty: {
							 message: 'Por favor digite os 11 digitos do cpf'
                    },
					stringLength: {
							 min: 11,
							 max:11,
							 message: 'Por favor digite os 11 digitos do cpf'
                    },
					cpfReceita: {
							message: 'N&uacute;mero de CPF inv&aacute;lido'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e) {
            // The e parameter is same as one
            // in the prevalidate.form.fv event above
			
			e.preventDefault(); // Previne o envio normal para conseguir enviar a caixa mostrando que o respons?vel foi cadastrado com  sucesso
			
			var cpfUsuario = $('#cpf').val();
			//alert('email: ' + emailUsuario);
			var $form = $(e.target),        // The form instance
                fv    = $(e.target).data('formValidation'); // FormValidation instance
            // Do something ...
			$.get("../controles/consultarUsuario.php?cpfUsuario="+cpfUsuario+"", function(resultado){
			if(resultado == 1){
				
				fv.defaultSubmit(); // Retoma o envio normal para continuar para o Cadastro do usuario					  
				
			}else if(resultado == 0){
				bootbox.dialog({
						  closeButton: false,
						  message: "CPF não cadastrado no sistema.  Favor informar um CPF cadastrado.",
						  title: "CPF não existe",
						  buttons: {
							danger: {
							  label: "OK",
							  className: "btn-danger",
							  callback: function() {
								fv.resetForm();
								bootbox.hideAll();
							  }
							}
						  }
				});//bootbox.dialog
			}
		});	//$.get	
        
    });

}); // FIM DO DOCUMENT READY


