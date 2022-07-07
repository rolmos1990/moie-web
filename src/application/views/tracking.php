<div id="tracking">
    <h1>Ingresa el número de pedido</h1>
    <div id="busqueda">
        <input type="text" id="num_pedido" autocomplete="off">
        <button onclick="tracking()" id="tracking_button">Aceptar</button>
    </div>
    <div id="tracking_info"></div>
</div>
<script>
$("#num_pedido").keyup(function(event){
    if(event.keyCode == 13){
        $("#tracking_button").click();
    }
});
</script>
