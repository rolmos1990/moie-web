<div id="comentarios_liliweb">
    <img src="<?=base_url();?>img/comentarios.jpg" style="width: 1000px;"><br><br><br>
    <div class="comentario_liliweb_nuevo">
        <h2>ESCRIBE TU TESTIMONIO</h2>
        <form method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Nombre y Apellido</td>
                    <td><input type="text" maxlength="255" name="nombre" required ></td>
                </tr>
                <tr>
                    <td>Califique su experiencia</td>
                    <td>
                        <input type="hidden" name="experiencia" id="experiencia" value="5">
                        <img class="experiencia" id="experiencia1" src="/img/estrella_encendida.png" onclick="calificar(1)">
                        <img class="experiencia" id="experiencia2" src="/img/estrella_encendida.png" onclick="calificar(2)">
                        <img class="experiencia" id="experiencia3" src="/img/estrella_encendida.png" onclick="calificar(3)">
                        <img class="experiencia" id="experiencia4" src="/img/estrella_encendida.png" onclick="calificar(4)">
                        <img class="experiencia" id="experiencia5" src="/img/estrella_encendida.png" onclick="calificar(5)">
                    </td>
                </tr>
                <tr>
                    <td>Foto</td>
                    <td><input type="file" name="foto" /></td>
                </tr>
                <tr>
                    <td>Testimonio</td>
                    <td><textarea name="comentario" required ></textarea></td>
                </tr>
            </table>
            
            <button>Enviar</button>
        </form>
    </div>
    <div class="col">
        <?php foreach($comentarios as $i => $c){ 
            if($i%2 != 0){ ?><!--
        --><div class="comentario_liliweb">
            <?php if($c->foto){ ?><img src="/img/comentario/<?=$c->id;?>.jpg" height="45"><?php } ?>
            <strong><?=$c->nombre;?></strong><cite><?=date('d-m-Y',strtotime( $c->fecha ));?></cite>
            <p><?=$c->comentario;?></p>
        </div><!--
        --><?php }} ?>
    </div>
    <div class="col">
        <?php foreach($comentarios as $i => $c){ 
            if($i%2 == 0){ ?><!--
        --><div class="comentario_liliweb">
            <?php if($c->foto){ ?><img src="/img/comentario/<?=$c->id;?>.jpg" height="45"><?php } ?>
            <strong><?=$c->nombre;?></strong> <cite><?=date('d-m-Y',strtotime( $c->fecha ));?></cite>
            <p><?=$c->comentario;?></p>
        </div><!--
        --><?php }} ?>
    </div>
</div>
