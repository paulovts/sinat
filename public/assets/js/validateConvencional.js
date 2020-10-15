/**************************** validad campos do cadastro de usuario***********************************/
$(document).ready(function () {

    $('#formularioConvencional').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        locale: 'pt_BR',
        fields: {
            tiposistema: {
                validators: {
                    notEmpty: {
                        message: 'Escolha o tipo de Sistema'
                    }
                }
            }
        }
    }).on('success.form.fv', function (e) {
        // The e parameter is same as one
        // in the prevalidate.form.fv event above
        e.preventDefault();
    });

}); // FIM DO DOCUMENT READY

