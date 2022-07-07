<form id="nuevo_producto" method="POST" enctype="multipart/form-data" action="<?=base_url();?>admin/editar_descuentos/<?=$categoria->id;?>">
    <h3>Editar <?=$categoria->nombre;?></h3>
    
    <input type="hidden" name="id_categoria" value="<?=$categoria->id;?>">
    
    <table>
        <tr>
            <td style="width:50%">
                Descuento al detal
            </td>
            <td style="width:50%">
                <select name="descuento" autocomplete="off">
                    <?php for($d=0;$d<=100;$d=$d+5){ ?>
                    <option <?php if($categoria->descuento == $d){ echo 'selected'; } ?>><?=$d?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%">
                Cantidad al mayor 1
            </td>
            <td style="width:50%">
                <select name="cantidad_mayor_1" autocomplete="off">
                    <?php for($cm1=0;$cm1<=30;$cm1++){ ?>
                    <option <?php if($categoria->cantidad_mayor_1 == $cm1){ echo 'selected'; } ?>><?=$cm1?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%">
                Descuento al mayor 1
            </td>
            <td style="width:50%">
                <select name="descuento_mayor_1" autocomplete="off">
                    <?php for($dm1=0;$dm1<=100;$dm1=$dm1+5){ ?>
                    <option <?php if($categoria->descuento_mayor_1 == $dm1){ echo 'selected'; } ?>><?=$dm1?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%">
                Cantidad al mayor 2
            </td>
            <td style="width:50%">
                <select name="cantidad_mayor_2" autocomplete="off">
                    <?php for($cm2=0;$cm2<=30;$cm2++){ ?>
                    <option <?php if($categoria->cantidad_mayor_2 == $cm2){ echo 'selected'; } ?>><?=$cm2?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%">
                Descuento al mayor 2
            </td>
            <td style="width:50%">
                <select name="descuento_mayor_2" autocomplete="off">
                    <?php for($dm2=0;$dm2<=100;$dm2=$dm2+5){ ?>
                    <option <?php if($categoria->descuento_mayor_2 == $dm2){ echo 'selected'; } ?>><?=$dm2?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
    </table>
    
    <br><br>
    <center><input type="submit" value="Guardar"></center>
</form>
