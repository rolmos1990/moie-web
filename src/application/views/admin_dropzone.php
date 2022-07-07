        <div id="dropzone" class="dropzone">

        </div>
        <script>
        var myDropzone = new Dropzone("div#dropzone", { url: "<?=base_url();?>admin/cargar_producto/<?=$categoria;?>/<?=$sitio;?>",init: function() {
            this.on("complete", function(file) { cargar_productos('<?=$sitio;?>'); });
        }});
        </script>