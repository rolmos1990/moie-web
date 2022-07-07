<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function index(){
        if($this->session->userdata('user')){
            header('location: ' . base_url() . 'admin/categorias');
        }else{
            header('location: ' . base_url() . 'admin/login');
        }
    }
    public function login(){
        if($this->input->post('pass')){
            if($this->input->post('pass')=='michi1234'){
                $this->session->set_userdata('user','admin');
                header('location: ' . base_url() . 'admin');
            }else{
                $data['mensaje']='Contraseña Inválida';
                $this->load->view('admin_header');
                $this->load->view('admin_login',$data);
            }
        }else{
            $data['mensaje']='Introduzca la contraseña de administración';
            $this->load->view('admin_header');
            $this->load->view('admin_login',$data);
        }
    }
    public function logout(){
        $this->session->sess_destroy();
        header('location: ' . base_url() . 'admin/login');
    }
    public function categorias(){
        if($this->session->userdata('user')){
            $this->load->view('admin_header');
            $this->load->view('admin_categorias');
        }else{
            $this->load->view('admin_header');
            echo '<h2>No tiene permiso para realizar esta acción. <a href="' . base_url(). 'admin/login">Inicie sesión como administrador</a></h2>';
        }
    }
    public function config(){
        if($this->session->userdata('user')){
            $this->load->view('admin_header');
            $this->load->model('m_site');
            $data['config']=$this->m_site->get_configuraciones(true);
            $this->load->view('admin_config',$data);
        }else{
            $this->load->view('admin_header');
            echo '<h2>No tiene permiso para realizar esta acción. <a href="' . base_url(). 'admin/login">Inicie sesión como administrador</a></h2>';
        }
    }
    public function guardar_config(){
        if($this->session->userdata('user')){
            $config = $this->input->post('config');
            $this->load->model('m_site');
            echo $this->m_site->guardar_configuraciones($config);
        }
    }
    public function lista_categorias(){
        if($this->session->userdata('user')){
            $this->load->model('m_site');
            $data['categorias']=$this->m_site->get_categorias();
            $this->load->view('admin_lista_categorias',$data);
        }
    }
    public function nueva_categoria(){
        if($this->session->userdata('user')){
            $categoria=$this->input->post('categoria');
            $this->load->model('m_site');
            $id_categoria=$this->m_site->nueva_categoria($categoria);
            echo(mkdir('./catalogo/' . $id_categoria));
            symlink('./' . $id_categoria,'./catalogo/' . str_replace(" ","_",$categoria));
            mkdir('./catalogo/' . $id_categoria . '/config');
        }
    }
    public function editar_categoria($id_categoria){
        if($this->session->userdata('user')){
            $this->load->model('m_site');
            $categoria=$this->m_site->get_categoria($id_categoria);
            $data['categoria']=$categoria;
            $this->load->view('admin_editar_categoria',$data);
        }else{
            $this->load->view('admin_header');
            echo '<h2>No tiene permiso para realizar esta acción. <a href="' . base_url(). 'admin/login">Inicie sesión como administrador</a></h2>';
        }
    }
    public function actualizar_categoria(){
        if($this->session->userdata('user')){
            $id_categoria=$this->input->post('categoria');
            $nuevo_nombre=$this->input->post('nuevo_nombre');
            $this->load->model('m_site');
            echo $this->m_site->actualizar_categoria($id_categoria,$nuevo_nombre);
        }
    }
    public function eliminar_categoria(){
        if($this->session->userdata('user')){
            $id_categoria=$this->input->post('categoria');
            $this->load->model('m_site');
            $categoria=$this->m_site->get_categoria($id_categoria);
            if($this->m_site->eliminar_categoria($id_categoria)>0){
                delete_files('./catalogo/' . $id_categoria . '/',true);
                unlink('./catalogo/' . $categoria->nombre);
                echo(rmdir('./catalogo/' . $id_categoria));
                delete_files('./liliapp/catalogo/' . $id_categoria . '/',true);
                unlink('./liliapp/catalogo/' . $categoria->nombre);
                echo(rmdir('./liliapp/catalogo/' . $id_categoria));
            }
        }
    }
    public function cargar_portada($categoria){
         if($this->session->userdata('user')){
            $this->load->library('image_lib');
            $image=$_FILES["portada"]["tmp_name"];
            $portada='./catalogo/' . $categoria . '/config/portada.png';
            move_uploaded_file($image,$portada);
            $portada_liliapp='./liliapp/catalogo/' . $categoria . '/config/portada.png';
            copy($portada,$portada_liliapp);
            header('location: ' . base_url() . 'admin/categorias');
         }
    }
    public function cargar_encabezado($categoria){
         if($this->session->userdata('user')){
            $this->load->library('image_lib');
            $image=$_FILES["encabezado"]["tmp_name"];
            $encabezado='./catalogo/' . $categoria . '/config/encabezado.jpg';
            move_uploaded_file($image,$encabezado);
            $this->escalar_imagen($encabezado,1000);
            header('location: ' . base_url() . 'admin/categorias');
         }
    }
    
    
    
    
    
    public function productos($id_categoria="",$error=0){
        if($this->session->userdata('user')){
            if($id_categoria==""){
                header('location: ' . base_url() . 'admin/categorias');
            }
            $this->load->model('m_site');
            $data['categoria']=$this->m_site->get_categoria($id_categoria);
            $data['productos'] = $this->m_site->get_productos($id_categoria,true);
            if($error==1){
                $data['error'] = 'Ya existe un producto guardado con la referencia indicada';
            }
            $this->load->view('admin_header',$data);
            $this->load->view('admin_productos',$data);
        }else{
            $this->load->view('admin_header');
            echo '<h2>No tiene permiso para realizar esta acción. <a href="' . base_url(). 'admin/login">Inicie sesión como administrador</a></h2>';
        }
    }
    public function nuevo_producto($categoria=""){
        if($this->input->post('codigo')){
            $codigo = strtoupper($this->input->post('codigo'));
            $id_categoria = strtoupper($this->input->post('id_categoria'));
            $tipo = strtoupper($this->input->post('tipo'));
            $tela = strtoupper($this->input->post('tela'));
            $talla_unica = strtoupper($this->input->post('talla_unica'));
            $tallas = strtoupper($this->input->post('tallas'));
            $observaciones = strtoupper($this->input->post('observaciones'));
            $precio = $this->input->post('precio');
            $imagenes = 0;
            $ruta = './catalogo/' . $id_categoria . '/';
            for($q=1;$q<=3;$q++){
                $imagen_cargada =  $_FILES['imagen_' . $q]['name'];
                if($imagen_cargada !== ""){
                    //contador de imagen cargada
                    $imagenes++;
                    //lectura de imagen y definicion de rutas
                    $imagen = $_FILES['imagen_' . $q]['tmp_name'];
                    $img800 = $ruta . $codigo . '_' . $imagenes . '_800.jpg';
                    $img400 = $ruta . $codigo . '_' . $imagenes . '_400.jpg';
                    $img238 = $ruta . $codigo . '_' . $imagenes . '_238.jpg';
                    $img67 = $ruta . $codigo . '_' . $imagenes . '_67.jpg';
                    //copiar imagenes a carpeta y escalar el thumbnail
                    move_uploaded_file($imagen, $img800);
                    //$this->logo_imagen($img800);
                    copy($img800, $img400);
                    $this->escalar_imagen($img400, 400);
                    copy($img800, $img238);
                    $this->escalar_imagen($img238, 238);
                    copy($img800, $img67);
                    $this->escalar_imagen($img67, 67);
                }
            }
            $this->load->model('m_site');
            if($this->m_site->existe_producto($codigo)){
                header('location: ' . base_url() . 'admin/productos/' . $id_categoria . '/1');
            }else{
                $this->m_site->nuevo_producto($codigo,$id_categoria,$tipo,$tela,$talla_unica,$tallas,$observaciones,$precio,$imagenes);
                header('location: ' . base_url() . 'admin/productos/' . $id_categoria);
            }
        }else{
            $data['id_categoria'] = $categoria;
            $this->load->view('admin_nuevo_producto',$data);
        }
    }
    public function eliminar_producto(){
        if($this->input->post('codigo')){
            $codigo = strtoupper($this->input->post('codigo'));
            $this->load->model('m_site');
            $this->m_site->eliminar_producto($codigo);
        }
    }
    public function vaciar_categoria(){
        if($this->input->post('categoria')){
            $categoria = strtoupper($this->input->post('categoria'));
            $this->load->model('m_site');
            $this->m_site->vaciar_categoria($categoria);
        }
    }
    public function ordenar_productos(){
        if($this->input->post('orden')){
            $orden = $this->input->post('orden');
            $this->load->model('m_site');
            $this->m_site->ordenar_productos($orden);
        }
    }
    public function editar_producto($codigo=""){
        $this->load->model('m_site');
        if($this->input->post('codigo')){
            $codigo = strtoupper($this->input->post('codigo'));
            $id_categoria = strtoupper($this->input->post('id_categoria'));
            $tipo = strtoupper($this->input->post('tipo'));
            $tela = strtoupper($this->input->post('tela'));
            $talla_unica = strtoupper($this->input->post('talla_unica'));
            $tallas = strtoupper($this->input->post('tallas'));
            $observaciones = strtoupper($this->input->post('observaciones'));
            $precio = $this->input->post('precio');
            $this->m_site->editar_producto($codigo,$tipo,$tela,$talla_unica,$tallas,$observaciones,$precio);
            header('location: ' . base_url() . 'admin/productos/' . $id_categoria);
        }else{
            $data['producto'] = $this->m_site->get_producto($codigo);
            $this->load->view('admin_editar_producto',$data);
        }
    }
    public function editar_descuentos($id_categoria){
        $this->load->model('m_site');
        if($this->input->post('id_categoria')){
            $id_categoria = $this->input->post('id_categoria');
            $descuento = $this->input->post('descuento');
            $cantidad_mayor_1 = $this->input->post('cantidad_mayor_1');
            $descuento_mayor_1 = $this->input->post('descuento_mayor_1');
            $cantidad_mayor_2 = $this->input->post('cantidad_mayor_2');
            $descuento_mayor_2 = $this->input->post('descuento_mayor_2');
            
            $this->m_site->editar_descuentos($id_categoria,$descuento,$cantidad_mayor_1,$descuento_mayor_1,$cantidad_mayor_2,$descuento_mayor_2);
            header('location: ' . base_url() . 'admin/productos/' . $id_categoria);
        }else{
            $data['categoria'] = $this->m_site->get_categoria($id_categoria);
            $this->load->view('admin_editar_descuentos',$data);
        }
    }
    
    
    
    
    
    
    
    
    
    
    private function escalar_imagen($imagen,$nuevo_ancho){
        list($ancho, $alto) = getimagesize($imagen);
        $nuevo_alto = floor($alto * ($nuevo_ancho / $ancho));
        $config['image_library'] = 'gd2';
        $config['source_image'] = $imagen;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $nuevo_ancho;
        $config['height'] = $nuevo_alto;
        $this->load->library('image_lib', $config); 
        $this->image_lib->initialize($config);
        if ( ! $this->image_lib->resize())
        {
            echo $this->image_lib->display_errors();
            return false;
        }else{
            return getimagesize($imagen);
        }
    }
    public function dropzone($categoria,$sitio){
        if($this->session->userdata('user')){
            $data['sitio']=$sitio;
            $data['categoria']=$categoria;
            $this->load->view('admin_dropzone',$data);
        }
    }
    public function orden_categorias(){
        $categorias=$this->input->post('orden');
        $this->load->model('m_site');
        $this->m_site->ordenar_categorias($categorias);
    }
    public function slider(){
        if($this->session->userdata('user')){
            $this->load->view('admin_header');
            $this->load->view('admin_slider');
        }else{
            $this->load->view('admin_header');
            echo '<h2>No tiene permiso para realizar esta acción. <a href="' . base_url(). 'admin/login">Inicie sesión como administrador</a></h2>';
        }
    }
    public function lista_slider(){
        if($this->session->userdata('user')){
            $this->load->model('m_site');
            $data['slider']=$this->m_site->get_slider();
            $data['categorias']=$this->m_site->get_categorias();
            $data['items']=[];//$this->m_site->get_imagenes();
            $this->load->view('admin_lista_slider',$data);
        }
    }
    public function nuevo_slider(){
        if($this->session->userdata('user')){
            $this->load->library('image_lib');
            $image=$_FILES["file"]["tmp_name"];
            $image_name=$_FILES["file"]["name"];
            $image_name=strtr($image_name, array('('=>'','-'=>'_',')'=>'',' '=>'_'));
            $this->load->model('m_site');
            $this->eliminar_slide($image_name);
            echo $this->m_site->nuevo_slide($image_name);
            $ruta='./catalogo/slider/' . $image_name;
            echo move_uploaded_file($image,$ruta);
        }
    }
    private function eliminar_slide($nombre){
        $this->load->model('m_site');
        if($this->m_site->eliminar_slide($nombre)>0){
            echo unlink('./catalogo/slider/' . $nombre);
        }
    }
    public function eliminar_slider(){
        if($this->session->userdata('user')){
            $archivo=$this->input->post('archivo');
            if($this->eliminar_slide($archivo)){
                echo 1;
            }
        }
    }
    public function cambiar_enlace_slider(){
        if($this->session->userdata('user')){
            $archivo=$this->input->post('archivo');
            $enlace=$this->input->post('enlace');
            $this->load->model('m_site');
            echo $this->m_site->cambiar_enlace_slide($archivo,$enlace);
        }
    }
    public function ordenar_slider(){
        if($this->session->userdata('user')){
            $slider=$this->input->post('slider');
            $this->load->model('m_site');
            echo $this->m_site->ordenar_slider($slider);
        }
    }
    
    
    
    
    
    public function banner(){
        if($this->session->userdata('user')){
            $this->load->view('admin_header');
            $this->load->view('admin_banner');
        }else{
            $this->load->view('admin_header');
            echo '<h2>No tiene permiso para realizar esta acción. <a href="' . base_url(). 'admin/login">Inicie sesión como administrador</a></h2>';
        }
    }
    public function lista_banner(){
        if($this->session->userdata('user')){
            $this->load->model('m_site');
            $data['banner']=$this->m_site->get_banner();
            $data['categorias']=$this->m_site->get_categorias();
            $data['items']=[];//$this->m_site->get_imagenes();
            $this->load->view('admin_lista_banner',$data);
        }
    }
    public function nuevo_banner(){
        if($this->session->userdata('user')){
            $this->load->library('image_lib');
            $image=$_FILES["file"]["tmp_name"];
            $image_name=$_FILES["file"]["name"];
            $image_name=strtr($image_name, array('('=>'','-'=>'_',')'=>'',' '=>'_'));
            $this->load->model('m_site');
            $this->eliminar_banner_img($image_name);
            echo $this->m_site->nuevo_banner_img($image_name);
            $ruta='./catalogo/banner/' . $image_name;
            echo move_uploaded_file($image,$ruta);
        }
    }
    private function eliminar_banner_img($nombre){
        $this->load->model('m_site');
        if($this->m_site->eliminar_banner_img($nombre)>0){
            echo unlink('./catalogo/banner/' . $nombre);
        }
    }
    public function eliminar_banner(){
        if($this->session->userdata('user')){
            $archivo=$this->input->post('archivo');
            if($this->eliminar_banner_img($archivo)){
                echo 1;
            }
        }
    }
    public function cambiar_enlace_banner(){
        if($this->session->userdata('user')){
            $archivo=$this->input->post('archivo');
            $enlace=$this->input->post('enlace');
            $this->load->model('m_site');
            echo $this->m_site->cambiar_enlace_banner_img($archivo,$enlace);
        }
    }
    public function ordenar_banner(){
        if($this->session->userdata('user')){
            $banner=$this->input->post('banner');
            $this->load->model('m_site');
            echo $this->m_site->ordenar_banner($banner);
        }
    }
    
    
    
    
    
    
    
    public function create_symlinks(){
        $this->load->model('m_site');
        $categorias=$this->m_site->get_categorias();
        foreach($categorias as $cat){
            symlink('./' . $cat->id,'./catalogo/' . str_replace(" ","_",$cat->nombre));
            echo $cat->nombre . '<br>';
        }
    }
    public function escalar_thumbs(){
        $this->load->model('m_site');
        $categorias=$this->m_site->get_categorias();
        foreach($categorias as $cat){
            $dir='./catalogo/' . $cat->id . '/thumbs/';
            $directorio=opendir($dir); 
            while ($archivo = readdir($directorio)){
                $imagen=$dir . $archivo;
                echo "$imagen<br>";
                if($archivo!=='.' && $archivo !== '..'){
                    print_r($this->escalar_imagen($imagen,326));
                }
            }
            closedir($directorio); 
        }
    }
    public function escalar_sliders(){
        $this->load->model('m_site');
        $dir='./catalogo/slider/';
        $directorio=opendir($dir); 
        while ($archivo = readdir($directorio)){
            $imagen=$dir . $archivo;
            echo "$imagen<br>";
            if($archivo!=='.' && $archivo !== '..'){
                print_r($this->escalar_imagen($imagen,640));
            }
        }
        closedir($directorio); 
    }
    public function info(){
        echo phpinfo();
    }
    public function faltantes(){
        $this->load->model('m_site');
        $cargados=$this->m_site->productos_cargados();
        $total=json_decode(file_get_contents('http://' . SERVIDOR_LUCY . '/api/ext/listar_disponibilidad'));
        $todos=array();
        foreach($total as $t){
            if($t->disponible > 0){
                $todos[]=strtoupper($t->id);
            }
        }
        $faltantes=array_diff($todos,$cargados);
        echo json_encode($faltantes);
    }
    public function comentarios(){
        if($this->session->userdata('user')){
            $this->load->view('admin_header');
            $this->load->view('admin_comentarios');
        }else{
            $this->load->view('admin_header');
            echo '<h2>No tiene permiso para realizar esta acción. <a href="' . base_url(). 'admin/login">Inicie sesión como administrador</a></h2>';
        }
    }
    public function lista_comentarios(){
        if($this->session->userdata('user')){
            $this->load->model('m_site');
            echo json_encode($this->m_site->get_comentarios(true));
        }
    }
    public function eliminar_comentario(){
        if($this->session->userdata('user')){
            $id = $this->input->post('id');
            $this->load->model('m_site');
            $this->m_site->eliminar_comentario($id);
            echo json_encode($this->m_site->get_comentarios(true));
        }
    }
    public function cambiar_comentario(){
        if($this->session->userdata('user')){
            $id = $this->input->post('id');
            $this->load->model('m_site');
            $this->m_site->cambiar_comentario($id);
            echo json_encode($this->m_site->get_comentarios(true));
        }
    }
    
    private function logo_imagen($imagen){
        $config['image_library'] = 'gd2';
        $config['source_image'] = $imagen;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['new_image'] =  'img/marca.jpg';
        $config['wm_type'] = 'overlay';
        $config['wm_vrt_alignment'] = 'bottom';
        $config['wm_hor_alignment'] = 'center';
        $config['padding'] = '20';
        $config['wm_overlay_path'] = '/img/watermark.png';
        $this->load->library('image_lib', $config); 
        $this->image_lib->initialize($config);
        $this->image_lib->watermark();
    }
    
    public function representantes(){
        if($this->session->userdata('user')){
            $this->load->view('admin_header');
            $this->load->view('admin_representantes');
        }else{
            $this->load->view('admin_header');
            echo '<h2>No tiene permiso para realizar esta acción. <a href="' . base_url(). 'admin/login">Inicie sesión como administrador</a></h2>';
        }
    }
    public function representante($id){
        if($this->session->userdata('user')){
            $this->load->view('admin_header');
            $this->load->model('m_app');
            $data['representante'] = $this->m_app->representante($id);
            $this->load->view('admin_representante',$data);
        }else{
            $this->load->view('admin_header');
            echo '<h2>No tiene permiso para realizar esta acción. <a href="' . base_url(). 'admin/login">Inicie sesión como administrador</a></h2>';
        }
    }
    public function lista_representantes(){
        if($this->session->userdata('user')){
            $this->load->model('m_app');
            echo json_encode($this->m_app->representantes());
        }
    }
    public function cambiar_representante(){
        if($this->session->userdata('user')){
            $id = $this->input->post('id');
            $this->load->model('m_app');
            $this->m_app->cambiar_representante($id);
            echo json_encode($this->m_app->representantes());
        }
    }
}
