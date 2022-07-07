<div class="titulo">
    <h1>Comentarios y Testimonios</h1>
</div>
<div class="menu">
    <div class="menu_item" onclick="window.location.href='<?=base_url();?>admin/categorias'">Volver</div>
</div>
<table style="text-align: left;">
    <thead>
        <tr>
            <th style="width:150px">Nombre</th>
            <th style="width:150px">Fecha</th>
            <th style="width:100px">Estrellas</th>
            <th style="width:400px">Comentario</th>
            <th style="width:200px">Opciones</th>
        </tr>
    </thead>
    <tbody id="comentarios"></tbody>
</table>
<script>
    var get_comentarios = function(){
        $.get('<?=base_url();?>admin/lista_comentarios',function(data){
            cargar_comentarios(data);
        });
    };
    var cargar_comentarios = function(data){
        $('#comentarios').empty();
        var comentarios = JSON.parse(data);
        $.each(comentarios,function(index,item){
            var c = $('<tr>').addClass('aprobado' + item.aprobado);
            c.append($('<td>').text(item.nombre));
            c.append($('<td>').text(item.fecha));
            c.append($('<td>').text(item.experiencia));
            c.append($('<td>').text(item.comentario));
            var o = $('<td>');
            var boton_cambiar = $('<button>').addClass('cambiar' + item.aprobado).attr('onclick','cambiar_comentario(' + item.id +')');
            if(item.aprobado > 0){
                boton_cambiar.text('Desabilitar');
            }else{
                boton_cambiar.text('Habilitar');
            }
            o.append(boton_cambiar);
            o.append($('<button>').addClass('eliminar').attr('onclick','eliminar_comentario(' + item.id +')').text('Eliminar'));
            c.append(o);
            $('#comentarios').append(c);
        });
    };
    var cambiar_comentario = function(id){
        $.post('<?=base_url();?>admin/cambiar_comentario',{id:id},function(data){
            cargar_comentarios(data);
        });
    };
    var eliminar_comentario = function(id){
        $.post('<?=base_url();?>admin/eliminar_comentario',{id:id},function(data){
            cargar_comentarios(data);
        });
    };
    
    get_comentarios();
</script>