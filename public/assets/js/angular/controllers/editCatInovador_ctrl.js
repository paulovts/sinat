angular.module('myApp')
.controller('CatalogoInovadorAdm', ['$scope', '$http', function ($scope, $http) {
	
	$http.get('../../arquivosJSON/json_dados_catalogo_inovador.php').success(function(data) {
		$scope.catalogoInovador = data;
		
		console.dir(data);
		
				
		//Criar o catalogo Datec e colocar o jasonDatec l? dentro
		$scope.catalogoDatec =[];
		var countDatec = 0;
		for(var ind = 0; ind < data.length; ind++) {	
			for(var n = 0; n < data[ind].jsondatec.length; n++) {
				if (data[ind].jsondatec[n] != null) {
				$scope.catalogoDatec.push(data[ind].jsondatec[n]);
				$scope.catalogoDatec[countDatec].num_numero_diretriz = data[ind].num_numero_diretriz;
				countDatec++;
				}
				
			}
			//Deletar o jsonDatec do catalogo Inovador, previnindo o filtro buscar de encontrar numeros desnecess?os do cpnj do proponente
			delete $scope.catalogoInovador[ind].jsondatec;
		}
		
		
		
		//colocar o catalogoDatec em ordem alfabetica	
		$scope.catalogoDatec.sort(function(a, b) {
			return parseFloat(Number(a.num_ordem_ficha)) - parseFloat(Number(b.num_ordem_ficha));
		});
		
		$scope.ordem = 'numero';

		//colocar o catalogoDatec em ordem alfabetica	
		$scope.catalogoInovador.sort(function(a, b) {
			return parseFloat(Number(a.num_numero_diretriz)) - parseFloat(Number(b.num_numero_diretriz));
		});
		
		$scope.ordem = 'numero';

		//Crias a datec Vinculadas de acordo com as diretrizes
		$scope.datecVinculadas = [];
		for(var ind = 0 ; ind < $scope.catalogoDatec.length; ind++){
			 var codDiretriz = ind + 1;
			 $scope.datecVinculadas[codDiretriz] = [];
			for(var n = 0; n < $scope.catalogoDatec.length; n++){
				if(codDiretriz == $scope.catalogoDatec[n].cod_diretriz){
					$scope.datecVinculadas[codDiretriz] += $scope.catalogoDatec[n].num_ordem_ficha + ';';					
				}	
			}
		}
		
		//Colocar as Datec vinculadas dentro do Catalogo Inovador;
		for(var i = 0; i < $scope.catalogoInovador.length; i++){
			$scope.catalogoInovador[i].num_ordem_ficha = "";
			if ($scope.datecVinculadas[i+1].length != 0){
				$scope.catalogoInovador[i].num_ordem_ficha = $scope.datecVinculadas[i+1]; //num_ordem_fica serve para manter o mesmo nome que existe no $scope da diretriz, para filtrar ambas as tabelas ao mesmo tempo
			}
		}
		console.dir($scope.catalogoInovador);
		
		//Ao mudar a Diretriz, escolher todas as Datecs
		$scope.mudarDiretriz = function (){
			$scope.datec = "";
		
		};
		
		//Ao mudar a Diretriz, escolher todas as Datecs
		$scope.mudarDatec = function (){
			$scope.diretriz = "";
		
		};
		
		
		//Retornar o valor identical.
		$scope.identical = function(actual, expected){
			if ( expected == "") {
				return identical = actual;
			} else {
				return actual === parseInt(expected);
			}
		}
		


		$scope.editarDiretriz = function(dadosItemDiretriz, idUsuario) {
			$scope.itemDadosDiretriz = dadosItemDiretriz;
			console.dir(dadosItemDiretriz);
			$scope.habilitarDesc = true;
			$scope.abrirRevisao = false;
	};//fim editarFicha	

	}); //final get
	
		



	$scope.revisarDiretriz = function(itemRevisado) {
		$scope.abrirRevisao = true;
		$scope.habilitarDesc = false;
		$scope.revisaoDiretriz = itemRevisado;
		$scope.numUltRevisao = $scope.revisaoDiretriz.num_ultima_revisao+1;


	};//fim revisarFicha

	
}]); // o "]" protege as vari?is de serem minificadas, que pode gerar um erro no programa (lynda.com).