<?php
    $items = 1;
    if($novedad['video'] !== ''){
        $items++;
    }
?>
<div id="novedad">
    <h1><?=$novedad['titulo'];?></h1>
    <?php if($items > 0){ ?>
    <div class="multimedia">
        <div class="item">
            <img src="<?=base_url();?>catalogo/novedades/<?=$novedad['id'] . '-1';?>.jpg">
        </div>
        <?php if($novedad['video'] !== ''){ ?>
        <div class="item">
            <iframe width="420" height="315" src="https://www.youtube.com/embed/<?=$novedad['video'];?>" frameborder="0" allowfullscreen></iframe>
        </div>
        <?php } ?>
        <?php if($items > 1){ ?>
            <div class="navegacion">
                <div class="anterior"></div>
                <div class="siguiente"></div>
            </div>
        <?php } ?>
    </div>
    <?php } ?>
    <div class="contenido">
        <?=nl2br($novedad['contenido']);?>
        <br>
        <div style="width:100%;text-align:right">
        <div class="fb-share-button" data-href="http://lucymodas.com/site/novedades/<?=$novedad['id'];?>" data-layout="button_count" data-mobile-iframe="true"></div>
        </div>
    </div>
    <div class="comentarios">
        <h2>Deje su comentario</h2>
        <form method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Nombre y Apellido</td>
                    <td><input type="text" maxlength="255" name="nombre" required ></td>
                </tr>
                <tr>
                    <td>¿Que le pareció la noticia?</td>
                    <td>
                        <input type="hidden" name="reaccion" id="reaccion" value="">
                        <img class="reaccion" id="reaccion_me_gusta" src="/img/me_gusta.png" onclick="seleccionar('me gusta');">
                        <img class="reaccion" id="reaccion_me_encanta" src="/img/me_encanta.png" onclick="seleccionar('me encanta');">
                        <img class="reaccion" id="reaccion_me_divierte" src="/img/me_divierte.png" onclick="seleccionar('me divierte');">
                        <img class="reaccion" id="reaccion_me_asombra" src="/img/me_asombra.png" onclick="seleccionar('me asombra');">
                        <img class="reaccion" id="reaccion_me_entristece" src="/img/me_entristece.png" onclick="seleccionar('me entristece');">
                        <img class="reaccion" id="reaccion_me_enoja" src="/img/me_enoja.png" onclick="seleccionar('me enoja');">
                    </td>
                </tr>
                <tr>
                    <td>Comentario</td>
                    <td><textarea name="comentario" required ></textarea></td>
                </tr>
            </table>
            <button>Enviar</button>
        </form>
        <ul>
            <?php foreach($novedad['comentarios'] as $c) { ?>
            <li>
                <h3><?=$c['nombre'];?><?php if($c['reaccion'] !== ''){ ?> <img class="reaccion" src="/img/<?=str_replace(' ','_',$c['reaccion']);?>.png"><?php } ?></h3>
                <p><?=nl2br($c['comentario']);?></p>
            </li>
            <?php } ?>
        </ul>
    </div><!--
    --><div class="relacionadas">
        <h2>Notas relacionadas</h2>
        <ul>
            <?php foreach($novedad['relacionadas'] as $r){ ?>
            <li onclick="location.href='<?=base_url()?>site/novedades/<?=$r['id'];?>'">
                <div class="imagen"><img src="/catalogo/novedades/<?=$r['id'];?>.jpg"></div>
                <div class="titulo"><?=$r['titulo'];?>.jpg</div>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
<script type="text/javascript">
var item = 0;
var maxItem = <?=$items;?> - 1;
$('.multimedia .item').eq(0).show();
$('.anterior').click(function(){
    if(item > 0){
        item = item - 1;
    }else{
        item = maxItem;
    }
    $('.multimedia .item').hide();
    $('.multimedia .item').eq(item).show();
});
$('.siguiente').click(function(){
    if(item < maxItem){
        item = item + 1;
    }else{
        item = 0;
    }
    $('.multimedia .item').hide();
    $('.multimedia .item').eq(item).fadeIn();
});
function seleccionar(reaccion){
    $('#reaccion').val(reaccion);
    $('.reaccion').removeClass('activo');
    $('#reaccion_'+reaccion.replace(' ','_')).addClass('activo');
}
</script>
