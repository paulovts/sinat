/**************************** validad campos do cadastro de usuario***********************************/
$(document).ready(function() {

    $('#formularioUsuario').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        locale: 'pt_BR',
        fields: {
			tipoUsuario: {
                validators: {
                    notEmpty: {
                            message: 'Escolha o tipo de usu√°rio'
                        }					
                }
            },
            nome: {
                validators: {
                    notEmpty: {
                            message: 'Digite o nome do usu&aacute;rio'
                        },
					stringLength: {
							 max:30,
							 message: 'Por favor digite at&eacute; 30 caracteres'
                    }
                }
            },
			sobrenome: {
                validators: {
                    notEmpty: {
                            message: 'Digite o sobrenome do usu&aacute;rio'
                        },
					stringLength: {
							 max:30,
							 message: 'Por favor digite at&eacute; 30 caracteres'
                    }
                }
            },
			cargo: {
                validators: {
                    notEmpty: {
                            message: 'Digite o cargo do usu&aacute;rio'
                        },
					stringLength: {
							 max:30,
							 message: 'Por favor digite at&eacute; 30 caracteres'
                    }
                }
            },
			areaAtuacao: {
                validators: {
                    notEmpty: {
							 message: 'Selecione um &Aacute;rea de atua&ccedil;&atilde;o'
                    }
                }
            },
			estado: {
                validators: {
                    notEmpty: {
                            message: 'Selecione um UF.'
                        }
                }
            },
			municipio: {
                validators: {
                    notEmpty: {
                            message: 'Selecione um Munic&iacute;pio'
                        }
                }
            },
			email: {
                validators: {
                    notEmpty: {
                            message: 'Digite o email do usu&aacute;rio'
                        },
					stringLength: {
							 max:50,
							 message: 'Por favor digite at&eacute; 50 caracteres'
                    },
					emailAddress: {
							 message: 'Por favor digite um email v&aacute;lido'
                    }
                }
            },
			ddd: {
                validators: {
                    digits: {
						message: 'Apenas num&eacute;ros'
                    },
					stringLength: {
							min:3,
							max:3,
							message: 'Digite os 3 d&iacute;gitos'
                    }
					
                }
            },
			telefone: {
                validators: {
                    phone: {
						country: 'BR',
						message: 'N&eacute;mero inv&aacute;lido'
					}
                }
            },
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
			cnpj: {
                validators: {
                    notEmpty: {
							 message: 'Por favor digite os 14 digitos do cnpj'
                    },
					stringLength: {
							 min: 14,
							 max:14,
							 message: 'Por favor digite os 14 digitos do cnpj'
                    },
					cnpjReceita: {
							message: 'N&uacute;mero de CNPJ inv&aacute;lido'
                    }
                }
            },
			razaoSocial: {
                validators: {
                    notEmpty: {
                            message: 'Digite a Raz&atilde;o Social da empresa'
                        },
					stringLength: {
							 max:100,
							 message: 'Por favor digite at&eacute; 100 caracteres'
                    }
                }
            },
			cep: {
                validators: {
                    notEmpty: {
                            message: 'Digite o CEP da empresa'
                        },
					stringLength: {
							 max:14,
							 message: 'Por favor digite at&eacute; 8 caracteres'
                    }
                }
            },
			endereco: {
                validators: {
                    notEmpty: {
                            message: 'Digite o endere&ccedil;o da empresa'
                        },
					stringLength: {
							 max:150,
							 message: 'Por favor digite at&eacute; 150 caracteres'
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
            },
			especifique: {
                validators: {
                    notEmpty: {
                            message: 'Digite a especifica&ccedil;&atilde;o da outra &aacute;rea de atua&ccedil;&atilde;o da empresa'
                        },
					stringLength: {
							 max:150,
							 message: 'Por favor digite at&eacute; 150 caracteres'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e) {
            // The e parameter is same as one
            // in the prevalidate.form.fv event above
			
			e.preventDefault(); // Previne o envio normal para conseguir enviar a caixa mostrando que o respons·vel foi cadastrado com  sucesso
			
			var cpfUsuario = $('#cpf').val();
			//alert('email: ' + emailUsuario);
			var $form = $(e.target),        // The form instance
                fv    = $(e.target).data('formValidation'); // FormValidation instance
            // Do something ...
			$.get("../controles/consultarUsuario.php?cpfUsuario="+cpfUsuario+"", function(resultado){
				
			if(resultado == 0){
				
				fv.defaultSubmit(); // Retoma o envio normal para continuar para o Cadastro do usuario					  
				
			}else if(resultado == 1){
				bootbox.dialog({
						  closeButton: false,
						  message: "J&aacute; existe um Usu&aacute;rio com este CPF cadastrado no sistema.  Favor cadastrar outro CPF.",
						  title: "Usu&aacute;rio j&aacute; existe",
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

/**************************** retirar a class hiddem dependedo da escolha do tipo de usu·rio***********************************/

$('#tipoUsuario').on('change', function() {
	var tipoUsuario = $('#tipoUsuario').val();
	if(tipoUsuario==1){
		$('#dadosEmpresa, #especifique').addClass('hide');
		$('#dadosContato').removeClass('hide');
		$('#btnCadUsuario').removeClass('hide');
		$('#nomeContato').focus();
		$('#especifique, #dadosEmpresa, #cnpj, #razaoSocial, #cep, #endereco, #areaAtuacao').val("");
		$('#cargoProfissao').text("Profiss√£o");
		$('#cargo').attr('placeholder', 'Arquiteto');
	}else if(tipoUsuario==2){
		$('#dadosEmpresa').removeClass('hide');
		$('#dadosContato').removeClass('hide');
		$('#btnCadUsuario').removeClass('hide');
		$('#nomeContato').focus();
		$('#cargoProfissao').text("Cargo");
		$('#cargo').attr('placeholder', 'Gerente');
	}else{
		$('#dadosContato, #especifique').addClass('hide');
		$('#dadosEmpresa').addClass('hide');
		$('#btnCadUsuario').addClass('hide')		
	}
	
	
});

/**************************** visualizar o campo especifique***********************************/
$('#areaAtuacao').on('change',function(){
	
	var areaAtuacao = $('#areaAtuacao').val();
	//alert('areaAtuacao: ' + areaAtuacao);
	if(areaAtuacao == 6){
		$('#divEspecifique').removeClass('hide');
		$('#especifique').focus();	
	}else{
		$('#divEspecifique').addClass('hide');
	}
	
});

