<div id="infografia_mayor">
    <div id="img_premarketing" style="width:50%;min-height: 500px;float:left;">
        <img src="" alt="imagen_premarketing">
    </div>
    <div id="from_premarketing" style="width:50%;float:left;">
        <h1 style="text-align:center">Ingresa tus datos</h1>
        <p style="font-size:16px;">Te contactaremos para hacerte saber cuando llegue o lo que sea</p>
        <form method="post" action="<?=base_url();?>site/guardar_premarketing" style="text-align:center;">
            <input type="text" name="nombre" placeholder="Nombre y Apellido" autocomplete="off" style="font-size:25px;margin-top:15px;width:100%"><br>
            <input type="number" name="telefono" placeholder="Teléfono Celular" autocomplete="off" style="font-size:25px;margin-top:15px;width:100%">
            <input type="submit" class="como_comprar" value="Aceptar" style="font-size:25px;margin-top:15px;width:50%;">
        </form>
    </div>
</div>
    