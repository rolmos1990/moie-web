<section>
    <?php foreach($productos as $p){ ?>
    <article onclick="$.colorbox({href:'<?=base_url();?>liliapp/producto/<?=$p->codigo;?>',fixed:'true'})">
        <?php if($p->imagenes > 0){ ?>
        <img src="<?=base_url() . 'catalogo/' . $categoria->id . '/' . $p->codigo;?>_1_238.jpg">
        <?php }else{ ?>

        <?php } ?>
        <div class="producto_datos">
            <div class="producto_codigo"><?=$p->tipo;?>: <span><?=str_replace("_","",$p->codigo);?></span></div>
            <div class="producto_precio"><span><?=$p->precio;?></span>&nbsp;&nbsp;&nbsp;<b><?=$p->precio_descuento;?></b></div>
        </div>
    </article>
    <?php } ?>
    <script>
        $('.cb').colorbox({rel:'cb', transition:"fade"});
    </script>
</section>