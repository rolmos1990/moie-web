<section>
    <?php foreach($productos as $p){ ?>
    <article onclick="$.colorbox({href:'<?=base_url();?>liliapp/producto_mayor/<?=$p->codigo;?>',fixed:'true'})">
        <?php if($p->imagenes > 0){ ?>
        <img src="<?=base_url() . 'catalogo/' . $p->id_categoria . '/' . $p->codigo;?>_1_238.jpg">
        <?php }else{ ?>

        <?php } ?>
        <div class="producto_datos">
            <div class="producto_codigo"><?=$p->tipo;?>: <span><?=str_replace("_","",$p->codigo);?></span></div>
        </div>
    </article>
    <?php } ?>
    <script>
        $('.cb').colorbox({rel:'cb', transition:"fade"});
    </script>
</section>
