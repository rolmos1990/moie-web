<form class="form_producto" method="POST" enctype="multipart/form-data" action="<?=base_url();?>admin/editar_producto">
    <h3>Editar <?=$producto->codigo;?></h3>
    
    <input type="hidden" name="codigo" value="<?=$producto->codigo;?>">
    
    <table>
        <tr>
            <td style="width:30%">
                Tipo
            </td>
            <td style="width:70%">
                <input type="text" name="tipo" autocomplete="off" value="<?=$producto->tipo;?>">
            </td>
        </tr>
        <tr>
            <td style="width:30%">
                Tela
            </td>
            <td style="width:70%">
                <input type="text" name="tela" autocomplete="off" value="<?=$producto->tela;?>">
            </td>
        </tr>
        <tr>
            <td style="width:30%">
                Talla Unica
            </td>
            <td style="width:70%">
                <select name="talla_unica" autocomplete="off">
                    <option value="0">NO</option>
                    <option value="1" <?php if($producto->talla_unica){ echo 'selected'; } ?>>SI</option>
                </select>
            </td>
        </tr>
        <tr>
            <td style="width:30%">
                Sirve para
            </td>
            <td style="width:70%">
                <input type="text" name="tallas" autocomplete="off" value="<?=$producto->tallas;?>">
            </td>
        </tr>
        <tr>
            <td style="width:30%">
                Observaciones
            </td>
            <td style="width:70%">
                <textarea name="observaciones" autocomplete="off"><?=$producto->observaciones;?></textarea>
            </td>
        </tr>
        <tr>
            <td style="width:30%">
                Precio
            </td>
            <td style="width:70%">
                <input type="number" name="precio" autocomplete="off" value="<?=$producto->precio;?>">
            </td>
        </tr>
    </table>
    
    <input type="hidden" name="id_categoria" value="<?=$producto->id_categoria;?>">
    <br><br>
    <center><input type="submit" value="Guardar"></center>
</form>
