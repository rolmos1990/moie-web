<div class="titulo">
        <h1>Opciones</h1>
</div>
<div class="menu">
    <div class="menu_item" onclick="agregar()">Nueva categoría</div>
    <div class="menu_item" onclick="window.location.href='<?=base_url();?>admin/slider'">Imágenes pag. inicial</div>
    <div class="menu_item" onclick="window.location.href='<?=base_url();?>admin/banner'">Imagenes pequeñas</div>
    <div class="menu_item" onclick="window.location.href='<?=base_url();?>admin/config'">Configuración</div>
    <div class="menu_item" onclick="window.location.href='<?=base_url();?>admin/comentarios'">Comentarios</div>
    <div class="menu_item" onclick="window.location.href='<?=base_url();?>admin/representantes'">Representantes</div>
    <!--<div class="menu_item" onclick="window.location.href='<?=base_url();?>admin/catalogos'">Catálogos</div>-->
</div>
<div class="titulo">
        <h1>Categorías Registradas</h1>
</div>
<div id="faltantes" style="width:100%;background-color:pink;"><b>Faltan por cargar: </b><span>Cargando...</span></div>
<ul id="categorias">
    
</ul>
<script>
    cargar_categorias();
    faltantes();
    $( "#categorias" ).sortable({
        update: function(event, ui) {
            orden_categorias();
        }
    });
    $( "#categorias" ).disableSelection();
</script>