<div id="renove">
    <h1>Bienvenida al sistema de activación de catálogos Renové</h1>
    <p>A continuación, coloca número de <strong>Cédula de Identidad o RIF</strong> 
        y el <strong>código impreso</strong> en la última página del catálogo</p>
    <form method="POST" action="<?=base_url();?>site/renove">
        <label for="ci_letra">Cédula de Identidad o RIF</label>
        <select name="ci_letra" id="ci_letra" autocomplete="off" style="width:10%;text-align: center;">
            <option value="V" <?php if(isset($ci)){ if($ci['letra']=='V'){ echo 'selected'; } }else{ echo 'selected'; } ?>>V</option>
            <option value="E" <?php if(isset($ci)){ if($ci['letra']=='E'){ echo 'selected'; } } ?>>E</option>
            <option value="J" <?php if(isset($ci)){ if($ci['letra']=='J'){ echo 'selected'; } } ?>>J</option>
        </select>
        <input type="text" name="ci_numero" id="ci_numero" autocomplete="off" <?php if(isset($ci)){ echo 'value="' . $ci['numero'] . '"'; } ?> style="width:40%;">
        <?php if(isset($ci['error'])){ ?>
            <span class="error"><?=$ci['error'];?></span>
        <?php } ?>


        <label for="catalogo">Código impreso en el catálogo</label>
        <input type="text" name="catalogo" id="catalogo" autocomplete="off" <?php if(isset($catalogo)){ echo 'value="' . $catalogo['id'] . '"'; } ?> style="width:50%;text-align: center;">
        <?php if(isset($catalogo['error'])){ ?>
            <span class="error"><?=$catalogo['error'];?></span>
        <?php } ?>
            
        <br><br><br>
        <center><input type="submit" value="Activar catalogo"></center>

    </form>
</script>
</div>