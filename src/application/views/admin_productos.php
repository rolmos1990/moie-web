<div class="titulo">
    <h1><?=$categoria->nombre;?></h1>
</div>
<div class="menu">
    <div class="menu_item" onclick="$.colorbox({href:'<?=base_url();?>admin/nuevo_producto/<?=$categoria->id;?>'})">Nuevo producto</div>
    <div class="menu_item" onclick="vaciar_categoria(<?=$categoria->id;?>)">Vaciar categoría</div>
    <div class="menu_item" onclick="$.colorbox({href:'<?=base_url();?>admin/editar_descuentos/<?=$categoria->id;?>'})">Editar descuentos</div>
    <div class="menu_item" onclick="window.open('http://www.html2pdf.it/?url=http%3A%2F%2Flucymodas.com%2Fpdf%2F%3Fcategoria%3D<?=$categoria->id;?>')">Generar PDF</div>
    <div class="menu_item" onclick="window.location.href='<?=base_url();?>admin/categorias'">Volver</div>
</div>
<?php if(isset($error)){ ?>
<h5><?=$error;?></h5>
<?php } ?>
<ul id="lista_productos" class="ui-sortable">
    <?php foreach($productos as $p){ ?>
    <li class="producto" id="<?=$p->codigo;?>">
        <div class="producto_imagen">
            <?php if($p->imagenes > 0){ ?>
            <img <?php if($p->existencia < 1){ echo 'class="agotada"'; } ?> data-codigo="<?=$p->codigo;?>" data-imagenes="<?=$p->imagenes;?>" src="<?=base_url() . 'catalogo/' . $categoria->id . '/' . $p->codigo;?>_1_238.jpg" width="270" height="405">
            <?php }else{ ?>
            <!--mostrar imagen de error: producto sin imagen-->
            <?php } ?>
        </div>
        <div class="producto_codigo">Código: <span><?=$p->codigo;?></span></div>
        <div class="producto_precio"><?=$p->precio;?></div>
        <div class="producto_precio_descuento"><?=$p->precio_descuento;?></div>
        <div class="producto_opciones"><button onclick="$.colorbox({href:'<?=base_url();?>admin/editar_producto/<?=$p->codigo;?>'})">Editar</button> <button onclick="eliminar_producto('<?=$p->codigo;?>')">Eliminar</button></div>
    </li>
    <?php } ?>
</ul>
<script>
    $("#lista_productos").sortable({
        update: function(event, ui) {
            orden_productos('<?=$categoria->id;?>');
        }
    });
    $("#lista_productos").disableSelection();
    window.setInterval(function(){ rotar_imagenes(); },1000);
    var i = 1;
    function rotar_imagenes(){
        $('.producto').each(function(){
            if($(this).hasClass('rotar')){
                var imagen = $(this).children('.producto_imagen').first().children('img').first();
                var codigo = imagen.attr('data-codigo');
                var imagenes = imagen.attr('data-imagenes');
                if(i <= imagenes){
                    imagen.attr('src','<?=base_url();?>catalogo/<?=$categoria->id;?>/' + codigo + '_' + i +'_238.jpg');
                }
                if(i > 2){
                    i = 0;
                }
                i = i +1;
            }
        });
    }
    $('.producto').mouseover(function(){
        $(this).addClass('rotar');
    });
    $('.producto').mouseout(function(){
        $(this).removeClass('rotar');
        i=1;
        var imagen = $(this).children('.producto_imagen').first().children('img').first();
        var codigo = imagen.attr('data-codigo');
        imagen.attr('src','<?=base_url();?>catalogo/<?=$categoria->id;?>/' + codigo + '_' + i +'_238.jpg');
    });
</script>