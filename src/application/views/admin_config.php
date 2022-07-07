<div class="titulo">
    <h1>Configuración(<a href="<?=base_url();?>admin/categorias">Volver</a>)</h1>
</div>
<table>
    <?php foreach($config as $clave => $c){ ?>
    <tr>
        <td><?=$clave;?></td>
        <td>
            <?php if($c['tipo']=='texto'){ ?>
            <input type="text" class="config" id="<?=$clave;?>" value="<?=$c['valor'];?>" autocomplete="off">
            <?php }else if($c['tipo']=='fecha'){ ?>
            <input type="text" class="config fecha" id="<?=$clave;?>" value="<?=$c['valor'];?>" autocomplete="off">
            <?php }else if(substr($c['tipo'],0,8)=='multiple'){ ?>
            <select class="config" id="<?=$clave;?>" autocomplete="off">
                <?php 
                $valores = explode('_',$c['tipo']);
                for($i=1;$i<count($valores);$i++){ ?>
                <option <?php if($valores[$i]==$c['valor']){ echo 'selected'; } ?>><?=$valores[$i];?></option>
                <?php } ?>
            </select>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
<center><button id="guardar_config" style="display:none" onclick="guardar_config()">Guardar</button></center>
<script>
$('.fecha').datetimepicker();
$('.config').change(function(){
    $(this).css('color','red');
    $('#guardar_config').fadeIn();
});
</script>