<div class="content">
    <?php foreach($categorias as $c){ ?>
    <div class="item">
        <a href="<?=base_url() . 'liliapp/productos/' . $c->id;?>">
            <h4><?=$c->nombre;?></h4>
            <img src="<?=base_url() . 'catalogo/' . $c->id;?>/config/portada.png" width="255" alt="<?=$c->nombre;?>">
        </a>
    </div>
    <?php } ?>
    <div class="item">
        <a href="<?=base_url() . 'liliapp/productos/mayor';?>">
            <h4>COMPRAS AL MAYOR</h4>
            <img src="<?=base_url() . 'catalogo/mayor';?>/config/portada.png" width="255" alt="COMPRAS AL MAYOR">
        </a>
    </div>
    <div class="item">
        <a class='youtube' href="https://www.youtube.com/embed/7yK7WV5863g?rel=0&amp;wmode=transparent&amp;autoplay=1">
            <img src="<?=base_url()?>img/video.jpg" width="255" alt="¿Cómo comprar?">
        </a>
    </div>
</div>
<script>
    $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
</script>
