<?php 
foreach($slider as $s){
    $ruta=base_url() . 'catalogo/slider/';
?>
<li class="item" id="<?=str_replace('.jpg', '', $s->nombre);?>" archivo="<?=$s->nombre;?>" enlace="<?=$s->enlace;?>">
    <div class="foto_item">
        <img src="<?=$ruta . $s->nombre ;?>" alt="<?=$s->nombre;?>" width="285">
        Enlace a:
        <select class="ruta" onchange="cambiar_enlace_slider('<?=$s->nombre;?>',this)">
            <option value="como_comprar">Como Comprar</option>
            <option value="quienes_somos" <?php if($s->enlace=='quienes_somos'){ echo 'selected'; } ?>>Quienes Somos</option>
            <optgroup label="Categorias">
                <?php foreach($categorias as $c){ ?>
                <option value="productos/<?=$c->id;?>" <?php if($s->enlace=='productos/' . $c->id){ echo 'selected'; } ?>><?=$c->nombre;?></option>
                <?php } ?>
            </optgroup>
        </select>
    </div>
    <div class="opciones_item">
        <div class="opcion_item"><a href="<?=base_url() . 'catalogo/slider/' . $s->nombre ;?>"><img src="<?=base_url();?>img/ver_foto.png" alt="zoom" /></a></div>
        <div class="opcion_item"><img src="<?=base_url();?>img/eliminar.png" alt="eliminar" onclick="eliminar_slider('<?=$s->nombre;?>');"/></div>
    </div>
</li>
<?php
}
?>
<script>
$('.opcion_item a').colorbox({transition:"fade"});
</script>