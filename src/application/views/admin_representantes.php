<div class="titulo">
    <h1>Representantes</h1>
</div>
<div class="menu">
    <div class="menu_item" onclick="window.location.href='<?=base_url();?>admin/categorias'">Volver</div>
</div>
<table style="text-align: left;">
    <thead>
        <tr>
            <th style="width:100px">Código</th>
            <th style="width:150px">Nombre</th>
            <th style="width:150px">Cédula</th>
            <th style="width:150px">Ciudad</th>
            <th style="width:200px">Departamento</th>
            <th style="width:250px">Opciones</th>
        </tr>
    </thead>
    <tbody id="representantes">
    </tbody>
<script>
    var get_representantes = function(){
        $.get('<?=base_url();?>admin/lista_representantes',function(data){
            cargar_representantes(data);
        });
    };
    var cargar_representantes = function(data){
        $('#representantes').empty();
        var representantes = JSON.parse(data);
        $.each(representantes,function(index,item){
            var c = $('<tr>').addClass('aprobado' + item.habilitado);
            c.append($('<td>').text(item.id));
            c.append($('<td>').text(item.nombre));
            c.append($('<td>').text(item.cedula));
            c.append($('<td>').text(item.ciudad));
            c.append($('<td>').text(item.departamento));
            var o = $('<td>');
            var boton_cambiar = $('<button>').addClass('cambiar' + item.habilitado).attr('onclick','cambiar_representante("' + item.id +'")');
            if(item.habilitado > 0){
                boton_cambiar.text('Desabilitar');
            }else{
                boton_cambiar.text('Habilitar');
            }
            o.append(boton_cambiar);
            o.append($('<button>').addClass('aprobado').attr('onclick','location.href="<?=base_url();?>admin/representante/' + item.id +'"').text('Ver detalles'));
            c.append(o);
            $('#representantes').append(c);
        });
    };
    var cambiar_representante = function(id){
        $.post('<?=base_url();?>admin/cambiar_representante',{id:id},function(data){
            cargar_representantes(data);
        });
    };
    
    get_representantes();
</script>