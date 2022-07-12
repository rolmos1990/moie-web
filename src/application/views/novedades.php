        <div id="titulo_categoria" style="background:url('<?=base_catalog_url() . '/novedades/config/encabezado.jpg?' . mdate('%Y%m%d%H');?>') no-repeat">
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
        <div id="novedades">
            <?php foreach($novedades as $n){ ?>
            <div class="novedad" onclick="location.href='<?=base_url();?>site/novedades/<?=$n['id'];?>'">
                <div class="imagen"><img src="<?=base_catalog_url() . '/novedades/' . $n['id'] . '.jpg?' . mdate('%Y%m%d%H');?>"></div>
                    
                <div class="titulo"><?=$n['titulo'];?></div>
                <div class="vista_previa">
                    <h4><?=$n['titulo'];?></h4>
                    <p><?=$n['vista_previa'];?>...</p>
                    <div class="reacciones">
                        <?php foreach($n['reacciones'] as $r){ ?>
                        <span><img src="/img/<?=str_replace(' ','_',$r['reaccion']);?>.png"><?=$r['cantidad'];?></span>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <script>
            $('.novedad').on('mouseover',function(){
                $(this).children('.vista_previa').slideDown();
            });
            $('.novedad').on('mouseleave',function(){
                $(this).children('.vista_previa').slideUp();
            });
        </script>
