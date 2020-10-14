angular.module('cadastroApp', [])
    .controller('CadastroController', ['$scope', '$http', function ($scope, $http) {


        $scope.IsVisibleConvencionais = false;
        $scope.IsVisibleInovadores = false;
        $scope.data = {
            model: null,
            options: [
                {id: '', label: 'Selecione...'},
                {id: '1', label: 'Sistemas Convencionais'},
                {id: '2', label: 'Sistemas Inovadores'}
            ]
        };

        $scope.changeTipoSistema = function (id) {
            if (id === '1') {
                $scope.IsVisibleConvencionais = true;
                $scope.IsVisibleInovadores = false;
            }
            if (id === '2') {
                $scope.IsVisibleInovadores = true;
                $scope.IsVisibleConvencionais = false;
            }
        };
        console.log($scope.data);
    }])
    .component('cadastroInovadores', {
        templateUrl: '../Views/cadastro/inovadores.twig',
        controller: function CadastroInovadoresController($scope, $http) {
            // this.submit = function (event) {
            //     const data = new FormData(event.target.closest('form'))
            // }
        }
    })
    .component('cadastroConvencional', {
        templateUrl: '../Views/cadastro/convencional.twig',
        controller: function CadastroConvencionalController($scope, $http) {


            // this.submit = function (event) {
            //
            //     const data = new FormData(event.target.closest('form'));
            //
            //     let file = data.get('fileToUpload');
            //
            //     let formData = new FormData();
            //     formData.append('tiposistema', data.get('tiposistema'));
            //     formData.append('sistema', data.get('sistema'));
            //     formData.append('solucao', data.get('solucao'));
            //     formData.append('data', data.get('data-emissao'));
            //     formData.append('proponente', data.get('proponente'));
            //     formData.append('file', file, file.name);
            //     formData.append('descricao', data.get('descricao'));
            //
            //     $http({
            //         method: 'POST',
            //         url: '../controles/arquivoConvencional.php',
            //         data: formData,
            //         headers: {'Content-Type': 'multipart/form-data;boundary=----WebKitFormBoundaryyrV7KO0BoCBuDbTL'},
            //     }).then((response) => response);
            //
            // }

            // $http.get('../controles/buscarSistema.php', []).then(function (result) {
            //     $scope.listasistema = {
            //         model: null,
            //         options: result.data
            //     };
            // });
            // $scope.pesquisaSolucao = function (id) {
            //     let params = {'id': id};
            //     $http.get('../controles/buscarSolucao.php', {params}).then(function (result) {
            //         $scope.listasolucao = {
            //             model: null,
            //             options: result.data
            //         };
            //     });
            // }
        }
    })