$(document).ready(function () {
    console.log();
    enviarEmailAlteracao = function (email) {
        $.ajax({
            method: 'POST',
            url: '/',
            data: {
                email
            }
        })
    }

    // $('#formulario-modal').formValidation({
    //     framework: 'bootstrap',
    //     icon: {
    //         valid: 'glyphicon glyphicon-ok',
    //         invalid: 'glyphicon glyphicon-remove',
    //         validating: 'glyphicon glyphicon-refresh'
    //     },
    //     locale: 'pt_BR',
    //     fields: {
    //         emailEsqueci: {
    //             validators: {
    //                 notEmpty: {
    //                     message: 'Digite o email do usuario'
    //                 },
    //                 stringLength: {
    //                     max: 50,
    //                     message: 'Por favor digite at&eacute; 50 caracteres'
    //                 },
    //                 emailAddress: {
    //                     message: 'Por favor digite um email v&aacute;lido'
    //                 }
    //             }
    //         }
    //     }
    // }).on('success.form.fv', function (e) {
    //     // The e parameter is same as one
    //     // in the prevalidate.form.fv event above
    //
    //     e.preventDefault(); // Previne o envio normal para conseguir enviar a caixa mostrando que o respons?vel foi cadastrado com  sucesso
    //
    //     var emailEsqueci = $('#emailEsqueci').val();
    //     //alert('email: ' + emailUsuario);
    //     var $form = $(e.target),        // The form instance
    //         fv = $(e.target).data('formValidation'); // FormValidation instance
    //     // Do something ...
    //     $.get("/?email=" + emailEsqueci + "", function (resultado) {
    //
    //         if (resultado == 1) {
    //             bootbox.dialog({
    //                 closeButton: false,
    //                 message: "Acesse seu email e clique no link para alterar sua senha de acesso.",
    //                 title: "Email enviado",
    //                 buttons: {
    //                     success: {
    //                         label: "OK",
    //                         className: "btn-success",
    //                         callback: function () {
    //                             enviarEmailAlteracao(emailEsqueci)// Retoma o envio normal para continuar para a alteracao
    //                             bootbox.hideAll();
    //                         }
    //                     }
    //                 }
    //             });//bootbox.dialog
    //
    //         } else if (resultado == 0) {
    //             bootbox.dialog({
    //                 closeButton: false,
    //                 message: "O email informado não esta cadastrado no sistema.  Favor informar um email cadastrado.",
    //                 title: "Email inexistente",
    //                 buttons: {
    //                     danger: {
    //                         label: "OK",
    //                         className: "btn-danger",
    //                         callback: function () {
    //                             fv.resetForm();
    //                             bootbox.hideAll();
    //                         }
    //                     }
    //                 }
    //             });//bootbox.dialog
    //
    //         }
    //     });	//$.get
    //
    // });
}); // FIM DO DOCUMENT READY


//botao login
$('#login').click(function () {

    var senhaDigitada = $('#senha').val() + "";
    var usuarioDigitado = $('#usuario').val() + "";


    if (usuarioDigitado == "" && senhaDigitada == "") {
        $('#erroUsuario').removeClass('hide');
        $('#quebralinha1').removeClass('hide');
        $('#erroSenha').removeClass('hide');

    } else if (usuarioDigitado != "" && senhaDigitada == "") {
        $('#erroUsuario').addClass('hide');
        $('#erroSenha').removeClass('hide');
        $('#quebralinha1').removeClass('hide');
    } else if (usuarioDigitado == "" && senhaDigitada != "") {
        $('#erroUsuario').removeClass('hide');
        $('#erroSenha').addClass('hide');
        $('#quebralinha1').removeClass('hide');
    } else if (usuarioDigitado != "" && senhaDigitada != "") {
        $('#erroUsuario').addClass('hide');
        $('#erroSenha').addClass('hide');
        $('#quebralinha1').removeClass('hide');

        $.post("/api/login?usuario=" + usuarioDigitado + "&senha=" + senhaDigitada + "", function (resultado) {

            console.log(resultado);
            // if (resultado == 0) {
            //   bootbox.dialog({
            // 	  closeButton: false,
            // 	  message: "Usuário ou senha incorretos.",
            // 	  title: "Usuário inválido",
            // 	  buttons: {
            // 		danger: {
            // 		  label: "Ok",
            // 		  className: "btn-danger",
            // 		  callback: function() {
            // 			window.location.href = "src/seguranca/valida.php?usuario="+ usuarioDigitado +"&senha="+ senhaDigitada +"";
            // 		  }
            // 		}
            // 	  }
            // 	});
            // } else if (resultado == 1){
            // 	bootbox.dialog({
            // 	  closeButton: false,
            // 	  message: "Login realizado com sucesso.",
            // 	  title: "Bem Vindo",
            // 	  buttons: {
            // 		success: {
            // 		  label: "Ok",
            // 		  className: "btn-success",
            // 		  callback: function() {
            // 			window.location.href = "src/seguranca/valida.php?usuario="+ usuarioDigitado +"&senha="+ senhaDigitada +"";
            // 		  }
            // 		}
            // 	  }
            // 	});
            // }
        });
    }
}); 
