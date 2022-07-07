<div class="titulo">
    <h1>Imagenes pequeñas (<a href="<?=base_url();?>admin/categorias">Volver</a>)</h1>
</div>
<div id="dz_wrap">
    <div id="dropzone" class="dropzone">

    </div>
</div>

<ul id="fotos_banner">

</ul>


<script>
    var myDropzone = new Dropzone("div#dropzone", { url: "<?=base_url();?>admin/nuevo_banner",init: function() {
        this.on("complete", function(file) { cargar_banner(); });
    }});
    cargar_banner();
    $( "#fotos_banner" ).sortable({
        update: function(event, ui) {
            ordenar_banner();
        }
    });
</script>