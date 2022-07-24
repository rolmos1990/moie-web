(function(){
    
    var app = angular.module('app',['ngRoute','ngDialog','lcm-helpers','lcm-filtros','ngFileUpload','ui.sortable','angular-date-picker-polyfill','n3-line-chart']);
    
    /*Rutas*/
    app.config(function($routeProvider){
        $routeProvider.
            when('/login',{templateUrl:'/res/templates/admin/login.html',controller:'loginController',controllerAs:'login'}).
            when('/rotativo-principal',{templateUrl:'/res/templates/admin/rotativo.html',controller:'rotativoController',controllerAs:'rotativo'}).
            when('/rotativo-secundario',{templateUrl:'/res/templates/admin/rotativo.html',controller:'rotativoController',controllerAs:'rotativo'}).
            when('/novedades',{templateUrl:'/res/templates/admin/novedades.html',controller:'novedadesController',controllerAs:'novedades'}).
            when('/novedades/:novedad',{templateUrl:'/res/templates/admin/novedad.html',controller:'novedadController',controllerAs:'novedad'}).
            when('/comentarios',{templateUrl:'/res/templates/admin/comentarios.html',controller:'comentariosController',controllerAs:'comentarios'}).
            when('/movil',{templateUrl:'/res/templates/admin/movil.html',controller:'movilController',controllerAs:'movil'}).
            when('/whatsapp',{templateUrl:'/res/templates/admin/whatsapp.html',controller:'whatsappController',controllerAs:'whatsapp'}).
            otherwise({redirectTo:'/rotativo-principal'});
    });
    
    /*offset del auto scroll*/
//    app.run(['$anchorScroll', function($anchorScroll) {
//        $anchorScroll.yOffset = 50;
//    }]);
    
    /*Controlador de login*/
    app.controller('loginController', ['$http','$location','helpers', function($http,$location,helpers){
        var login = this;
        this.password = '';
        this.mensaje = '';
        this.cargando = false;
        this.iniciar = function(){
            login.cargando = true;
            $http.post('/admin/login',helpers.httpParam({password: this.password}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                login.cargando = false;
                $location.path('/rotativo-principal');
            }).error(function(data,status){
                login.cargando = false;
                login.mensaje = 'Contraseña inválida';
            });
        };
        this.cerrar = function(){
            login.cargando = true;
            $http.get('/admin/logout').success(function(data){
                console.log('logout');
                login.cargando = false;
            }).error(function(data,status){
                login.cargando = false;
            });
        };
        this.cerrar();
    }]);
    
    /*Controlador principal*/
    app.controller('adminController', ['$http','$location', function($http,$location){
        var app = this;
        this.sesion = false;
        this.ir = function(ruta){
            $location.hash('');
            $location.path(ruta);
        };
        this.rutaActiva = function(ruta){
            var r = $location.path();
            return r.slice(1, ruta.length+1) == ruta;
        };
    }]);

    /*Controlador de rotativos*/
    app.controller('rotativoController', ['$http','$location','$timeout','Upload','helpers','ngDialog',function($http,$location,$timeout,Upload,helpers,ngDialog){
        var rotativo = this;
        this.lista = [];
        this.cargando = false;
        this.tipo = '';
        if($location.path() === '/rotativo-principal'){
            this.tipo = 'principal';
        }else if($location.path() === '/rotativo-secundario'){
            this.tipo = 'secundario';
        }
        
        this.cargar = function(){
            rotativo.cargando = true;
            this.lista = [];
            $http.get('/admin/rotativo/' + rotativo.tipo).success(function(data){
                rotativo.lista = data;
                rotativo.cargando = false;
            }).error(function(data,status){
                rotativo.cargando = false;
                if(status===401){
                    $location.path('/login');
                }
            });
        };
        this.seleccionar = function(){
            $timeout(function() {
                angular.element('#nueva-imagen').trigger('click');
            }, 0);
        };
        this.subir = function(archivo){
            if (archivo) {
                rotativo.cargando = true;
                archivo.upload = Upload.upload({
                    url: '/admin/nueva_imagen_rotativo',
                    data: {
                        tipo: rotativo.tipo,
                        imagen: archivo
                    }
                });
                archivo.upload.then(function (response) {
                    $timeout(function () { //success
                        archivo.result = response.data;
                        rotativo.cargar();
                    });
                }, function (response) { //error
                    rotativo.cargando = false;
                    if (response.status > 0)
                        alert(response.data);
                }, function (evt) {
                    archivo.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
                });
            }
        };
        this.cambiarEnlace = function(imagen,enlace){
            rotativo.cargando = true;
            $http.post('/admin/cambiar_enlace_imagen',helpers.httpParam({imagen: imagen,enlace: enlace}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                rotativo.cargar();
            }).error(function(data,status){
                rotativo.cargando = false;
                if(status===401){
                    $location.path('/login');
                }
            });
        };
        this.eliminar = function(imagen){
            ngDialog.openConfirm({
                controller: function(){
                    this.imagen = imagen;
                },
                controllerAs: 'dialog',
                template: '/res/templates/admin/dialog/eliminar-imagen.html',
                className: 'ngdialog-theme-default'
            }).then(function(){
                rotativo.cargando = true;
                $http.post('/admin/eliminar_imagen_rotativo',helpers.httpParam({nombre: imagen.nombre,tipo: rotativo.tipo}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                    rotativo.cargar();
                }).error(function(data,status){
                    rotativo.cargando = false;
                    if(status===401){
                        $location.path('/login');
                    }
                });
            },function(){});
        };
        this.ordenar = {
            update: function(e, ui) {},
            stop: function(e, ui) {
                var orden = [];
                for(var i=0; i<rotativo.lista.length; i++){
                    orden.push(rotativo.lista[i].nombre);
                }
                rotativo.cargando = true;
                $http.post('/admin/ordenar',helpers.httpParam({elemento:'rotativo',orden:orden}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                    rotativo.cargar();
                }).error(function(data,status){
                    rotativo.cargando = false;
                    if(status===401){
                        $location.path('/login');
                    }
                });
            }
        };
        
        this.cargar();
        $http.get('/admin/categorias').success(function(data){
            rotativo.categorias = data;
        }).error(function(data,status){
            if(status===401){
                $location.path('/login');
            }
        });
    }]);

    /*Controlador de comentarios*/
    app.controller('comentariosController', ['$http','ngDialog','helpers','$location', function($http,ngDialog,helpers,$location){
        var comentarios = this;
        this.lista = [];
        this.cargando = false;
        this.cargar = function(){
            this.lista = [];
            comentarios.cargando = true;
            $http.get('/admin/comentarios').success(function(data){
                comentarios.lista = data;
                comentarios.cargando = false;
            }).error(function(data,status){
                comentarios.cargando = false;
                if(status===401){
                    $location.path('/login');
                }
            });
        };
        this.eliminar = function(comentario){
            ngDialog.openConfirm({
                controller: function(){
                    this.comentario = comentario;
                },
                controllerAs: 'dialog',
                template: '/res/templates/admin/dialog/eliminar-comentario.html',
                className: 'ngdialog-theme-default'
            }).then(function(){
                comentarios.cargando = true;
                $http.post('/admin/eliminar_comentario',helpers.httpParam({id: comentario.id}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                    comentarios.cargar();
                }).error(function(data,status){
                    comentarios.cargando = false;
                    if(status===401){
                        $location.path('/login');
                    }
                });
            },function(){});
        };
        this.aprobar = function(comentario){
            comentarios.cargando = true;
            $http.post('/admin/aprobar_comentario',helpers.httpParam({id: comentario.id}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                comentarios.cargar();
            }).error(function(data,status){
                comentarios.cargando = false;
                if(status===401){
                    $location.path('/login');
                }
            });
        };
        
        this.cargar();
    }]);

    /*Controlador de novedades*/
    app.controller('novedadesController', ['$http','ngDialog','helpers','$location', function($http,ngDialog,helpers,$location){
        var novedades = this;
        this.lista = [];
        this.cargando = false;
        this.cargar = function(){
            this.lista = [];
            novedades.cargando = true;
            $http.get('/admin/novedades').success(function(data){
                novedades.lista = data;
                novedades.cargando = false;
            }).error(function(data,status){
                novedades.cargando = false;
                if(status===401){
                    $location.path('/login');
                }
            });
        };
        this.eliminar = function(novedad){
            ngDialog.openConfirm({
                controller: function(){
                    this.novedad = novedad;
                },
                controllerAs: 'dialog',
                template: '/res/templates/admin/dialog/eliminar-novedad.html',
                className: 'ngdialog-theme-default'
            }).then(function(){
                novedades.cargando = true;
                $http.post('/admin/eliminar_novedad',helpers.httpParam({id: novedad.id}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                    novedades.cargar();
                }).error(function(data,status){
                    novedades.cargando = false;
                    if(status===401){
                        $location.path('/login');
                    }
                });
            },function(){});
        };
        
        this.cargar();
    }]);

    /*Controlador de novedad*/
    app.controller('novedadController', ['$http','$routeParams','$location','Upload','$timeout','$location','$route', function($http,$routeParams,$location,Upload,$timeout,$location,$route){
        var novedad = this;
        this.data = {};
        this.nuevo = false;
        this.cargando = false;
        this.cargar = function(){
            this.data = {};
            var id = $routeParams.novedad;
            if(id !== 'nuevo'){
                novedad.cargando = true;
                $http.get('/admin/novedad/' + id).success(function(data){
                    novedad.data = data;
                    novedad.data.nuevaPortada = null;
                    novedad.data.nuevoEncabezado = null;
                    novedad.cargando = false;
                }).error(function(data,status){
                    novedad.cargando = false;
                    if(status===401){
                        $location.path('/login');
                    }
                });
            }else{
                this.data.nuevo = true;
            }
        };
        
        this.guardar = function(){
            novedad.cargando = true;
            Upload.upload({
                url: '/admin/guardar_novedad',
                data: novedad.data
            }).then(function (response) {
                $timeout(function () { //success
                    novedad.cargando = false;
                    if(novedad.data.nuevo){
                        $location.path('/novedades/' + response.data);
                    }else{
                        $route.reload();
                    }
                });
            }, function (response) { //error
                novedad.cargando = false;
                if(response.status===401){
                    $location.path('/login');
                }else{
                    alert(response.data);
                }
            }, function (evt) {
                //console.log(Math.min(100, parseInt(100.0 * evt.loaded / evt.total)));
            });
        };
        
        this.seleccionar = function(imagen){
            $timeout(function() {
                angular.element('#imagen-' + imagen).trigger('click');
            }, 0);
        };
        
        this.cargar();
    }]);

    /*Controlador de móvil*/
    app.controller('movilController', ['$http','$location','$scope','$filter', function($http,$location,$scope,$filter){
        var movil = this;
        var hoy = new Date();
        this.lista = [];
        this.cargando = false;
        this.fecha = {
            inicial: new Date(hoy.getTime() - 2332800000),
            final: new Date(hoy.getTime()),
            valida: function(){
                var v = false;
                if(this.inicial<=this.final){
                    v = true;
                }
                return v;
            }
        };
        this.cargar = function(){
            this.lista = [];
            var url = '/admin/movil';
                url += '/' + $filter('date')(movil.fecha.inicial, 'yyyy-MM-dd');
                url += '/' + $filter('date')(movil.fecha.final, 'yyyy-MM-dd');
            movil.cargando = true;
            $http.get(url).success(function(data){
                for(var i = 0; i < data.length; i++){
                    movil.lista[i] = {
                        x: angular.copy(data[i].x),
                        etiqueta: angular.copy(data[i].etiqueta),
                        cantidad: angular.copy(parseFloat(data[i].cantidad))
                    };
                }
                movil.opciones = {
                    axes: {
                      x: {key: 'x', type: 'linear',ticksFormatter: function(t){ return "";}},
                      y: {type: 'linear'}
                    },
                    series: [
                      {y: 'cantidad', thickness: '2px', type: 'line', color:'rgb(227,102,157)', striped: true, label: 'Descargas',dotSize: 5}
                    ],
                    lineMode: 'linear',
                    tension: 0.7,
                    tooltip: {mode: 'scrubber', formatter: function(x, y, series) {return movil.lista[x-1].etiqueta + ': ' + y ;}},
                    drawLegend: false,
                    drawDots: true
                };
                movil.cargando = false;
            }).error(function(data,status){
                movil.cargando = false;
                if(status===401){
                    $location.path('/login');
                }
            });
        };
        
        $scope.$watch("movil.fecha",function(nuevoValor, viejoValor){
            if(nuevoValor!==viejoValor && nuevoValor!==''){
                if(movil.fecha.valida()){
                    movil.cargar();
                }else{
                    alert('Fecha inválida');
                    movil.lista = [];
                }
            }
        },true);
        
        this.cargar();
    }]);

    /*Controlador de whatsapp*/
    app.controller('whatsappController', ['$http', 'helpers', 'ngDialog', function($http, helpers, ngDialog){
        var whatsapp = this;
        whatsapp.cargando = false;
        whatsapp.lista = [];
        whatsapp.numero = '';
        
        whatsapp.cargar = function(){
            whatsapp.lista = [];
            var url = '/admin/whatsapp';
            whatsapp.cargando = true;
            $http.get(url).success(function(data){
                whatsapp.lista = data;
                whatsapp.cargando = false;
            }).error(function(data,status){
                whatsapp.cargando = false;
                if(status===401){
                    $location.path('/login');
                }
            });
        };

        whatsapp.eliminar = function(id){
            const url = '/admin/eliminar_whatsapp';
            whatsapp.cargando = true;
            $http.post(url,helpers.httpParam({id: id}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                whatsapp.cargar();
            }).error(function(data,status){
                whatsapp.cargando = false;
                if(status===401){
                    $location.path('/login');
                }
            });
        };
        
        whatsapp.nuevo = function(){
            ngDialog.openConfirm({
                template: '/res/templates/admin/dialog/nuevo-whatsapp.html',
                className: 'ngdialog-theme-default'
            }).then(function(numero){
                const url = '/admin/guardar_whatsapp';
                whatsapp.cargando = true;
                numero = numero.replace(/[^\d]/g, "");
                $http.post(url,helpers.httpParam({numero: numero}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                    whatsapp.cargar();
                }).error(function(data,status){
                    whatsapp.cargando = false;
                    if(status===401){
                        $location.path('/login');
                    }
                });
            },function(){});
        };
        
        whatsapp.cargar();
    }]);

})();
