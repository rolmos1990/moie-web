<?php foreach($categorias as $c){ ?>
<li class="categoria" categoria="<?=$c->id;?>">
    <h1><?=$c->nombre;?></h1>
    <div class="encabezado" id="encabezado<?=$c->id;?>"><img src="<?=base_url();?>catalogo/<?=$c->id;?>/config/encabezado.jpg?<?=now();?>" width="500"></div>
    <div class="portada" id="portada<?=$c->id;?>"><img src="<?=base_url();?>catalogo/<?=$c->id;?>/config/portada.png?<?=now();?>"></div>
    <button onclick="window.location.href='<?=base_url();?>admin/productos/<?=$c->id;?>'">Ver Álbum</button>
    <button onclick="$.colorbox({href:'<?=base_url();?>admin/editar_categoria/<?=$c->id;?>'});">Cambiar Nombre</button>
    <button onclick="eliminar(<?=$c->id;?>)">Eliminar</button>
    <button onclick="$('#input_cargar_portada<?=$c->id;?>').trigger('click')">Cargar Portada</button>
    <button onclick="$('#input_cargar_encabezado<?=$c->id;?>').trigger('click')">Cargar Encabezado</button>
    <form id="form_cargar_portada<?=$c->id;?>" method="POST" enctype="multipart/form-data" action="<?=base_url();?>admin/cargar_portada/<?=$c->id;?>">
        <input type="file" id="input_cargar_portada<?=$c->id;?>" name="portada" style="display:none;" />
    </form>
    <form id="form_cargar_encabezado<?=$c->id;?>" method="POST" enctype="multipart/form-data" action="<?=base_url();?>admin/cargar_encabezado/<?=$c->id;?>">
        <input type="file" id="input_cargar_encabezado<?=$c->id;?>" name="encabezado" style="display:none;" />
    </form>
</li>
<script>
        $('#input_cargar_portada<?=$c->id;?>').change(function(){
            $('#portada<?=$c->id;?>').empty();
            $('#portada<?=$c->id;?>').html('<center style="margin-top:50px;"><img src="<?=base_url();?>img/cargando.gif"><br>Actualizando</center>');
            $('#form_cargar_portada<?=$c->id;?>').submit();
        });
        $('#input_cargar_encabezado<?=$c->id;?>').change(function(){
            $('#encabezado<?=$c->id;?>').empty();
            $('#encabezado<?=$c->id;?>').html('<center style="margin-top:10px;"><img src="<?=base_url();?>img/cargando.gif"><br>Actualizando</center>');
            $('#form_cargar_encabezado<?=$c->id;?>').submit();
        });
    </script>
<?php } ?>
    