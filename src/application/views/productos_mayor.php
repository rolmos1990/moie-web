        <div id="titulo_categoria" style="background:url('<?=base_url() . 'catalogo/mayor/config/encabezado.jpg?' . mdate('%Y%m%d%H');?>') no-repeat">
            <div class="video">
                <video width="300" height="210" autoplay loop>
                    <source src="<?=base_url();?>vid/lucy.mp4" type="video/mp4">
                </video>
                <div class="texto">
                    <b>Sede principal Lucy Modas</b><br>
                    <cite>Medellín - Colombia</cite>
                </div>
            </div>
        </div>
        <div id="productos">
            <?php foreach($productos as $p){ ?><!--
            --><div class="producto" href="<?=base_url();?>site/producto_mayor/<?=$p->codigo;?>">
                <div class="ver_mas"><span>VER TALLAS</span></div>
                <div class="producto_imagen">
                    <?php if($p->imagenes > 0){ ?>
                    <img src="<?=base_url() . 'catalogo/' . $p->id_categoria . '/' . $p->codigo;?>_1_238.jpg" width="238" height="357">
                    <?php
                    }
                    if($p->imagenes == 3 || $p->imagenes == 7){ ?>
                    <img src="<?=base_url() . 'catalogo/' . $p->id_categoria . '/' . $p->codigo;?>_2_238.jpg" width="238" height="357">
                    <?php } ?>
                </div>
                <div class="producto_datos">
                    <div class="producto_codigo"><?=$p->tipo;?>: <span><?=str_replace("_","",$p->codigo);?></span></div>
                    <?php if($p->cantidad_mayor_2 > 0){ ?>
                    <div class="producto_precio_mayor">De <?=$p->cantidad_mayor_1;?> a <?=$p->cantidad_mayor_2 - 1;?> piezas: <b><?=$p->precio_descuento_mayor_1;?></b></div>
                    <div class="producto_precio_mayor">Desde <?=$p->cantidad_mayor_2;?> piezas: <b><?=$p->precio_descuento_mayor_2;?></b></div>
                    <?php }else{ ?>
                    <div class="producto_precio_mayor">Desde <?=$p->cantidad_mayor_1;?> piezas: <b><?=$p->precio_descuento_mayor_1;?></b></div>
                    <?php } ?>
                </div>
            </div><!--
            --><?php } ?>
        </div>
        <?php if($ver){ ?>
            <script>
                $.colorbox({href:'<?=base_url() . 'site/producto_mayor/' . $ver;?>',fixed:'true'});
            </script>
        <?php } ?>
        <script>
            $('.producto').colorbox({rel:'producto',fixed:'true'});
        </script>