function tracking(){
    var num_pedido=$('#num_pedido').val();
    if (!isNaN(num_pedido)){
        $('#tracking_info').empty();
        $('#tracking_info').text('Buscando...');
        $("num_pedido").prop('disabled', true);
        $.get('/site/tracking_info/' + num_pedido,function(data){
            if(data==0){
                $('#tracking_info').empty();
                $('#tracking_info').text('El pedido no existe');
            }else if(data==-1){
                $('#tracking_info').empty();
                $('#tracking_info').text('Falló la conexión con el servido. Intente más tarde');
            }else{
                $('#tracking_info').empty();
                $(data).appendTo('#tracking_info');
                $('#num_pedido').val('');
                $("num_pedido").prop('disabled', false);
            }
        });
    }else{
        $('#tracking_info').empty();
        $('#tracking_info').text('El número de pedido no es válido');
    }
}
function activar_pregunta(p){
    $('.pregunta').removeClass('activa');
    $(p).addClass('activa');
    
}
function reputacion(){
    var url='/site/comentario';
    $.get(url,function(result){
        if(result){
            var rep = $.parseJSON(result);
            var foo = '';
            if(rep.foto !== '0'){
                foo = '<img src=' + rep.id + '"/img/comentario/.jpg"  height="45" style="float:left">';
            }
            foo = foo + '<div>';
            foo = foo + '<b>' + rep.nombre + '</b><img src=' + rep.experiencia + '"/img/rating.png"><br>';
            foo = foo + '<img src="/img/comillai.png" style="float:left;"><span>' + rep.comentario + '</span><img src="/img/comillad.png" style="float:left;"></div>';
            $('#barra_reputacion').html(foo);
            window.setTimeout(reputacion,7000);
        }
    });
}
function enviar_email(){
    var email = $('#email_promo').val();
    var url = '/site/email';
    $.post(url,{email:email},function(){
        $('#email_promo_article').html('<h3>TU CORREO ELECTRONICO HA SIDO REGISTRADO PARA RECIBIR NUESTRAS PROMOCIONES</h3>');
    });
}
function calificar(valor){
    $('.experiencia').attr('src','/img/estrella_apagada.png');
    $('#experiencia').val(valor);
    for(var i=1;i<=valor;i++){
        $('#experiencia' + i).attr('src','/img/estrella_encendida.png');
    }
}
