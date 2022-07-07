        <div id="infografia_mayor">
            <img src="<?=base_url();?>img/compras_al_mayor.png">
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
            $(function(){
                var id=1;
                window.setInterval(function(){
                if(id==1){
                    $('#continuar').css('background','#50cc00');
                    id=2;
                }else{
                    $('#continuar').css('background','#982052');
                    id=1;
                }
                },1000);
            });
        </script>