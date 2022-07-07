<div id="editar_categoria_cb">
    <div class="titulo">
        <h1>Cambiar nombre: <?=$categoria->nombre;?></h1>
    </div>
        <input type="text" id="nuevo_nombre" value="<?=$categoria->nombre;?>" autocomplete="off" />
        <input type="hidden" id="categoria" value="<?=$categoria->id;?>" />
        <input type="submit" id="guardar" value="Guardar" onclick="guardar()" />
</div>