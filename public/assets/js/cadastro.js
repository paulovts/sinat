angular.module('myApp', ['ngAnimate', 'ngFlash'])
    .controller('CadastroController', ['$scope', '$http', 'Flash', function ($scope, $http, Flash) {
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
    }])
    .component('cadastroInovadores', {
        templateUrl: 'cadastro/inovadores',
        controller: function CadastroInovadoresController($scope, $http) {
            $scope.tipoSistemaInovadores = "";

            $scope.listaTipo = {
                model: null,
                options: [
                    {id: '', label: 'Selecione...'},
                    {id: '1', label: 'Diretriz'},
                    {id: '2', label: 'DATec'}
                ]
            };

        }
    })
    .component('cadastroConvencional', {
        templateUrl: 'cadastro/convencional',
        controller: function CadastroConvencionalController($scope, $http) {
            $scope.sistema = "";
            $scope.solucao = "";
            $scope.descricao = "";
            $scope.arquivo = [];
            $scope.tiposistemaconvencional = "";

            $http({
                method: 'GET',
                url: '/sistema/lista'
            }).then(function successCallback(response) {
                $scope.listaSistema = {
                    model: null,
                    options: response.data
                };
            }, function errorCallback(response) {

            });

            $scope.submit = function () {
                let formData = new FormData();

                let dateformat = new Date(this.dataemissao);

                let mesAtaual = dateformat.getMonth() + 1;
                if (mesAtaual < 10) {
                    mesAtaual = '0' + mesAtaual;
                }
                var datestring = dateformat.getFullYear() + "-" + mesAtaual + "-" + dateformat.getDate() + " ";
                formData.append('dte_data_inclusao', datestring);
                formData.append('cod_tipo_solucao', this.tiposistemaconvencional);
                formData.append('file', this.arquivo, this.arquivo.name);

                $http({
                    method: 'POST',
                    url: '/cadastro/convencional/save',
                    data: formData,
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
                }).then(function successCallback(response) {

                    if (response.data.status === false) {
                      alert('Arquivo já cadastrado no sistema!')
                    }else{
                        window.location = '/cadastro'
                    }

                }, function errorCallback(response) {

                });
            };


            $scope.mudaSolucao = function (id) {
                let params = {'sistema': id};
                $http.get('/solucao/lista', {params}).then(function (response) {

                    $scope.listaSolucao = {
                        model: null,
                        options: response.data
                    };
                });
            }

            $scope.prepareUpload = function (event) {
                this.arquivo = event.target.files[0];
            }


            $scope.adicionaDescricao = function (id) {
                $scope.descricao = this.listaTipoSolucao.options.find(function (element) {
                    return element.cod_tipo_solucao === parseInt(id);
                });
            }

            $scope.mudaTipoSolucao = function (id) {
                let params = {'id': id};
                $http.get('/tipo/lista', {params}).then(function (response) {
                    $scope.listaTipoSolucao = {
                        model: null,
                        options: response.data
                    };
                });
            }
        }
    })