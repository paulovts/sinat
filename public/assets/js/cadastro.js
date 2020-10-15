angular.module('myApp', ['ngAnimate'])
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
        templateUrl: 'cadastro/inovadores',
        controller: function CadastroInovadoresController($scope, $http) {
            // this.submit = function (event) {
            //     const data = new FormData(event.target.closest('form'))
            // }
        }
    })
    .component('cadastroConvencional', {
        templateUrl: 'cadastro/convencional',
        controller: function CadastroConvencionalController($scope, $http) {
            $scope.sistema = "";
            $scope.solucao = "";

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

            $http({
                method: 'GET',
                url: '/sistema/lista'
            }).then(function successCallback(response) {
                $scope.listaSistema = {
                    model: null,
                    options: response.data
                };

                console.log($scope.listaSistema);
            }, function errorCallback(response) {

            });

            $scope.mudaSolucao = function (id) {
                let params = {'sistema': id};
                $http.get('/solucao/lista', {params}).then(function (response) {
                    $scope.listaSolucao = {
                        model: null,
                        options: response.data
                    };
                });
            }


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