var svc = angular.module('myApp.servicos',['ngResource']);

svc.factory('PhpServico', ['$resource', function($resource){
		
		return $resource('',null,{
			
			cadastrarSistema : {method: 'POST',url:'cadSistema.php', headers:{'Content-Type':'application/x-www-form-urlencoded'}}
		});
		alert('passou aqui servico 1');
	}
]);

