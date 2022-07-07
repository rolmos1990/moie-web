<div id="titulo_representantes">
    <img src="<?=base_url();?>img/representantes/registro.jpg" alt="registro">
</div>
<div class="representantes">
    <form id="nuevo_representante" method="POST">
        <h1>Datos Generales</h1>
        <table>
            <tr>
                <td>Nombre completo</td>
                <td><input type="text" name="nombre" required maxlength="255"></td>
            </tr>
            <tr>
                <td>Cédula</td>
                <td><input type="text" name="cedula" required maxlength="15"></td>
            </tr>
            <tr>
                <td>Direccion</td>
                <td><input type="text" name="direccion" required></td>
            </tr>
            <tr>
                <td>Ciudad</td>
                <td><input type="text" name="ciudad" required maxlength="255"></td>
            </tr>
            <tr>
                <td>Departamento</td>
                <td><input type="text" name="departamento" required maxlength="255"></td>
            </tr>
            <tr>
                <td>Edad</td>
                <td><input type="number" name="edad" required min="18"></td>
            </tr>
            <tr>
                <td>Sexo</td>
                <td>M<input type="radio" name="sexo" value="M" checked>F<input type="radio" name="sexo" value="F"></td>
            </tr>
            <tr>
                <td>Telefono Celular</td>
                <td><input type="text" name="telefono_movil" required maxlength="20"></td>
            </tr>
            <tr>
                <td>Telefono Fijo</td>
                <td><input type="text" name="telefono_fijo" maxlength="20"></td>
            </tr>
            <tr>
                <td>¿Tiene telefono Android?</td>
                <td>SÍ<input type="radio" name="tiene_android" value="SI" checked>NO<input type="radio" name="tiene_android" value="NO"></td>
            </tr>
            <tr>
                <td>Marca del teléfono</td>
                <td><input type="text" name="telefono_marca" maxlength="255"></td>
            </tr>
            <tr>
                <td>Modelo del Telefono</td>
                <td><input type="text" name="telefono_modelo" maxlength="255"></td>
            </tr>
            <tr>
                <td>Sistema Operativo del teléfono</td>
                <td><input type="text" name="telefono_so" maxlength="255"></td>
            </tr>
        </table>
        <h1>Referencias Personales</h1>
        <table>
            <tr>
                <td>Nombre completo</td>
                <td><input type="text" name="ref1_nombre" required maxlength="255"></td>
            </tr>
            <tr>
                <td>Cédula</td>
                <td><input type="text" name="ref1_cedula" required maxlength="15"></td>
            </tr>
            <tr>
                <td>Telefono Celular</td>
                <td><input type="text" name="ref1_telefono_movil" required maxlength="20"></td>
            </tr>
            <tr>
                <td>Telefono Fijo</td>
                <td><input type="text" name="ref1_telefono_fijo" maxlength="20"></td>
            </tr>
        </table>
        <br><br><br>
        <table>
            <tr>
                <td>Nombre completo</td>
                <td><input type="text" name="ref2_nombre" required maxlength="255"></td>
            </tr>
            <tr>
                <td>Cédula</td>
                <td><input type="text" name="ref2_cedula" required maxlength="15"></td>
            </tr>
            <tr>
                <td>Telefono Celular</td>
                <td><input type="text" name="ref2_telefono_movil" required maxlength="20"></td>
            </tr>
            <tr>
                <td>Telefono Fijo</td>
                <td><input type="text" name="ref2_telefono_fijo" maxlength="20"></td>
            </tr>
        </table>
        <h1>Experiencia Laboral</h1>
        <table>
            <tr>
                <td>¿Posee experiencia en ventas?</td>
                <td>SÍ<input type="radio" name="experiencia" value="SI">NO<input type="radio" name="experiencia" value="NO" checked></td>
            </tr>
            <tr>
                <td>¿Dónde?</td>
                <td><textarea name="experiencia_lugar"></textarea></td>
            </tr>
            <tr>
                <td>¿Cuánto tiempo?</td>
                <td><input type="text" name="experiencia_tiempo" maxlength="255"></td>
            </tr>
            <tr>
                <td>¿Cuáles son sus aspiraciones con el catálogo Android Lucy Modas?</td>
                <td><textarea name="aspiraciones"></textarea></td>
            </tr>
        </table>
        <input type="submit" value="Enviar" />
    </form>
    
    <script>
        $('#nuevo_representante').validate();
    </script>
</div>
