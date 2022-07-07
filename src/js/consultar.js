function consultar(referencia){
    if(!referencia==''){
        var url="/site/consulta/" + referencia.toUpperCase();
        $.get(url,function(result){
            $.each(eval(result),function(i,item){
                var tabla = $('<table>').attr('id','disponibilidad');
                $.each(item.tallas,function(j,t){
                    $.each(item.disponibilidad,function(i,d){
                        if(t == d.talla){
                            tabla.append($('<tr>').append($('<th>').html(d.talla)));
                            $.each(d.colores,function(i,color){
                                tabla.append($('<tr>').append($('<td>').html(color)));
                            });
                        }
                    });
                });
                $('#cargando_disponibilidad').css('display','none');
                $('#dato_disponibilidad_' + referencia).empty();
                $('#dato_disponibilidad_' + referencia).append(tabla);
                $('#dato_disponibilidad_' + referencia).fadeIn();
            });
        },'html');
        $('#referencia').val('');
    }
}