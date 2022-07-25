<div id="producto">
    <div id="miniaturas">
        <?php
        foreach($producto->productImages as $productImage){ ?>
        <img id="miniatura_<?=$productImage['index'];?>;?>" data-img="<?=$productImage['index'];?>" src="<?=base_product_catalog_url() . $productImage['small']?>" alt="<?=$producto->codigo;?>" height="100">
        <?php } ?>
    </div>
    <div id="imagen">
        <?php foreach($producto->productImages as $productImage){ ?>
        <img id="imagen_<?=$productImage['index'];?>" src="<?=base_product_catalog_url() . $productImage['high'];?>" alt="<?=$producto->codigo;?>" height="600" data-magnify-src="<?=base_product_catalog_url() . $productImage['original'];?>" alt="<?=$producto->codigo;?>">
        <?php } ?>
    </div>
    <?php if($producto->descuento > 0){ ?><div id="lazo_descuento"><?=$producto->descuento;?>% Descuento</div><?php } ?>
    <div id="datos">
        <span id="dato_tipo"><?=$producto->tipo;?></span>
        <span id="dato_codigo">Código: <strong><?=str_replace("_","",$producto->codigo);?></strong></span>
        <label>Precio</label>
        <span class="dato_precio"><b><?=$producto->precio_descuento;?></b><?php if($producto->precio != $producto->precio_descuento){ echo '<cite>' . $producto->precio . '</cite>'; }?></span>
        <label>Tela</label>
        <span id="dato_tela"><?=$producto->tela;?></span>
        <?php if(strlen($producto->observaciones)>0){ ?>
        <label>Características</label>
        <span id="dato_tela"><?=$producto->observaciones;?></span>
        <?php } ?>
        <?php if($producto->talla_unica || strlen($producto->tallas)>0){ ?>
            <?php if($producto->talla_unica){ ?>
                <?php if(strlen($producto->tallas)>0){ ?>
                <label>Talla UNICA, sirve para:</label>
                <?php }else{ ?>
                <label>Talla UNICA</label>
                <?php } ?>
            <?php }else{ ?>
            <label>Tallas</label>
            <?php } ?>
            <?php if(strlen($producto->tallas)>0){ ?>
                <?php foreach(explode(',',trim($producto->tallas)) as $t){ ?>
                <?php if($t != '') { ?>
                <b id="dato_tallas"><?=$t;?></b>
                <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <label>Disponibilidad</label>
        <div id="dato_disponibilidad_<?=$producto->codigo;?>" class="dato_disponibilidad" style="display: block">
            <table id="disponibilidad">
                <?php foreach($disponibilidad as $talla => $colores){ ?>
                <tr>
                    <th><?=$talla;?></th>
                </tr>
                <?php foreach($colores as $color){ ?>
                <tr>
                    <td><?=$color['color'];?></td>
                </tr>
                <?php } ?>
                <?php } ?>
            </table>
        </div>
        <p style="color:red">
            <?php
                $alertas = [
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
                $alerta = $alertas[mt_rand(0,count($alertas)-1)];
                echo $alerta;
            ?>
        </p>
    </div>
</div>
<script>
    var mostrar_imagen = function(numero){
        $('#miniaturas img').css('opacity','0.5');
        $('#miniatura_' + numero).css('opacity','1');
        $('#imagen img').css('display','none');
        $('#imagen_' + numero).css('display','block');
        $('#imagen_' + numero).magnify();
    };
    $('#miniaturas img').hover(function(){
        mostrar_imagen($(this).attr('data-img'));
    });
    mostrar_imagen(1);
    //consultar('<?=$producto->codigo;?>');
</script>
