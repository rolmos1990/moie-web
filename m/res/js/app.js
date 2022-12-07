(function(){
    
    var app = angular.module('app',['ngRoute','lcm-helpers','lcm-filtros']);
    var api = 'http://www.lucymodas.com/api/';

    /*Rutas*/
    app.config(function($routeProvider){
        $routeProvider.
            when('/',{templateUrl:'res/html/inicio.html',controller:'inicioController',controllerAs:'inicio'}).
            when('/reportar-pago',{templateUrl:'res/html/reportar-pago.html',controller:'pagoController',controllerAs:'pago'}).
            when('/rastrear-paquete',{templateUrl:'res/html/rastrear-paquete.html',controller:'paqueteController',controllerAs:'paquete'}).
            when('/comentarios',{templateUrl:'res/html/comentarios.html',controller:'comentariosController',controllerAs:'comentarios'}).
            when('/productos/:categoria',{templateUrl:'res/html/productos.html',controller:'productosController',controllerAs:'productos'}).
            when('/productos/:categoria/:producto',{templateUrl:'res/html/producto.html?201711080535',controller:'productoController',controllerAs:'producto'}).
            when('/quienes-somos',{templateUrl:'res/html/quienes-somos.html'}).
            when('/como-comprar',{templateUrl:'res/html/como-comprar.html'}).
            when('/preguntas-frecuentes',{templateUrl:'res/html/preguntas-frecuentes.html'}).
            otherwise({redirectTo:'/'});
    });

    app.controller('AppController', ['$http','$location', function($http,$location){
        var app = this;
        app.cargandoWhatsapp = false;
        this.pregunta = true;
        this.menuVisible = false;
        this.categoriaActual = 0;
        this.juego = '';
        this.ir = function(ruta){
            app.menuVisible = false;
            $location.path(ruta);
        };
        this.volver = function(){
            window.history.back();
            app.menuVisible = false;
        };
        this.inicio = function(){
            var i = false;
            if($location.path() !== '/'){
                i = true;
            }
            return i;
        };
        this.categorias = {
            lista : [],
            cargar : function(){
                this.lista = [];
                $http.get(api + 'categorias').success(function(data){
                    app.categorias.lista = data;
                });
            },
            buscarNombre : function(idCategoria){
                var nombre = 'categoria';
                for(var i = 0; i < this.lista.length; i++){
                    if(this.lista[i].id === idCategoria){
                        nombre = this.lista[i].nombre;
                        break;
                    }
                }
                return nombre;
            }
        };
        this.obtenerJuego = function(){
            $http.get(api + 'juego').success(function(data){
                app.juego = data;
            });
        };
        this.abrirWhatsapp = function(){
            if(!app.cargandoWhatsapp){
                app.cargandoWhatsapp = true;
                $http.get(api + 'whatsapp').success(function(data){
                    app.cargandoWhatsapp = false;
                    window.open('http://api.whatsapp.com/send?phone=' + data.numero + '&text=Hola%21%21%21');
                    app.pregunta = false;
                }).error(function(error){
                    app.cargandoWhatsapp = true;
                });
            }
        }

        this.categorias.cargar();
        this.obtenerJuego();
    }]);

	app.controller('inicioController', ['$http',function($http){
        var inicio = this;
        this.rotativos = {
            lista: [],
            cargar: function(){
                this.lista = [];
                $http.get(api + 'rotativos').success(function(data){
                    inicio.rotativos.lista = data;
                });
            }
        }
        this.rotativos.cargar();
	}]);

    app.controller('paqueteController',['$http',function($http){
        var paquete = this;
        this.id = '';
        this.pedido = {};
        this.rastrear = function(){
            this.cargando = true;
            this.pedido = {};
            this.pedido.id = this.id;
            $http.get(api + 'rastrear_paquete/' + this.id).success(function(data){
                paquete.pedido.eventos = data;
                paquete.cargando = false;
            }).error(function(data,status){
                if(status === 404){
                    paquete.pedido.error = 'Pedido #' + paquete.pedido.id + ' no encontrado';
                }else if(status === 500){
                    paquete.pedido.error = 'Ha ocurrido un error, intente nuevamente';
                }else if(status === 400){
                    paquete.pedido.error = 'Ha introducido un numero de pedido inválido';
                }
                paquete.cargando = false;
            });
        };
    }]);

    app.controller('comentariosController',['$http','helpers',function($http,helpers){
        var comentarios = this;
        this.lista = [];
        this.data = {};
        this.error = {};
        this.exito = false;
        this.cargar = function(){
            this.cargandoLista = true;
            this.exito = false;
            this.lista = [];
            $http.get(api + 'comentarios').success(function(data){
                comentarios.lista = data;
                comentarios.cargandoLista = false;
            });
        };
        this.registrar = function(){
            this.registrando = true;
            comentarios.error = {};
            $http.post(api + '/registrar_comentario',helpers.httpParam(this.data),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                comentarios.data = {};
                comentarios.exito = true;
                comentarios.registrando = false;
            }).error(function(data,status){
                if(status === 500){
                    alert('Ha ocurrido un error en el servidor. Por favor intente nuevamente.');
                }else if(status === 400){
                    alert('Datos invalidos. Por favor verifique e intente nuevamente.');
                }
                comentarios.registrando = false;
            });
        };
        this.cargar();
    }]);

    app.controller('pagoController',['$http','helpers',function($http,helpers){
        var pago = this;
        this.data =  {};
        this.error = {};
        this.exito = false;
        this.cargar = function(id){
            this.data = {};
            this.error = {};
            this.exito = false;
        };
        this.registrar = function(){
            pago.error = {};
            $http.post(api + 'registrar_pago',helpers.httpParam(this.data),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                pago.exito = true;
                pago.data = {};
            }).error(function(data,status){
                if(status === 500){
                    alert('Ha ocurrido un error en el servidor. Por favor intente nuevamente.');
                }else if(status === 400){
                    pago.error = data;
                }
            });
        };
        this.cargar();
    }]);

    app.controller('productosController',['$scope','$anchorScroll', '$location','$http','$routeParams','$interval',function($scope,$anchorScroll,$location,$http,$routeParams,$interval){
        var productos = this;
        this.lista = [];
        this.intro = false;
        this.idCategoria = '';
        this.verDestacado = 0;
        this.cargar = function(){
            var id = $routeParams.categoria;
            this.idCategoria = id;
            if(id === $scope.$parent.app.categoriaActual.id){
                this.lista = $scope.$parent.app.categoriaActual.lista;
                if($scope.$parent.app.categoriaActual.scrollTo){
                    $location.hash($scope.$parent.app.categoriaActual.scrollTo);
                }else{
                    if(id === 'mayor'){
                        this.intro = true;
                    }
                }
            }else{
                this.cargando = true;
                this.lista = [];
                var url;
                if(id === 'mayor'){
                    url = 'productos_mayor';
                }else{
                    url = 'productos/' + id;
                }
                $http.get(api + url).success(function(data){
                    productos.lista = data;
                    $scope.$parent.app.categoriaActual.lista = data;
                    $scope.$parent.app.categoriaActual.id = productos.idCategoria;
                    productos.cargando = false;
                });
            }  
        };
        this.ver = function(idProducto){
            $scope.$parent.app.categoriaActual.scrollTo = idProducto;
            $scope.$parent.app.ir('productos/' + this.idCategoria + '/' + idProducto);
        };
        this.cargar();
    }]);

    app.controller('productoController',['$http','$routeParams',function($http,$routeParams){
        var producto = this;
        this.data = {};
        this.mayor = 0;
        this.cargar = function(){
            this.cargando = true;
            if($routeParams.categoria === 'mayor'){
                this.mayor = 1;
            }
            var id = $routeParams.producto;
            this.data = {};
            $http.get(api + 'producto/' + id).success(function(data){
                console.log('data response all: ', data);
                producto.data = data;
                producto.data.imagen = [0,0,0];
                console.log('data disponibilidad: ', data);
                producto.data.disponibilidad = data.disponibilidad;
                var img = parseInt(data.imagenes);
                if(img >= 4){
                    producto.data.imagen[2] = 1;
                    img = img - 4;
                    producto.imagen = 3;
                }
                if(img >= 2){
                    producto.data.imagen[1] = 1;
                    img = img - 2;
                    producto.imagen = 2;
                }
                if(img >= 1){
                    producto.data.imagen[0] = 1;
                    producto.imagen = 1;
                }

                var alertas = [
                    '¡Este producto tiene mucha demanda!',
                    '¡Muy solicitado!',
                    'Se ha vendido 13 veces en las últimas 24 horas ',
                    'Se ha vendido 9 veces en las últimas 24 horas ',
                    'Se ha vendido 8 veces en las últimas 24 horas ',
                    'Se ha vendido 5 veces en las últimas 24 horas ',
                    'Se ha vendido 10 veces en las últimas 24 horas ',
                    'Se ha vendido 2 veces en las últimas 24 horas ',
                    'Se ha vendido 3 veces en las últimas 24 horas ',
                    'Se ha vendido 12 veces en las últimas 24 horas ',
                    'Se ha vendido 11 veces en las últimas 24 horas ',
                    'Se ha vendido 4 veces en las últimas 24 horas ',
                    '¡Este producto es muy solicitado!',
                    'Hay 6 personas viendo este producto',
                    'Hay  8 personas viendo este producto',
                    'Hay 12 personas viendo este producto',
                    'Hay 14 personas viendo este producto',
                    'Hay 11 personas viendo este producto'
                ];
                producto.data.alerta = alertas[Math.floor(Math.random() * alertas.length)];

                console.log('producto: ', producto);

                producto.cargando = false;
                producto.cargarDisponibilidad();
            });
        };
        this.cargarDisponibilidad = function(){
            this.cargandoDisponibilidad = true;
            var id = $routeParams.producto;
            //this.data.disponibilidad = {};
            $http.get(api + 'disponibilidad/' + id).success(function(data){
                //producto.data.disponibilidad = data;
                producto.cargandoDisponibilidad = false;
            }).error(function(status,data){
                producto.cargandoDisponibilidad = false;
            });
        };
        this.imgUrl = function(){
            return 'catalogo/' + producto.data.idCategoria + '/' + producto.data.codigo + '_' + producto.imagen + '_800.jpg'
        }
        this.cargar();
    }]);

    app.directive('lcmRotativo', function($interval) {
        return {
            restrict: 'A',
            link: function (scope, element){
                var i = 0;
                jQuery(element).height(jQuery(element).width() * 0.625);
                $interval(function(){
                    if(element.children('img').length > 1){
                        if(i<element.children('img').length-1){
                            i++;
                        }else{
                            i=0;
                        }
                        jQuery(element).children('img').fadeOut(2000);
                        jQuery(element).children('img').eq(i).fadeIn(2000);
                    }
                },10000);
            }
        };
    });
    
})();
