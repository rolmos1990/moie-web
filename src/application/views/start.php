        <?php if($config['promo']=='SI'){ ?>
        <div id="promo"><img src="<?=base_url();?>img/promo/promo<?=mdate('%d-%m-%y');?>.png" alt="promo"></div>
        <script>
        $('#promo').click(function(){
            $('#promo').fadeOut();
        });
        </script>
        <?php } ?>
        <div id="slider_wrap">
            <div id="slider">
                <?php foreach($slides as $s){
                    $archivo=$s->nombre;
                    $enlace=$s->enlace;
                    $enlace=base_url() . 'site/' . $enlace;
                ?>
                <img src="<?=base_url();?>catalogo/slider/<?=$archivo;?>" alt="<?=$archivo;?>">
                <a href="<?=$enlace;?>"></a>
                <?php } ?>
            </div>
            <div>
                <div id="info1">
                    <div class="video">
                        <video width="352" height="200" autoplay loop>
                            <source src="<?=base_url();?>vid/lucy.mp4" type="video/mp4">
                        </video>
                        <div class="texto">
                            <b>Sede principal Lucy Modas</b><br>
                            <cite>Medellín - Colombia</cite>
                        </div>
                    </div>
                </div>
                <div id="info2">
                    <img src="<?=base_url();?>img/novedades.png?201607291545" alt="novedades.png" onclick="location.href='<?=base_url();?>site/novedades'">
                </div>
            </div>
<!--            <div id="info1">
                    <iframe src="<?=$config['video'];?>" width="352" height="198" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                <img src="<?=base_url();?>img/whatsapp352.jpg" alt="whatsapp352.jpg">
            </div>
            <div id="info2">
                <?php foreach($banner as $s){ ?>
                    <img src="<?=base_url();?>catalogo/banner/<?=$s->nombre;?>" alt="<?=$s->nombre;?>">
                <?php } ?>
            </div>-->
        </div>
        <div id="subtitulo"><span>NUESTROS PRODUCTOS</span></div>
        <div id="especiales">
            <?php foreach($categorias as $c){ ?>
                <a href="<?=base_url() . 'site/productos/' . $c->id;?>"><img src="<?=base_catalog_url() . 'categories/' .$c->filename;?>?<?=mdate('%Y%m%d%H');?>" width="326" height="160" alt="<?=$c->nombre;?>"><h4><?=$c->nombre;?></h4></a>
            <?php } ?>
                <!-- <a href="<?=base_url() . 'site/productos/mayor';?>"><img src="<?=base_url() . 'catalogo/mayor';?>/config/portada.png?<?=mdate('%Y%m%d%H');?>" width="326" height="160" alt="COMPRAS AL MAYOR"><h4>COMPRAS AL MAYOR</h4></a> -->
        </div>







        <div id="centro"><img src="<?=base_url();?>img/tema/tema.png?201503180900"></div>
        <script>
        $('#slider').jqFancyTransitions({ width: 840, height: 400, links: true, titleOpacity: 0, navigation: true });
        function cambiar_info2(num_info2){
            $('#info2 img').css('display','none');
            $('#info2 img:nth-child(' + num_info2 + ')').fadeIn();
            if(num_info2 < $('#info2 img').size()){
                num_info2++;
            }else{
                num_info2=1;
            }
            window.setTimeout(function(){
                cambiar_info2(num_info2);
            },15000);
        }
        cambiar_info2(1);
        /*$.colorbox({href:'/img/vacaciones.jpg'});*/
        </script>
