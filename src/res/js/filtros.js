(function(){
    
    var app = angular.module('lcm-filtros',[]);
    
    app.filter('ancho',function(){
        return function(categorias){
            var ancho = '';
            if(categorias<6 || categorias===8 || categorias===12 || categorias===24){
                ancho = '1-' + categorias; 
            }else{
                var num = Math.floor(24/categorias);
                ancho = num + '-24';
            }
            return ancho;
        };
    });

    app.filter('_espacio',function(){
        return function(texto){
            return texto.replace(/_/g,' ');
        };
    });
    
    app.filter('fechaMysqlAIso', function() {
        return function(input) {
            if(input){
                return new Date(input.replace(/-/g,'/')).toISOString();
            }
        };
    });
    
})();