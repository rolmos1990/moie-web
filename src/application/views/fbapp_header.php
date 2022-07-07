<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Catálogo en línea Lucy Modas Colombia</title>
        <link href="<?=base_url();?>css/fbapp.css?201503180900" rel="stylesheet">
        <link href="<?=base_url();?>css/producto.css?201503180900" rel="stylesheet">
        <link href="<?=base_url();?>css/colorbox/colorbox.css" rel="stylesheet">
        <link href="<?=base_url();?>css/magnify.css" rel="stylesheet" />
        <script type="text/javascript" src="<?=base_url();?>js/jquery.js"></script>
        <script type="text/javascript" src="<?=base_url();?>js/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="<?=base_url();?>js/jquery.magnify.js"></script>
        <script type="text/javascript" src="<?=base_url();?>js/consultar.js"></script>
</head>
<body>
<script>
window.fbAsyncInit = function() {
  FB.init({
    appId      : '1661224230759366',
    xfbml      : true,
    version    : 'v2.4'
  });

  // ADD ADDITIONAL FACEBOOK CODE HERE
};

(function(d, s, id){
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "//connect.facebook.net/en_US/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
 }(document, 'script', 'facebook-jssdk'));
</script>
    <?php if(isset($mayor) || isset($categoria)){ ?>
    <nav>
        <ul>
            <li><a href="<?=base_url() . 'liliapp/';?>">INICIO</a></li>
            <?php foreach($categorias as $c){ ?>
            <li>
                <a <?php if(isset($categoria)){if($categoria->id==$c->id){ echo 'class="seleccionado"'; }}?> href="<?=base_url() . 'liliapp/productos/' . $c->id;?>"><?=$c->nombre;?></a>
            </li>
            <?php } ?>
            <li><a <?php if(isset($mayor)){ echo 'class="seleccionado"'; }?> href="<?=base_url() . 'liliapp/productos/mayor';?>">COMPRAS AL MAYOR</a></li>
            <li><a class='youtube' href="https://www.youtube.com/embed/rd6u2KpovuM?rel=0&amp;wmode=transparent&amp;autoplay=1">¿CÓMO COMPRAR?</a></li>
        </ul>
        </a>
    </nav>
    <?php } ?>
<script>
$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390,fixed:true});
</script>