<section>
    <?php foreach($productos as $p){ ?>
    <article onclick="$.colorbox({href:'<?=base_url();?>liliapp/producto_mayor/<?=$p->codigo;?>',fixed:'true'})">
        <?php if($p->imagenes > 0){ ?>
        <img src="<?=base_url() . 'catalogo/' . $p->id_categoria . '/' . $p->codigo;?>_1_238.jpg">
        <?php }else{ ?>

        <?php } ?>
        <div class="producto_datos">
            <div class="producto_codigo"><?=$p->tipo;?>: <span><?=str_replace("_","",$p->codigo);?></span></div>
            <?php if($p->cantidad_mayor_2 > 0){ ?>
            <div class="producto_precio_mayor">De <?=$p->cantidad_mayor_1;?> a <?=$p->cantidad_mayor_2 - 1;?> piezas: <b><?=$p->precio_descuento_mayor_1;?></b></div>
            <div class="producto_precio_mayor">Desde <?=$p->cantidad_mayor_2;?> piezas: <b><?=$p->precio_descuento_mayor_2;?></b></div>
            <?php }else{ ?>
            <div class="producto_precio_mayor">Desde <?=$p->cantidad_mayor_1;?> piezas: <b><?=$p->precio_descuento_mayor_1;?></b></div>
            <?php } ?>
        </div>
    </article>
    <?php } ?>
    <script>
        $('.cb').colorbox({rel:'cb', transition:"fade"});
    </script>
</section>