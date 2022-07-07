<div id="producto">
    <div id="miniaturas">
        <?php
        $img = array(3);
        $imagenes = intval($producto->imagenes);
        if($imagenes - 4 >= 0){
            $img[2] = 1;
            $imagenes = $imagenes - 4;
        }else{
            $img[2] = 0;
        }
        if($imagenes - 2 >= 0){
            $img[1] = 1;
            $imagenes = $imagenes - 2;
        }else{
            $img[1] = 0;
        }
        if($imagenes - 1 >= 0){
            $img[0] = 1;
        }else{
            $img[0] = 0;
        }
        for($i=0;$i<count($img);$i++){
            if($img[$i]){ $j = $i+1; ?>
        <img id="miniatura_<?=$j;?>" data-img="<?=$j;?>" src="<?=base_url() . 'catalogo/' . $producto->id_categoria . '/' . $producto->codigo . '_' . $j . '_67.jpg';?>" alt="<?=$producto->codigo;?>" height="100">
        <?php } } ?>
    </div>
    <div id="imagen">
        <?php for($i=1;$i<=$producto->imagenes;$i++){?>
        <img id="imagen_<?=$i;?>" src="<?=base_url() . 'catalogo/' . $producto->id_categoria . '/' . $producto->codigo . '_' . $i . '_400.jpg';?>" alt="<?=$producto->codigo;?>" height="600" data-magnify-src="<?=base_url() . 'catalogo/' . $producto->id_categoria . '/' . $producto->codigo . '_' . $i . '_800.jpg';?>" alt="<?=$producto->codigo;?>">
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
                <?php foreach(explode('-',trim($producto->tallas)) as $t){ ?>
                <b id="dato_tallas"><?=$t;?></b>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <label>Disponibilidad</label>
        <!--<div id="cargando_disponibilidad">
            <img src="<?=base_url();?>img/cargando.gif" alt="cargando" /><br>
            <b>Cargando disponibilidad</b>
        </div>-->
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


<!--    <div id="compartir">
        <h2>Compartir</h2>
        <div onclick="window.open('http://www.facebook.com/sharer/sharer.php?u=http://lilicardenasmodas.com/','Compartir','width=600,height=400')" class="compartir fondo_facebook"><img src="<?=base_url();?>img/fb_blanco.png"></div>
        <div onclick="window.open('http://twitter.com/home?status=Mira%20la%20bella%20ropa%20que%20traje%20para%20ti:%20http://lilicardenasmodas.com/','Compartir','width=600,height=400')" class="compartir fondo_twitter"><img src="<?=base_url();?>img/tw_blanco.png"></div>
    </div>-->
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