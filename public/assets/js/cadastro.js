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
            $scope.visible = false;
            $scope.descricao = "";
            $scope.revisao = "";
            $scope.arquivoDiretriz = [];
            $scope.arquivoDatec = [];
            $scope.diretriz = '';

            $scope.listaTipo = {
                model: null,
                options: [
                    {id: '', label: 'Selecione...'},
                    {id: '1', label: 'Diretriz'},
                    {id: '2', label: 'DATec'}
                ]
            };
            $scope.escondecampos = function (id) {
                if (id === '1') {
                    this.visibleDiretriz = true;
                    this.visibleDatec = false;
                }
                if (id === '2') {
                    this.visibleDiretriz = false;
                    this.visibleDatec = true;
                }
            }

            $http({
                method: 'GET',
                url: '/sinat/diretriz/list'
            }).then(function successCallback(response) {
                $scope.listaDiretriz = {
                    model: null,
                    options: response.data
                };
            }, function errorCallback(response) {

            });

            $scope.prepareUpload = function (event) {
                this.arquivoDiretriz = event.target.files[0];
            }

            $scope.prepareUploadDatec = function (event) {
                this.arquivoDatec = event.target.files[0];
            }

            $scope.submitDiretriz = function () {
                let formData = new FormData();

                let dateformat = new Date(this.publicacaodiretriz);

                let mesAtaual = dateformat.getMonth() + 1;
                if (mesAtaual < 10) {
                    mesAtaual = '0' + mesAtaual;
                }
                var dateDiretriz = dateformat.getFullYear() + "-" + mesAtaual + "-" + dateformat.getDate() + " ";

                formData.append('txt_descricao_diretriz', this.descricao);
                formData.append('num_ultima_revisao', this.revisao);
                formData.append('file', this.arquivoDiretriz, this.arquivoDiretriz.name);
                formData.append('dte_data_pulicacao_diretriz', dateDiretriz);
                $http({
                    method: 'POST',
                    url: '/sinat/save/diretriz',
                    data: formData,
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
                }).then(function successCallback(response) {

                    if (response.data.status === false) {
                        alert('Arquivo já cadastrado no sistema!')
                    } else {
                        window.location = '/sinat/cadastro'
                    }

                }, function errorCallback(response) {

                });
            };

            $scope.submitDatec = function () {
                let formData = new FormData();

                let dateFormatPublicacao = new Date(this.publicacaodatec);
                let mesAtaualPublicacao = dateFormatPublicacao.getMonth() + 1;
                if (mesAtaualPublicacao < 10) {
                    mesAtaualPublicacao = '0' + mesAtaualPublicacao;
                }
                var datePublicacao = dateFormatPublicacao.getFullYear() + "-" + mesAtaualPublicacao + "-" + dateFormatPublicacao.getDate() + " ";

                let dateFormatValidade = new Date(this.validadedatec);

                let mesAtaualValidade = dateFormatValidade.getMonth() + 1;
                if (mesAtaualValidade < 10) {
                    mesAtaualValidade = '0' + mesAtaualValidade;
                }
                var dateValidade = dateFormatValidade.getFullYear() + "-" + mesAtaualValidade + "-" + dateFormatValidade.getDate() + " ";

                formData.append('txt_descricao_datec', this.descricaodatec);
                formData.append('dte_data_validade', dateValidade);
                formData.append('dte_data_emissao', datePublicacao);
                formData.append('cod_diretriz', this.diretrizassociada);
                formData.append('num_ordem_ficha', this.numerodatec);
                formData.append('txt_ultima_versao', this.versao);
                formData.append('file', this.arquivoDatec, this.arquivoDatec.name);

                $http({
                    method: 'POST',
                    url: '/sinat/save/datec',
                    data: formData,
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
                }).then(function successCallback(response) {
                    if (response.data.status === false) {
                        alert('Arquivo já cadastrado no sistema!')
                    } else {
                        window.location = '/sinat/cadastro'
                    }

                }, function errorCallback(response) {

                });
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
                url: '/sinat/sistema/lista'
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
                console.log('não pode entrar aqui')
                $http({
                    method: 'POST',
                    url: '/sinat/save/convencional',
                    data: formData,
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
                }).then(function successCallback(response) {

                    if (response.data.status === false) {
                        alert('Arquivo já cadastrado no sistema!')
                    } else {
                        window.location = '/sinat/cadastro'
                    }

                }, function errorCallback(response) {

                });
            };


            $scope.mudaSolucao = function (id) {
                let params = {'sistema': id};
                $http.get('/sinat/solucao/lista', {params}).then(function (response) {

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
                $http.get('/sinat/tipo/lista', {params}).then(function (response) {
                    $scope.listaTipoSolucao = {
                        model: null,
                        options: response.data
                    };
                });
            }
        }
    }).directive('restrictInput', [function () {

    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var ele = element[0];
            var regex = RegExp(attrs.restrictInput);
            var value = ele.value;

            ele.addEventListener('keyup', function (e) {
                if (regex.test(ele.value)) {
                    value = ele.value;
                } else {
                    ele.value = value;
                }
            });
        }
    };
}]);