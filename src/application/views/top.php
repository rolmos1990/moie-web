<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Lucy Modas Colombia<?php if(isset($categoria)){ echo ' - ' . $categoria->nombre; }?></title>

        <!--[if IE]>
        <link href="/css/estilo_ie.css?201604301500" rel="stylesheet"/></script>
        <![endif]-->
        <!--[if !IE]>
            <!--><link href="/css/estilo.css?201711090555" rel="stylesheet" /></script><!-->
        <![endif]-->

        <link href="/css/representantes.css?201509221830" rel="stylesheet" /></script>
        <link href="/css/producto.css?201508101350" rel="stylesheet" />
        <link href="/css/magnify.css" rel="stylesheet" />
        <?php if(0){ ?>
            <link href="/css/tema.css?201503180900" rel="stylesheet" />
        <?php } ?>
        <link href="/css/colorbox/colorbox.css?201508102010" rel="stylesheet">
        <!--[if IE]>
            <script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
        <![endif]-->
        <!--[if !IE]>
            <!--><script type="text/javascript" src="/js/jquery-2.1.1.min.js"></script><!-->
        <![endif]-->
      
        <script type="text/javascript" src="/js/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
        <script type="text/javascript" src="/js/jquery.magnify.js"></script>
        <script type="text/javascript" src="/js/jquery.validate.js"></script>
        <script type="text/javascript" src="/js/messages_es.js"></script>

        <script type="text/javascript" src="/js/jqFancyTransitions.1.8.js"></script>
        <script type="text/javascript" src="/js/site.js?201508191700"></script>
        <script type="text/javascript" src="/js/consultar.js?201508241630"></script>

        <link href="/css/flipclock.css?201503180900" rel="stylesheet">
        <script type="text/javascript" src="/js/flipclock.min.js?201503180900"></script>

        <link rel="shortcut icon" href="/img/favicon.ico" type="image/icon">
        <link rel="icon" href="/img/favicon.ico" type="image/icon">
        <script type="text/javascript">
            $(function(){
                    $('#thickboxButton').click(function(){
                            $('#thickboxId').click();
                    });
            });
        </script>

	<!--Start of Zopim Live Chat Script-->
	<script type="text/javascript">
	window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
	d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
	_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
	$.src="//v2.zopim.com/?3DrrDF5N0cOyuRB4ZvQ22vjlnbgGfxJm";z.t=+new Date;$.
	type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
	</script>
	<!--End of Zopim Live Chat Script-->

    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '2559315640820044');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=2559315640820044&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->

    </head>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-74610724-1', 'auto');
  ga('send', 'pageview');

</script>
    <body>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.6&appId=772815182729618";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
<!--        <div id="franja_superior">
            <b id="titulo_reloj"><?=$config['reloj_mensaje'];?></b>
            <div class="clock" style="margin:2em;"></div>
        </div>-->
        <div id="tema">
            <img id="esquina_izq" src="<?=base_url();?>img/tema/esquina_izq.png">
            <img id="esquina_der" src="<?=base_url();?>img/tema/esquina_der.png">
        </div>
        <div id="header">
            <menu id="superior">
                <div id="bandera"><img src="/img/bandera.png" /><span>MEDELLÍN<br>(4) 5564365</span></div>
                <ul>
                    <li onclick="location.href='<?=base_url();?>site/quienes_somos'">¿Quiénes Somos?</li><!--
                    --><li onclick="location.href='<?=base_url();?>site/como_comprar'">¿Cómo Comprar?</li><!--
                    --><li onclick="location.href='<?=base_url();?>site/preguntas_frecuentes'">Preguntas Frecuentes</li><!--
                    --><li onclick="window.open('https://www.facebook.com/lucymodascolombia')"><img src="/img/fb-verificacion.png?20171109" alt="verificacion facebook"></li>
                </ul>
                <!--<div id="juego">
                    <?php
                        $semilla = intval(date('Ymd'));
                        mt_srand($semilla);
                        $numero = mt_rand(0,999);
                        echo 'Hoy juega <b>'. str_pad($numero, 3, '0', STR_PAD_LEFT) . '<b>';
                    ?>
                </div>-->
                <div class="redes">
                    <span class="link" onclick="window.open('https://www.facebook.com/lucymodascolombia')">
                        <img src="/img/fb.png"><b>lucymodascolombia</b>
                    </span>
                    <span class="link" onclick="window.open('https://www.instagram.com/lucymodascolombia')">
                        <img src="/img/in.png"><b>lucymodascolombia</b>
                    </span>
                    <!--<span>
                        <img src="/img/tw.png"><b>@Lucymodascol</b>
                    </span>-->
                    <span>
                        <img src="/img/tl.png"><b>304.283.96.82</b>
                    </span>
                    <!--<span>
                        <img src="/img/bb.png"><b>58A448B0</b>
                    </span>-->
                </div>
            </menu>
            <div id="logo_grande" onclick="location.href='<?=base_url();?>'">
            </div>
            <?php if(isset($representantes)){ ?>
            <menu id="principal">
                <ul>
                    <li onclick="location.href='/representantes/'">INICIO</li>
                    <li onclick="location.href='/representantes/mision_vision'">MISIÓN / VISION</li>
                    <li onclick="location.href='/representantes/negocio'">¿EN QUÉ CONSISTE EL NEGOCIO?</li>
                    <li onclick="location.href='../../catalogo'">CATÁLOGO</li>
                    <li onclick="location.href='/site/'">VER PRODUCTOS</li>
                    <li onclick="location.href='/representantes/registro'" class="link_pago">LLENE EL FORMULARIO</li>
                </ul>
            </menu>
            <?php }else{ ?>
            <menu id="principal">
                <ul>
                    <?php
                        $cantidad_categorias = count($categorias);
                        $ancho_menu = floor((1000-($cantidad_categorias+4))/($cantidad_categorias+3));
                    ?>
                    <li onclick="location.href='/site/'">INICIO</li><!--
                    --><?php foreach($categorias as $c){ ?><!--
                    --><li onclick="location.href='/site/productos/<?=$c->id;?>'"><?=$c->nombre;?></li><!--
                    --><?php } ?><!--
                    --><!-- <li onclick="location.href='/site/productos/mayor'">COMPRAS AL MAYOR</li> --><!--
                    <li onclick="location.href='/representantes/'">REPRESENTANTES</li>
                    <li onclick="location.href='/site/novedades'">NOVEDADES</li>-->
                    <!-- <li class="link_pago" onclick="location.href='/site/pago'">REPORTAR PAGO</li> -->
                </ul>
            </menu>
            <?php } ?>
        </div>
        <div id="rastreo" class="pestana_izq" onclick="window.location.href='<?=base_url();?>site/tracking'">
            Rastrea tu Paquete
        </div>
        <div id="comentario" class="pestana_izq" onclick="window.location.href='<?=base_url();?>site/comentarios'">
            Comentarios y Testimonios
        </div>
