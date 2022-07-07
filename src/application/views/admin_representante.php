<div class="titulo">
    <h1>Representante: <?=$representante->nombre;?></h1>
</div>
<div class="menu">
    <div class="menu_item" onclick="window.location.href='<?=base_url();?>admin/representantes'">Volver</div>
</div>
<div style="width:50%;float:left;">
    <h1>Datos Generales</h1>
    <table style="vertical-align: top; text-align: left; width:100%;">
        <tr>
            <td style="width:30%;">Nombre completo</td>
            <td><?=$representante->nombre;?></td>
        </tr>
        <tr>
            <td>Cédula</td>
            <td><?=$representante->cedula;?></td>
        </tr>
        <tr>
            <td>Direccion</td>
            <td><?=$representante->direccion;?></td>
        </tr>
        <tr>
            <td>Ciudad</td>
            <td><?=$representante->ciudad;?></td>
        </tr>
        <tr>
            <td>Departamento</td>
            <td><?=$representante->departamento;?></td>
        </tr>
        <tr>
            <td>Edad</td>
            <td><?=$representante->edad;?></td>
        </tr>
        <tr>
            <td>Sexo</td>
            <td><?=$representante->sexo;?></td>
        </tr>
        <tr>
            <td>Telefono Celular</td>
            <td><?=$representante->telefono_movil;?></td>
        </tr>
        <tr>
            <td>Telefono Fijo</td>
            <td><?=$representante->telefono_fijo;?></td>
        </tr>
        <tr>
            <td>¿Tiene telefono Android?</td>
            <td><?=$representante->tiene_android;?></td>
        </tr>
        <tr>
            <td>Marca del teléfono</td>
            <td><?=$representante->telefono_marca;?></td>
        </tr>
        <tr>
            <td>Modelo del Telefono</td>
            <td><?=$representante->telefono_modelo;?></td>
        </tr>
        <tr>
            <td>Sistema Operativo del teléfono</td>
            <td><?=$representante->telefono_so;?></td>
        </tr>
    </table>
    </div>
    <div style="width:50%;float:left;">
    <h1>Referencias Personales</h1>
    <table style="vertical-align: top; text-align: left; width:100%;">
        <tr>
            <td style="width:30%;">Nombre completo</td>
            <td><?=$representante->ref1_nombre;?></td>
        </tr>
        <tr>
            <td>Cédula</td>
            <td><?=$representante->ref1_cedula;?></td>
        </tr>
        <tr>
            <td>Telefono Celular</td>
            <td><?=$representante->ref1_telefono_movil;?></td>
        </tr>
        <tr>
            <td>Telefono Fijo</td>
            <td><?=$representante->ref1_telefono_fijo;?></td>
        </tr>
    </table>
    <table style="vertical-align: top; text-align: left; width:100%;">
        <tr>
            <td style="width:30%;">Nombre completo</td>
            <td><?=$representante->ref2_nombre;?></td>
        </tr>
        <tr>
            <td>Cédula</td>
            <td><?=$representante->ref2_cedula;?></td>
        </tr>
        <tr>
            <td>Telefono Celular</td>
            <td><?=$representante->ref2_telefono_movil;?></td>
        </tr>
        <tr>
            <td>Telefono Fijo</td>
            <td><?=$representante->ref2_telefono_fijo;?></td>
        </tr>
    </table>
    <h1>Experiencia Laboral</h1>
    <table style="vertical-align: top; text-align: left; width:100%;">
        <tr>
            <td style="width:30%;">¿Posee experiencia en ventas?</td>
            <td><?=$representante->experiencia;?></td>
        </tr>
        <tr>
            <td>¿Dónde?</td>
            <td><?=$representante->experiencia_lugar;?></td>
        </tr>
        <tr>
            <td>¿Cuánto tiempo?</td>
            <td><?=$representante->experiencia_tiempo;?></td>
        </tr>
        <tr>
            <td>¿Cuáles son sus aspiraciones con el catálogo Android Lucy Modas?</td>
            <td><?=$representante->aspiraciones;?></td>
        </tr>
    </table>
    </div>
</div>