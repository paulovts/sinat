var postApp = angular.module('postApp', []);
    // Controller function and passing $http service and $scope var.
    postApp.controller('controlCadNovoConv', function($scope, $http) {
      // create a blank object to handle form data.
        $scope.opcSistema = {};
      // calling our submit function.
        $scope.cadastrarSistema = function() {
        // Posting data to php file
        $http({
          method  : 'POST',
          url     : 'cadSistema.php',
          data    : $scope.opcSistema, //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         })
          .success(function(data) {
            if (data.dadosSistema) {
              // Showing errors.
    			alert("entrou aqui");        
   	   		    alert("Retorno form cadSIstema.php: " + data.dadosSistema.nomeSistema);
			  
            } else {
    			alert("message: " + data.message);        
            }
			
			
          });
        };
    });