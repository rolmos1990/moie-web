<div id="preguntas_frecuentes">
    <?php if($success){ ?>
        <h1>Felicidades!</h1>
        <br />
        <div class="pregunta">
           <p>
               <b>Hola <?=$name;?></b>!, Su pago ha sido completado de forma exitosa!
           </p>
           <p>
               Por los momentos estare preparando tu pedido: <b><?=$description;?></b>, 
           </p>
        </div>   
    <?php } ?>
    <?php if(!$success){ ?>
        <h1>Ups!</h1>
        <br />
        <div class="pregunta">
           <p>
               <b>Hola <?=$name;?></b>!, lo sentimos tu pago no ha podido ser completado.
           </p>
           <p>
              Te recomentamos verifiques con tu banco emisor o verifiques los datos de tu tarjeta e intentas nuevamente., 
           </p>
        </div>   
    <?php } ?>
</div><!-- Superior -->
