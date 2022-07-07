<div id="pago_wrap">
    <div id="pago">
        <h1>Bienvenid@ al sistema de reporte de pagos de Lucy Modas Colombia</h1>
        <p>A continuación, llene el formulario con la información correspondiente al 
            pago que realizó. Recuerde colocar un número de <strong>teléfono celular</strong> 
            y una dirección de <strong>correo electrónico</strong> válidos
            para recibir la notificación del envío de su pedido</p>
        <form method="POST" action="<?=base_url();?>site/pago">
            <label for="nombre">Nombre completo de la persona que realiza el pedido</label>
            <input type="text" name="nombre" id="nombre" placeholder="" autocomplete="off" <?php if(isset($nombre)){ echo 'value="' . $nombre['data'] . '"'; } ?>>
            <?php if(isset($nombre['error'])){ ?>
            <span class="error"><?=$nombre['error'];?></span>
            <?php } ?>

            <label for="telefono">Número de Teléfono celular</label>
            <input type="text" name="telefono" id="telefono" placeholder="Ej.: 3005550000" maxlength="13" autocomplete="off" <?php if(isset($telefono)){ echo 'value="' . $telefono['telefono'] . '"'; } ?>>
            <?php if(isset($telefono['error'])){ ?>
            <span class="error"><?=$telefono['error'];?></span>
            <?php } ?>

            <label for="email">Correo Electrónico</label>
            <input type="text" name="email" id="email" placeholder="Ej.: ejemplo@gmail.com" maxlength="255" autocomplete="off" <?php if(isset($email)){ echo 'value="' . $email['data'] . '"'; } ?>>
            <?php if(isset($email['error'])){ ?>
            <span class="error"><?=$email['error'];?></span>
            <?php } ?>

            <label for="forma">Forma de Pago</label>
            <select name="forma" id="forma" autocomplete="off">
                <option value="Depósito" <?php if(isset($forma)){ if($forma['data']=='Consignación'){ echo 'selected'; }} ?>>Consignación</option>
                <option value="Transferencia Bancaria" <?php if(isset($forma)){ if($forma['data']=='Transferencia Bancaria'){ echo 'selected'; }} ?>>Transferencia Bancaria</option>
            </select>
            <label for="origen" id="label_origen" style="width:100%">Origen de la transferencia</label>
            <label for="banco" id="label_banco">Banco</label>

            <select name="origen" id="origen" autocomplete="off">
                <option value="seleccionar">Seleccionar</option>
                <option value="Nequi" <?php if(isset($origen)){ if($origen['data']=='Nequi'){ echo 'selected'; }} ?>>Nequi</option>
                <option value="Daviplata" <?php if(isset($origen)){ if($origen['data']=='Daviplata'){ echo 'selected'; }} ?>>Daviplata</option>
                <option value="Aportes en Línea" <?php if(isset($origen)){ if($origen['data']=='Aportes en Línea'){ echo 'selected'; }} ?>>Aportes en Línea</option>
                <option value="Asopagos" <?php if(isset($origen)){ if($origen['data']=='Asopagos'){ echo 'selected'; }} ?>>Asopagos</option>
                <option value="Banco Agrario de Colombia" <?php if(isset($origen)){ if($origen['data']=='Banco Agrario de Colombia'){ echo 'selected'; }} ?>>Banco Agrario de Colombia</option>
                <option value="Banco AV Villas" <?php if(isset($origen)){ if($origen['data']=='Banco AV Villas'){ echo 'selected'; }} ?>>Banco AV Villas</option>
                <option value="Banco BBVA" <?php if(isset($origen)){ if($origen['data']=='Banco BBVA'){ echo 'selected'; }} ?>>Banco BBVA</option>
                <option value="Banco BCSC" <?php if(isset($origen)){ if($origen['data']=='Banco BCSC'){ echo 'selected'; }} ?>>Banco BCSC</option>
                <option value="Banco Citibank" <?php if(isset($origen)){ if($origen['data']=='Banco Citibank'){ echo 'selected'; }} ?>>Banco Citibank</option>
                <option value="Banco Compartir" <?php if(isset($origen)){ if($origen['data']=='Banco Compartir'){ echo 'selected'; }} ?>>Banco Compartir</option>
                <option value="Banco Coopcentral" <?php if(isset($origen)){ if($origen['data']=='Banco Coopcentral'){ echo 'selected'; }} ?>>Banco Coopcentral</option>
                <option value="Banco Credifinanciera S.A.C.F" <?php if(isset($origen)){ if($origen['data']=='Banco Credifinanciera S.A.C.F'){ echo 'selected'; }} ?>>Banco Credifinanciera S.A.C.F</option>
                <option value="Banco Davivienda" <?php if(isset($origen)){ if($origen['data']=='Banco Davivienda'){ echo 'selected'; }} ?>>Banco Davivienda</option>
                <option value="Banco de Bogotá" <?php if(isset($origen)){ if($origen['data']=='Banco de Bogotá'){ echo 'selected'; }} ?>>Banco de Bogotá</option>
                <option value="Banco de la República" <?php if(isset($origen)){ if($origen['data']=='Banco de la República'){ echo 'selected'; }} ?>>Banco de la República</option>
                <option value="Banco de Occidente" <?php if(isset($origen)){ if($origen['data']=='Banco de Occidente'){ echo 'selected'; }} ?>>Banco de Occidente</option>
                <option value="Banco Falabella" <?php if(isset($origen)){ if($origen['data']=='Banco Falabella'){ echo 'selected'; }} ?>>Banco Falabella</option>
                <option value="Banco Finandina" <?php if(isset($origen)){ if($origen['data']=='Banco Finandina'){ echo 'selected'; }} ?>>Banco Finandina</option>
                <option value="Banco GNB Sudameris" <?php if(isset($origen)){ if($origen['data']=='Banco GNB Sudameris'){ echo 'selected'; }} ?>>Banco GNB Sudameris</option>
                <option value="Banco Itaú Corpbanca Colombia S.A." <?php if(isset($origen)){ if($origen['data']=='Banco Itaú Corpbanca Colombia S.A.'){ echo 'selected'; }} ?>>Banco Itaú Corpbanca Colombia S.A.</option>
                <option value="Banco Multibank S.A." <?php if(isset($origen)){ if($origen['data']=='Banco Multibank S.A.'){ echo 'selected'; }} ?>>Banco Multibank S.A.</option>
                <option value="Banco Mundo mujer " <?php if(isset($origen)){ if($origen['data']=='Banco Mundo mujer '){ echo 'selected'; }} ?>>Banco Mundo mujer </option>
                <option value="Banco Pichincha" <?php if(isset($origen)){ if($origen['data']=='Banco Pichincha'){ echo 'selected'; }} ?>>Banco Pichincha</option>
                <option value="Banco Popular" <?php if(isset($origen)){ if($origen['data']=='Banco Popular'){ echo 'selected'; }} ?>>Banco Popular</option>
                <option value="Banco Santander de Negocios Colombia S.A." <?php if(isset($origen)){ if($origen['data']=='Banco Santander de Negocios Colombia S.A.'){ echo 'selected'; }} ?>>Banco Santander de Negocios Colombia S.A.</option>
                <option value="Banco Serfinanza" <?php if(isset($origen)){ if($origen['data']=='Banco Serfinanza'){ echo 'selected'; }} ?>>Banco Serfinanza</option>
                <option value="Bancoldex" <?php if(isset($origen)){ if($origen['data']=='Bancoldex'){ echo 'selected'; }} ?>>Bancoldex</option>
                <option value="Bancolombia" <?php if(isset($origen)){ if($origen['data']=='Bancolombia'){ echo 'selected'; }} ?>>Bancolombia</option>
                <option value="Bancoomeva" <?php if(isset($origen)){ if($origen['data']=='Bancoomeva'){ echo 'selected'; }} ?>>Bancoomeva</option>
                <option value="BNP Paribas" <?php if(isset($origen)){ if($origen['data']=='BNP Paribas'){ echo 'selected'; }} ?>>BNP Paribas</option>
                <option value="Coltefinanciera" <?php if(isset($origen)){ if($origen['data']=='Coltefinanciera'){ echo 'selected'; }} ?>>Coltefinanciera</option>
                <option value="Compensar" <?php if(isset($origen)){ if($origen['data']=='Compensar'){ echo 'selected'; }} ?>>Compensar</option>
                <option value="Confiar Cooperativa Financiera" <?php if(isset($origen)){ if($origen['data']=='Confiar Cooperativa Financiera'){ echo 'selected'; }} ?>>Confiar Cooperativa Financiera</option>
                <option value="Cooperativa Financiera Cotrafa" <?php if(isset($origen)){ if($origen['data']=='Cooperativa Financiera Cotrafa'){ echo 'selected'; }} ?>>Cooperativa Financiera Cotrafa</option>
                <option value="Cooperativa Financiera de Antioquia" <?php if(isset($origen)){ if($origen['data']=='Cooperativa Financiera de Antioquia'){ echo 'selected'; }} ?>>Cooperativa Financiera de Antioquia</option>
                <option value="Deceval" <?php if(isset($origen)){ if($origen['data']=='Deceval'){ echo 'selected'; }} ?>>Deceval</option>
                <option value="Dirección del Tesoro Nacional" <?php if(isset($origen)){ if($origen['data']=='Dirección del Tesoro Nacional'){ echo 'selected'; }} ?>>Dirección del Tesoro Nacional</option>
                <option value="Dirección del Tesoro Nacional- Regalias" <?php if(isset($origen)){ if($origen['data']=='Dirección del Tesoro Nacional- Regalias'){ echo 'selected'; }} ?>>Dirección del Tesoro Nacional- Regalias</option>
                <option value="Enlace Operativo S.A." <?php if(isset($origen)){ if($origen['data']=='Enlace Operativo S.A.'){ echo 'selected'; }} ?>>Enlace Operativo S.A.</option>
                <option value="Fedecajas" <?php if(isset($origen)){ if($origen['data']=='Fedecajas'){ echo 'selected'; }} ?>>Fedecajas</option>
                <option value="Financiera Juriscoop" <?php if(isset($origen)){ if($origen['data']=='Financiera Juriscoop'){ echo 'selected'; }} ?>>Financiera Juriscoop</option>
                <option value="Jp Morgan" <?php if(isset($origen)){ if($origen['data']=='Jp Morgan'){ echo 'selected'; }} ?>>Jp Morgan</option>
                <option value="Red Multibanca Colpatria" <?php if(isset($origen)){ if($origen['data']=='Red Multibanca Colpatria'){ echo 'selected'; }} ?>>Red Multibanca Colpatria</option>
                <option value="Simple S.A." <?php if(isset($origen)){ if($origen['data']=='Simple S.A.'){ echo 'selected'; }} ?>>Simple S.A.</option>
                <option value="Otro" <?php if(isset($origen)){ if($origen['data']=='Otro'){ echo 'selected'; }} ?>>Otro</option>
            </select>
            <select name="banco" id="banco" autocomplete="off">
                <option value="seleccionar">Seleccionar</option>
                <option value="Bancolombia" <?php if(isset($banco)){ if($banco['data']=='Bancolombia'){ echo 'selected'; }} ?>>Bancolombia</option>
                <option value="Banco de Bogota" <?php if(isset($banco)){ if($banco['data']=='Banco de Bogota'){ echo 'selected'; }} ?>>Banco de Bogotá</option>
                <option value="Efecty" <?php if(isset($banco)){ if($banco['data']=='Efecty'){ echo 'selected'; }} ?>>Efecty</option>
            </select>
            <?php if(isset($origen['error'])){ ?>
            <span id="error_origen" class="error"><?=$origen['error'];?></span>
            <?php } ?>
            <?php if(isset($banco['error'])){ ?>
            <span id="error_banco" class="error"><?=$banco['error'];?></span>
            <?php } ?>

            <label for="numero">Número de consignación o transferencia</label>
            <input type="text" name="numero" id="numero" autocomplete="off" <?php if(isset($numero)){ echo 'value="' . $numero['data'] . '"'; } ?> placeholder="Opcional">


            <label for="monto">Monto de consignación o transferencia</label>
            <input type="text" name="monto" id="monto" placeholder="Ej. 1999.98" maxlength="45" autocomplete="off" <?php if(isset($monto)){ echo 'value="' . $monto['data'] . '"'; } ?>>
            <?php if(isset($monto['error'])){ ?>
            <span class="error"><?=$monto['error'];?></span>
            <?php } ?>
            <br><br>
            <center><input type="submit" value="REGISTRAR PAGO"></center>

        </form>
    </div>
</div>
<script>
function mostrar_origen(){
    if($('#forma').val()==='Depósito'){
        $('#origen').css('display','none');
        $('#label_origen').css('display','none');
        $('#error_origen').css('display','none');
        $('#banco').css('width','100%');
        $('#label_banco').css('width','100%').text("Banco");
        $('#error_banco').css('width','100%');
    }else{
        $('#origen').css('display','inherit').css('width','50%').css('float','left');
        $('#label_origen').css('display','inherit').css('width','50%').css('float','left');
        $('#error_origen').css('display','inherit').css('width','50%').css('float','left');
        $('#banco').css('width','50%').css('float','left');
        $('#label_banco').css('width','50%').text("Destino de la Transferencia").css('float','left');
        $('#error_banco').css('display','inherit').css('width','50%').css('float','right');
    }
}
mostrar_origen();
$('#forma').change(function(){
    mostrar_origen();
});
</script>
