
angular.module('myApp')
	.controller('editCatConvencional_ctrl', ['$scope', '$http', function ($scope, $http) {
		console.log('entrou');
		$scope.editar = {

			ficha: function(numero, idUsuario) {
				//editar dados do download no banco
				console.log(numero);
				console.log(idusuario);		
			}//funcao editarFicha
		};



}]);  