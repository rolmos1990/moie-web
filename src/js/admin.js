function cargar_categorias(){
    var url='/admin/lista_categorias';
    $.get(url,function(result){
        $result=$(result);
        $('#categorias').empty();
        $result.appendTo('#categorias');
    }, 'html');
}
function cargar_productos(sitio){
    var categoria=$('#categoria').val();
    var url='/admin/lista_productos/' + categoria + '/' + sitio;
    $.get(url,function(result){
        $result=$(result);
        $('#productos_' + sitio).empty();
        $result.appendTo('#productos_' + sitio);
    }, 'html');
}
function agregar(){
    var nueva_categoria=prompt('Ingrese el nombre de la nueva categoría');
    if(nueva_categoria !== null && nueva_categoria !== ''){
        var url='/admin/nueva_categoria/';
        var params={categoria:nueva_categoria};
        var request= $.post(url,params);
        request.done(function(data){
                cargar_categorias();
                $('#nueva').val('');
        });
    }
}
function eliminar(e){
    if(confirm('¿Está seguro que desea eliminar esta categoria de las colecciones?')){
        var url='/admin/eliminar_categoria/';
        var params={categoria:e};
        var request= $.post(url,params);
        request.done(function(data){
            location.reload();
        });
    }
}
function eliminar_producto(codigo){
    if(confirm('¿Está seguro que desea eliminar este producto de las colecciones?')){
        var url='/admin/eliminar_producto/';
        var params={codigo:codigo};
        var request= $.post(url,params);
        request.done(function(data){
            location.reload();
        });
    }
}
function cargar_slider(){
    var url='/admin/lista_slider';
    $.get(url,function(result){
        $result=$(result);
        $('#fotos_slider').empty();
        $result.appendTo('#fotos_slider');
    }, 'html');
}
function eliminar_slider(s){
    if(confirm('¿Está seguro que desea la imagen?')){
        var url='/admin/eliminar_slider/';
        var params={archivo:s};
        var request= $.post(url,params);
        
        request.done(function(data){
            cargar_slider();
        });
    }
}
function cambiar_enlace_slider(archivo,enlace){
    var url='/admin/cambiar_enlace_slider/';
    $('#fotos_slider').empty();
    $('#fotos_slider').html('<center style="margin-top:100px;"><img src="/img/cargando.gif"><br>Actualizando</center>');
    var params={archivo:archivo,enlace:enlace.value};
    var request= $.post(url,params);
    request.done(function(data){
        cargar_slider();
    });
}
function ordenar_slider(){
    var slider=new Array();
    $('li.item').each(function(index){
        slider[index]=$(this).attr('archivo');
    });
    $('#fotos_slider').empty();
    $('#fotos_slider').html('<center style="margin-top:100px;"><img src="/img/cargando.gif"><br>Actualizando</center>');
    var url='/admin/ordenar_slider/';
    var params={'slider':JSON.stringify(slider)};
    var request= $.post(url,params);
    request.done(function(data){
        cargar_slider();
    });
}


function cargar_banner(){
    var url='/admin/lista_banner';
    $.get(url,function(result){
        $result=$(result);
        $('#fotos_banner').empty();
        $result.appendTo('#fotos_banner');
    }, 'html');
}
function eliminar_banner(s){
    if(confirm('¿Está seguro que desea la imagen?')){
        var url='/admin/eliminar_banner/';
        var params={archivo:s};
        var request= $.post(url,params);
        
        request.done(function(data){
            cargar_banner();
        });
    }
}
function cambiar_enlace_banner(archivo,enlace){
    var url='/admin/cambiar_enlace_banner/';
    $('#fotos_banner').empty();
    $('#fotos_banner').html('<center style="margin-top:100px;"><img src="/img/cargando.gif"><br>Actualizando</center>');
    var params={archivo:archivo,enlace:enlace.value};
    var request= $.post(url,params);
    request.done(function(data){
        cargar_banner();
    });
}
function ordenar_banner(){
    var banner=new Array();
    $('li.item').each(function(index){
        banner[index]=$(this).attr('archivo');
    });
    $('#fotos_banner').empty();
    $('#fotos_banner').html('<center style="margin-top:100px;"><img src="/img/cargando.gif"><br>Actualizando</center>');
    var url='/admin/ordenar_banner/';
    var params={'banner':JSON.stringify(banner)};
    var request= $.post(url,params);
    request.done(function(data){
        cargar_banner();
    });
}


function guardar(){
    var categoria=$('#categoria').val();
    var nuevo_nombre=$('#nuevo_nombre').val().trim();
    if(nuevo_nombre!=''){
        var url='/admin/actualizar_categoria/';
        var params={categoria:categoria,nuevo_nombre:nuevo_nombre};
        var request= $.post(url,params);
        request.done(function(data){
            $.colorbox.close();
            cargar_categorias();
        });
    }
}
function orden_categorias(){
    var orden = new Array();
    $('.categoria').each(function(index){
        orden[index]=$(this).attr('categoria');
    });
    var url="/admin/orden_categorias/";
    $.post(url, {'orden': JSON.stringify(orden) }, function(data){
       //alert(data);
    });
}
function orden_productos(categoria){
    var orden = new Array();
    $('.producto').each(function(index){
        orden[index]=$(this).attr('id');
    });
    var url="/admin/ordenar_productos/" + categoria;
    $.post(url, {'orden': JSON.stringify(orden) }, function(data){
       //alert(data);
    });
}
function cargar_dropzone(categoria,sitio){
    var url='/admin/dropzone/' + categoria + '/' + sitio;
    $.get(url,function(result){
        $result=$(result);
        $('#dz_wrap').empty();
        $result.appendTo('#dz_wrap');
    }, 'html');
}
function vaciar_categoria(categoria){
    if(confirm("¿Está seguro que desea eliminar TODAS las fotos?")){
        var url='/admin/vaciar_categoria/';
        var params={categoria:categoria};
        $.post(url,params,function(result){
            location.reload();
        }, 'html');
    }
}
function guardar_config(){
    var configuraciones = [];
    $('.config').each(function(){
        var clave = $(this).attr('id');
        var valor = $(this).val();
        var c = new Config(clave,valor);
        configuraciones.push(c);
    });
    $.post('/admin/guardar_config/',{config:configuraciones},function(data){
        window.location.reload();
    });
}
function Config(clave,valor){
    this.clave = clave;
    this.valor = valor;
}


function nuevo_catalogo(){
    bootbox.prompt("Ingrese el nombre del catálogo", function(result) {
    if (result === null) {
    } else if(result.trim()!=='') {
        $.post('/admin/nuevo_catalogo',{descripcion:result},function(result){
            window.location.reload();
        });
    }
    });
}
function activar_catalogo(id){
    var activo=0;
    if ($('#catalogo_activo_' + id).is(':checked')) {
        activo=1;
        $('#cargando_' + id).text("Activando...");
    }else{
        $('#cargando_' + id).text("Desactivando...");
    }
    $('#opciones_' + id).css('display','none');
    $('#cargando_' + id).fadeIn();
    $.post('/admin/activar_catalogo',{id:id,activo:activo},function(result){
        window.location.reload();
    });
}
function generar_ejemplares(id){
    var cantidad=parseInt($('#cantidad_ejemplares_' + id).val());
    if(cantidad>0){
        $('#opciones_' + id).css('display','none');
        $('#cargando_' + id).text("Generando...");
        $('#cargando_' + id).fadeIn();
        $.post('/admin/generar_ejemplares',{id_catalogo:id,cantidad:cantidad},function(result){
            var blob = new Blob([result], {type: "text/plain;charset=utf-8"});
            var inicio=parseInt($('#cantidad_'+id).text())+1;
            var fin=parseInt($('#cantidad_'+id).text())+cantidad;
            saveAs(blob, $('#descripcion_'+id).text() + " - Ejemplares " + inicio + "-" + fin + ".txt");
            $('#cantidad_'+id).text(parseInt($('#cantidad_'+id).text()) + cantidad);
            $('#cargando_' + id).css('display','none');
            $('#opciones_' + id).fadeIn();
            $('#cantidad_ejemplares_' + id).val(0);
        });
    }
}

function faltantes(){
    $.get('/admin/faltantes',function(data){
        var faltantes = JSON.parse(data);
        var txt = "";
        $.each(faltantes,function(index, item){
            txt = txt + item + " ";
        });  
        if(txt !== ""){
            $('#faltantes span').text(txt);
        }else{
            $('#faltantes').text('Todos los productos disponibles se encuentran cargados en lilicardenasmodas.com');
        }
   });
}

function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		clearTimeout(timeout);
		timeout = setTimeout(function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		}, wait);
		if (immediate && !timeout) func.apply(context, args);
	};
};
