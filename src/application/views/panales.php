        <div id="infografia_mayor">
            <img src="<?=base_url();?>img/panales.jpg?<?=date('Ymd');?>">
            <div id="video_panales"><iframe src="https://player.vimeo.com/video/124419446" width="327" height="220" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>
            <button id="continuar">Aceptar y Continuar</button>
        </div>
        <script>
            $( document ).ready(function() {
                $('#titulo_categoria,#productos').css('display','none');
            });
            $('#continuar').click(function(){
                $('#infografia_mayor').css('display','none');
                $('#titulo_categoria,#productos').fadeIn();
            });
        </script>