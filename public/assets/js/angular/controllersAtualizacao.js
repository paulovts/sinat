angular.module('myApp')

.controller('fichasAtualizacao', ['$scope', '$http', function ($scope, $http) {
	$scope.fichas = '';
	var cod_usuario = $('#frmEscolhaSistem').attr('data-nome');
	
	
		
	$http.get('../arquivosJSON/json_fichas_atualizacao.php?codUsuario='+cod_usuario).success(function(data) {
			$scope.fichas = data;
			$scope.ordem = 'tipo_ficha';
			//console.dir($scope.fichas);
			$scope.existeFicha = '';
			$scope.fichasDesatualizadas = [];
		console.dir($scope.fichasDesatualizadas);
		for(var i = 0 ; i < $scope.fichas.length; i++){
			if($scope.fichas[i].bln_atualizar == 1){
				$scope.fichasDesatualizadas.push($scope.fichas[i]);
			}

			
		}
			
			if($scope.fichasDesatualizadas.length>0){
					$scope.existeFicha = true;	
									
				}
		//acionar modal no botao	
		$scope.buscarDadosAtualizacao = function(codUsuario){
			$http.get('../arquivosJSON/json_fichas_atualizacao.php?codUsuario='+codUsuaio).success(function(data) {
			$scope.fichas = data;
			$scope.ordem = 'tipo_ficha';
			//console.dir($scope.fichas);
		}); //primeiro $http
	};	
		//funcao salvar dados do download
	$scope.countDownloadFichas = function(tipo_ficha, num_ficha, idUsuario) {
		
			var nomePasta = '';
			if(tipo_ficha == 'Convencional'){
				nomePasta = 'cadDownloadCatConvencional';
			}else if(tipo_ficha == 'Diretriz'){
				nomePasta = 'cadDownloadDiretriz';
			}if(tipo_ficha == 'Datec'){
				nomePasta = 'cadDownloadCatDatec';
			}
			
			//salvar dados do download no banco
			$http.get('../controles/' + nomePasta + '.php?numero='+num_ficha+'&idUsuario='+idUsuario+'').success(function(result){
				
			});//segundo $http
			
		
			for(var i = 0 ; i < $scope.fichasDesatualizadas.length; i++){
				if($scope.fichasDesatualizadas[i].cod_ficha_pk == num_ficha){
					$scope.fichasDesatualizadas.splice(i,1);//retira um elemento
					
				}

							
			}
			
			if($scope.fichasDesatualizadas.length==0){
					$scope.existeFicha = false;					
				}
				
			console.dir($scope.fichasDesatualizadas);
	};//funcao countDownload
		
	
		
		
		//console.dir($scope.fichasDesatualizadas);
		
		}); //primeiro $http
	
	
	
}]); // o "]" protege as variáveis de serem minificadas, que pode gerar um erro no programa (lynda.com).
