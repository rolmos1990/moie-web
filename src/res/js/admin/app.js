(function(){
    
    var app = angular.module('app',['ngRoute','ngDialog','lcm-helpers','lcm-filtros','ngFileUpload','ui.sortable','angular-date-picker-polyfill','n3-line-chart']);
    
    /*Rutas*/
    app.config(function($routeProvider){
        $routeProvider.
            when('/login',{templateUrl:'/res/templates/admin/login.html',controller:'loginController',controllerAs:'login'}).
            when('/categorias',{templateUrl:'/res/templates/admin/categorias.html',controller:'categoriasController',controllerAs:'categorias'}).
            when('/categoria/:categoria',{templateUrl:'/res/templates/admin/categoria.html',controller:'categoriaController',controllerAs:'categoria'}).
            when('/categoria/:categoria/:producto',{templateUrl:'/res/templates/admin/producto.html',controller:'productoController',controllerAs:'producto'}).
            when('/rotativo-principal',{templateUrl:'/res/templates/admin/rotativo.html',controller:'rotativoController',controllerAs:'rotativo'}).
            when('/rotativo-secundario',{templateUrl:'/res/templates/admin/rotativo.html',controller:'rotativoController',controllerAs:'rotativo'}).
            when('/novedades',{templateUrl:'/res/templates/admin/novedades.html',controller:'novedadesController',controllerAs:'novedades'}).
            when('/novedades/:novedad',{templateUrl:'/res/templates/admin/novedad.html',controller:'novedadController',controllerAs:'novedad'}).
            when('/comentarios',{templateUrl:'/res/templates/admin/comentarios.html',controller:'comentariosController',controllerAs:'comentarios'}).
            when('/movil',{templateUrl:'/res/templates/admin/movil.html',controller:'movilController',controllerAs:'movil'}).
            when('/whatsapp',{templateUrl:'/res/templates/admin/whatsapp.html',controller:'whatsappController',controllerAs:'whatsapp'}).
            otherwise({redirectTo:'/categorias'});
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
                $location.path('/categorias');
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

    /*Controlador de categorias*/
    app.controller('categoriasController', ['$http','$timeout','helpers','ngDialog','Upload','$location', function($http,$timeout,helpers,ngDialog,Upload,$location){
        var categorias = this;
        this.lista = [];
        this.faltantes = [];
        this.mostrarFaltantes = false;
        this.cargando = false;
        this.fechaActual = new Date();
        this.cargar = function(){
            this.lista = [];
            this.cargando = true;
            categorias.ahora();
            $http.get('/admin/categorias').success(function(data){
                categorias.lista = data;
                categorias.cargando = false;
            }).error(function(data,status){
                categorias.cargando = false;
                if(status===401){
                    $location.path('/login');
                }
            });
        };
        this.ahora = function(){
            categorias.fechaActual = Date();
        }
        this.nueva = function(){
            ngDialog.openConfirm({
                template: '/res/templates/admin/dialog/nueva-categoria.html',
                className: 'ngdialog-theme-default'
            }).then(function(nombre){
                categorias.cargando = true;
                $http.post('/admin/nueva_categoria',helpers.httpParam({nombre: nombre}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                    categorias.cargar();
                }).error(function(data,status){
                    categorias.cargando = false;
                    if(status===401){
                        $location.path('/login');
                    }
                });
            },function(){});
        };
        this.cambiarNombre = function(categoria){
            ngDialog.openConfirm({
                controller: function(){
                    this.categoria = categoria;
                },
                controllerAs: 'dialog',
                template: '/res/templates/admin/dialog/cambiar-nombre-categoria.html',
                className: 'ngdialog-theme-default'
            }).then(function(nombre){
                categorias.cargando = true;
                $http.post('/admin/cambiar_nombre_categoria',helpers.httpParam({id: categoria.id,nombre: nombre}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                    categorias.cargar();
                }).error(function(data,status){
                    categorias.cargando = false;
                    if(status===401){
                        $location.path('/login');
                    }
                });
            },function(){});
        };
        this.eliminar = function(categoria){
            ngDialog.openConfirm({
                controller: function(){
                    this.categoria = categoria;
                },
                controllerAs: 'dialog',
                template: '/res/templates/admin/dialog/eliminar-categoria.html',
                className: 'ngdialog-theme-default'
            }).then(function(){
                categorias.cargando = true;
                $http.post('/admin/eliminar_categoria',helpers.httpParam({id: categoria.id}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                    categorias.cargar();
                }).error(function(data,status){
                    categorias.cargando = false;
                    if(status===401){
                        $location.path('/login');
                    }
                });
            },function(){});
        };
        this.seleccionar = function(elemento,id){
            $timeout(function() {
                angular.element('#' + elemento + id).trigger('click');
            }, 0);
        };
        this.subir = function(elemento,id,archivo){
            if (archivo) {
                categorias.cargando = true;
                archivo.upload = Upload.upload({
                    url: '/admin/cargar_imagen_categoria',
                    data: {
                        id: id,
                        elemento: elemento,
                        imagen: archivo
                    }
                });
                archivo.upload.then(function (response) {
                    $timeout(function () { //success
                        archivo.result = response.data;
                        categorias.cargar();
                    });
                }, function (response) { //error
                    categorias.cargando = false;
                    if (response.status > 0)
                        alert(response.data);
                }, function (evt) {
                    archivo.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
                });
            }
        };
        this.ordenar = {
            update: function(e, ui) {},
            stop: function(e, ui) {
                var orden = [];
                for(var i=0; i<categorias.lista.length; i++){
                    orden.push(categorias.lista[i].id);
                }
                categorias.cargando = true;
                $http.post('/admin/ordenar',helpers.httpParam({elemento:'categoria',orden:orden}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                    categorias.cargar();
                }).error(function(data,status){
                    categorias.cargando = false;
                    if(status===401){
                        $location.path('/login');
                    }
                });
            }
        };
        this.cargarFaltantes = function(){
            this.faltantes = [];
            $http.get('/admin/faltantes').success(function(data){
                categorias.faltantes = data;
                categorias.mostrarFaltantes = true;
            }).error(function(data,status){
                categorias.cargando = false;
                if(status===401){
                    $location.path('/login');
                }
            });
        };

        this.cargar();
        this.cargarFaltantes();
    }]);

    /*Controlador de productos*/
    app.controller('categoriaController', ['$http','$routeParams','helpers','ngDialog','$location', function($http,$routeParams,helpers,ngDialog,$location){
        var categoria = this;
        this.mostrarAgotados = true;
        this.data = {};
        this.cargando = false;
        this.cargar = function(){
            var id = $routeParams.categoria;
            this.data = {};
            categoria.cargando = true;
            $http.get('/admin/categoria/' + id).success(function(data){
                categoria.data = data;
                categoria.cargando = false;
            }).error(function(data,status){
                categoria.cargando = false;
                if(status===401){
                    $location.path('/login');
                }
            });
        };
        this.pdf = function(info, tipo){
            console.log("GENERANDO PDF....", tipo);
            var id = $routeParams.categoria;
            /*if(info){
                url = 'http%3A%2F%2Fwww.lucymodas.com%2Fpdf%2Findex.php%3Fcategoria%3D'+id;
            }else{
                url = 'http%3A%2F%2Fwww.lucymodas.com%2Fpdf%2Findex2.php%3Fcategoria%3D'+id;
            }*/
            if(info){
                url = 'http%3A%2F%2Fwww.martinamodas.com%2Fpdf%2Flucy.php%3Fcategoria%3D'+id;
            }else{
                url = 'http%3A%2F%2Fwww.martinamodas.com%2Fpdf%2Flucy2.php%3Fcategoria%3D'+id;
            }
            
            if(tipo == 'web'){
                window.open(encodeURIComponent(url)+'&format=Legal');
            }
            else {
        	    window.open('https://lucypdf.appspot.com/?url='+url+'&format=Legal');
            }
        };
        this.pdfWeb = function(info, tipo){
            var id = $routeParams.categoria;
            /*if(info){
                url = 'http%3A%2F%2Fwww.lucymodas.com%2Fpdf%2Findex.php%3Fcategoria%3D'+id;
            }else{
                url = 'http%3A%2F%2Fwww.lucymodas.com%2Fpdf%2Findex2.php%3Fcategoria%3D'+id;
            }*/
            if(info){
                url = 'http://www.martinamodas.com/pdf/lucy.php?categoria='+id;
            }else{
                url = 'http://www.martinamodas.com/pdf/lucy2.php?categoria='+id;
            }
            
            window.open(url+'&format=Legal');
        }
        this.vaciar = function(){
            ngDialog.openConfirm({
                template: '/res/templates/admin/dialog/vaciar-categoria.html',
                className: 'ngdialog-theme-default'
            }).then(function(){
                categoria.cargando = true;
                $http.post('/admin/vaciar_categoria',helpers.httpParam({id: categoria.data.id}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                    categoria.cargar();
                }).error(function(data,status){
                    categoria.cargando = false;
                    if(status===401){
                        $location.path('/login');
                    }
                });
            },function(){});
        };
        this.descuentos = function(){
            ngDialog.openConfirm({
                controller: function(){
                    this.descuento = {
                        detal: parseInt(categoria.data.descuento),
                        descuento1: {
                            cantidad : parseInt(categoria.data.cantidad_mayor_1),
                            porcentaje : parseInt(categoria.data.descuento_mayor_1)
                        },
                        descuento2: {
                            cantidad : parseInt(categoria.data.cantidad_mayor_2),
                            porcentaje : parseInt(categoria.data.descuento_mayor_2)
                        }
                    };
                },
                controllerAs: 'dialog',
                template: '/res/templates/admin/dialog/descuentos.html',
                className: 'ngdialog-theme-default'
            }).then(function(descuento){
                categoria.cargando = true;
                $http.post('/admin/descuentos',helpers.httpParam({id: categoria.data.id,descuentos: descuento}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                    categoria.cargar();
                }).error(function(data,status){
                    categoria.cargando = false;
                    if(status===401){
                        $location.path('/login');
                    }
                });
            },function(){});
        };
        this.eliminar = function(producto){
            ngDialog.openConfirm({
                controller: function(){
                    this.producto = producto;
                },
                controllerAs: 'dialog',
                template: '/res/templates/admin/dialog/eliminar-producto.html',
                className: 'ngdialog-theme-default'
            }).then(function(){
                categoria.cargando = true;
                $http.post('/admin/eliminar_producto',helpers.httpParam({codigo: producto.codigo}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                    categoria.cargar();
                }).error(function(data,status){
                    categoria.cargando = false;
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
                for(var i=0; i<categoria.data.productos.length; i++){
                    orden.push(categoria.data.productos[i].codigo);
                }
                categoria.cargando = true;
                $http.post('/admin/ordenar',helpers.httpParam({elemento:'producto',orden:orden}),{ headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'} }).success(function(data){
                    categoria.cargar();
                }).error(function(data,status){
                    categoria.cargando = false;
                    if(status===401){
                        $location.path('/login');
                    }
                });
              
            }
        };
        this.minImagen = function(mascara){
            var min = 0;
            if(mascara >= 4){
                min = 3;
                mascara = mascara-4;
            }
            if(mascara >= 2){
                min = 2;
                mascara = mascara-2;
            }
            if(mascara === 1){
                min = 1;
            }
            return min;
        };
        
        this.cargar();
    }]);

    /*Controlador de producto*/
    app.controller('productoController', ['$http','$routeParams','$location','Upload','$timeout','$location','$route', function($http,$routeParams,$location,Upload,$timeout,$location,$route){
        var producto = this;
        this.data = {};
        this.nuevo = false;
        this.cargando = false;
        this.cargar = function(){
            this.data = {};
            var codigo = $routeParams.producto;
            var idCategoria = $routeParams.categoria;
            if(codigo !== 'nuevo'){
                producto.cargando = true;
                $http.get('/admin/producto/' + codigo).success(function(data){
                    producto.data = data;
                    producto.data.precio = parseFloat(producto.data.precio);
                    producto.data.tallaUnica = parseInt(producto.data.tallaUnica);
                    var i = parseInt(producto.data.imagenes);
                    var v = false;
                    var imagenes = {
                        viejas: [false,false,false],
                        nuevas: [null,null,null]
                    };
                    if(i >= 4){
                        imagenes.viejas[2] = true;
                        i = i-4;
                    }
                    if(i >= 2){
                        imagenes.viejas[1] = true;
                        i = i-2;
                    }
                    if(i === 1){
                        imagenes.viejas[0] = true;
                    }
                    producto.data.imagenes = imagenes;
                    producto.cargando = false;
                }).error(function(data,status){
                    producto.cargando = false;
                    if(status===401){
                        $location.path('/login');
                    }
                });
            }else{
                this.data.nuevo = true;
                this.data.idCategoria = idCategoria;
                this.data.imagenes = {
                    viejas: [false,false,false],
                    nuevas: [null,null,null]
                };
            }
        };
        
        this.guardar = function(){
            producto.cargando = true;
            Upload.upload({
                url: '/admin/guardar_producto',
                data: producto.data
            }).then(function (response) {
                $timeout(function () { //success
                    producto.cargando = false;
                    if(producto.data.nuevo){
                        $location.path('/categoria/' + producto.data.idCategoria + '/' + producto.data.codigo);
                    }else{
                        $route.reload();
                    }
                });
            }, function (response) { //error
                producto.cargando = false;
                if(response.status===401){
                    $location.path('/login');
                }else{
                    alert(response.data);
                }
            }, function (evt) {
                //console.log(Math.min(100, parseInt(100.0 * evt.loaded / evt.total)));
            });
        };
        
        this.eliminarImagen = function(index){
            this.data.imagenes.viejas[index] = false;
            this.data.imagenes.nuevas[index] = null;
        };
        
        this.seleccionar = function(index){
            $timeout(function() {
                angular.element('#imagen-producto' + index).trigger('click');
            }, 0);
        };
        
        this.cargar();
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
