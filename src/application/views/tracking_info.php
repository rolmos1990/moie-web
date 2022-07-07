<h1>Infomación del pedido <?=$num_pedido;?></h1>
<table>
    <?php foreach(array_reverse($eventos) as $e){ ?>
    <tr class="evento">
        <td class="fecha_evento"><?php if($e->fecha){ echo $e->fecha; }else{ echo 'En espera'; }?></td>
        <td class="linea">
            <?php if($e->fecha){ ?>
                <?php if($e->accion==='registrar'){ ?>
                <img src="<?=base_url();?>img/linea_inicio.png"> 
                <?php }else if($e->accion==='anular'){ ?>
                <img src="<?=base_url();?>img/linea_fin_roja.png"> 
                <?php }else if($e->accion==='confirmar envío'){ ?>
                <img src="<?=base_url();?>img/linea_fin_verde.png"> 
                <?php }else{ ?>
                <img src="<?=base_url();?>img/linea_transicion.png"> 
                <?php } ?>
            <?php }else{ ?> 
                <img src="<?=base_url();?>img/linea_fin_amarilla.png"> 
            <?php } ?>
        </td>
        <td class="descripcion_evento"><?=$e->descripcion;?></td>
    </tr>
    <?php } ?>
</table>
