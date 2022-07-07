<div class="titulo">
        <h1><?=$mensaje;?></h1>
</div>
    <form action="<?=base_url();?>admin/login" method="POST">
            <input type="password" name="pass" autocomplete="off">
            <input type="submit" value="Iniciar Sesión"/>
    </form>