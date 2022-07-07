<form class="form_producto" id="nuevo_producto" method="POST" enctype="multipart/form-data" action="<?=base_url();?>admin/nuevo_producto">
    <h3>Nuevo producto</h3>    
    <table>
        <tr>
            <td style="width:30%">Código</td>
            <td style="width:70%"><input type="text" name="codigo" autocomplete="off"></td>
        </tr>
        <tr>
            <td style="width:30%">
                Tipo
            </td>
            <td style="width:70%">
                <input type="text" name="tipo" autocomplete="off">
            </td>
        </tr>
        <tr>
            <td style="width:30%">
                Tela
            </td>
            <td style="width:70%">
                <input type="text" name="tela" autocomplete="off">
            </td>
        </tr>
        <tr>
            <td style="width:30%">
                Talla Unica
            </td>
            <td style="width:70%">
                <select name="talla_unica" autocomplete="off">
                    <option value="0">NO</option>
                    <option value="1">SI</option>
                </select>
            </td>
        </tr>
        <tr>
            <td style="width:30%">
                Sirve para
            </td>
            <td style="width:70%">
                <input type="text" name="tallas" autocomplete="off">
            </td>
        </tr>
        <tr>
            <td style="width:30%">
                Observaciones
            </td>
            <td style="width:70%">
                <textarea name="observaciones" autocomplete="off"></textarea>
            </td>
        </tr>
        <tr>
            <td style="width:30%">
                Precio
            </td>
            <td style="width:70%">
                <input type="number" name="precio" autocomplete="off">
            </td>
        </tr>
        <tr>
            <td style="width:30%">
                Imagen 1
            </td>
            <td style="width:70%">
                <input type="file" name="imagen_1" autocomplete="off">
            </td>
        </tr>
        <tr>
            <td style="width:30%">
                Imagen 2
            </td>
            <td style="width:70%">
                <input type="file" name="imagen_2" autocomplete="off">
            </td>
        </tr>
        <tr>
            <td style="width:30%">
                Imagen 3
            </td>
            <td style="width:70%">
                <input type="file" name="imagen_3" autocomplete="off">
            </td>
        </tr>
    </table>
            
    <input type="hidden" name="id_categoria" value="<?=$id_categoria;?>">
    <br>
    <br>
    <center><input type="submit" value="Guardar"></center>
</form>