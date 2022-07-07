<div class="titulo">
    <h1>Imágenes de página inicial (<a href="<?=base_url();?>admin/categorias">Volver</a>)</h1>
</div>
<div id="dz_wrap">
    <div id="dropzone" class="dropzone"></div>
</div>
<ul id="fotos_slider"></ul>


<script>
    var myDropzone = new Dropzone("div#dropzone", { url: "<?=base_url();?>admin/nuevo_slider",init: function() {
        this.on("complete", function(file) { cargar_slider() });
    }});
    cargar_slider();
    $( "#fotos_slider" ).sortable({
        update: function(event, ui) {
            ordenar_slider();
        }
    });
</script>