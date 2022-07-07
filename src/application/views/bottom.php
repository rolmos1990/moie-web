<div id="footer">
    <div class="article logo"><img src="/img/logo_bolsa.png" alt="logo"></div><!--
    --><div class="article">
        <h3>SIGUENOS EN NUESTRAS REDES SOCIALES</h3>
        <span>
            <img src="/img/fb.png">lucymodascolombia
        </span>
        <span>
            <img src="/img/in.png">lucymodascolombia
        </span>
        <span>
            <img src="/img/tl.png">317.568.71.13
        </span>
    </div><!--
    --><div class="article">
        <h3>¿TE GUSTÓ LA EXPERIENCIA?</h3>
        <h3>DEJA TU TESTIMONIO</h3>
        <button class="testimonio" onclick="location.href='<?=base_url();?>site/comentarios'"><span>TESTIMONIOS</span></button><br><br>
        <img style="margin-left: 27px" src="/img/sello_garantia.png" alt="100% garantizado" />
    </div><!--
    --><div class="article" id="email_promo_article">
        <?php if(!$this->session->userdata('email_promo')){ ?>
        <h3>REGISTRATE PARA RECIBIR NUESTRAS PROMOCIONES</h3>
        <input type="text" id="email_promo" placeholder="ESCRIBE TU CORREO ELECTRÓNICO" /><button id="enviar_promo" onclick="enviar_email()"><img src="/img/sobre.png"></button>
        <?php }else{ ?>
        <h3>TU CORREO ELECTRONICO HA SIDO REGISTRADO PARA RECIBIR NUESTRAS PROMOCIONES</h3>
        <?php } ?>
    </div>
</div>
<div style="position:fixed;bottom:20px;">
    <div style="margin-left:30px;">
    <a href="/site/politicas_envios" style="cursor:pointer;color:gray;">Políticas de envio</a> | <a href="/site/politicas_cambios" style="cursor:pointer;color:gray;">Políticas de cambio</a>
    </div>
</div>
<div id="barra_reputacion">
</div>

        <script>
            $('.rep').colorbox({rel:'cb', transition:"fade"});
            $("img.lazy").lazyload({threshold : 800});
            $(function(){
                var id=1;
                window.setInterval(function(){
                if(id==1){
                    $('#atencion').css('background-color','#fff');
                    id=2;
                }else{
                    $('#atencion').css('background-color','rgb(254, 29, 197)');
                    id=1;
                }
                },1000);
            });
            $(function(){
                var i=0;
                $('#descarga img').eq(i).css('display','block');
                window.setInterval(function(){
                    i++;
                    if(i>=$('#descarga img').size()){
                        i=0;
                    }
                    $('#descarga img').css('display','none');
                    $('#descarga img').eq(i).css('display','block');
                },4000);
            });
            reputacion();
        </script><script>
        $(function(){
            var id=0;
            window.setInterval(function(){
                if(id<=20){
                    $('.link_pago').css('background-color','#64ff00');
                }else if(id>20 && id<=40){
                    $('.link_pago').css('background-color','#ffcc00');
                }else{
                    id=0;
                }
                id++;
            },50);
        });    
        </script>
    </body>
</html>
