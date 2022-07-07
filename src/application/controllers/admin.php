<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function index(){
        $this->load->view('admin');
    }
    public function login(){
        $password = $this->input->post('password');
        if(strtolower($password) === 'emoji123'){
            $this->session->set_userdata('user','admin');
        }else{
            http_response_code(401);
        }
    }
    public function logout(){
        if($this->session->userdata('user')){
            $this->session->unset_userdata('user');
            $this->session->sess_destroy();
        }
    }
    public function categorias(){
        if($this->session->userdata('user')){
            $this->load->model('m_admin');
            $categorias=$this->m_admin->categorias();
            echo json_encode($categorias);
        }else{
            http_response_code(401);
        }
    }
    public function categoria($id){
        if($this->session->userdata('user')){
            $this->load->model('m_admin');
            $categoria=$this->m_admin->categoria($id);
            echo json_encode($categoria);
        }else{
            http_response_code(401);
        }
    }
    public function nueva_categoria(){
        if($this->session->userdata('user')){
            $nombre = strtoupper($this->input->post('nombre'));
            $this->load->model('m_admin');
            $id = $this->m_admin->nueva_categoria($nombre);
            mkdir('./catalogo/' . $id);
            mkdir('./catalogo/' . $id . '/config/');
        }else{
            http_response_code(401);
        }
    }
    public function cambiar_nombre_categoria(){
        if($this->session->userdata('user')){
            $id = $this->input->post('id');
            $nombre = strtoupper($this->input->post('nombre'));
            $this->load->model('m_admin');
            $this->m_admin->cambiar_nombre_categoria($id,$nombre);
        }else{
            http_response_code(401);
        }
    }
    public function cargar_imagen_categoria(){
        if($this->session->userdata('user')){
            $id = $this->input->post('id');
            $elemento = $this->input->post('elemento');
            if($id !== 'mayor' && $id !== 'combos'){
                $this->load->model('m_admin');
                $this->m_admin->actualizar_categoria($id);
            }
            $image=$_FILES["imagen"]["tmp_name"];
            $tipo=$_FILES["imagen"]["type"];
            if($tipo === 'image/png'){
                $ext = '.png';
            }else if($tipo === 'image/jpeg'){
                $ext = '.jpg';
            }
            $ruta='./catalogo/' . $id . '/config/' . $elemento . $ext;
            move_uploaded_file($image,$ruta);
        }else{
            http_response_code(401);
        }
    }
    public function vaciar_categoria(){
        if($this->session->userdata('user')){
            $id = $this->input->post('id');
            $this->load->model('m_admin');
            $this->m_admin->vaciar_categoria($id);
            delete_files('./catalogo/' . $id . '/',false);
        }else{
            http_response_code(401);
        }
    }
    public function eliminar_categoria(){
        if($this->session->userdata('user')){
            $id = $this->input->post('id');
            $this->load->model('m_admin');
            $this->m_admin->eliminar_categoria($id);
            delete_files('./catalogo/' . $id . '/',true);
            rmdir('./catalogo/' . $id);
        }else{
            http_response_code(401);
        }
    }
    public function descuentos(){
        if($this->session->userdata('user')){
            $id = $this->input->post('id');
            $descuentos = $this->input->post('descuentos');
            $this->load->model('m_admin');
            $this->m_admin->descuentos($id,$descuentos);
        }else{
            http_response_code(401);
        }
    }
    public function rotativo($tipo){
        if($this->session->userdata('user')){
            $this->load->model('m_admin');
            if(strtolower($tipo) === 'principal'){
                $tipo = 1;
            }else if(strtolower($tipo) === 'secundario'){
                $tipo = 2;
            }
            echo json_encode($this->m_admin->rotativo($tipo));
        }else{
            http_response_code(401);
        }
    }
    public function nueva_imagen_rotativo(){
        if($this->session->userdata('user')){
            $tipo = $this->input->post('tipo');
            if(strtolower($tipo) === 'principal'){
                $t = 1;
            }else if(strtolower($tipo) === 'secundario'){
                $t = 2;
            }
            $image=$_FILES["imagen"]["tmp_name"];
            $nombre=$_FILES["imagen"]["name"];
            $this->load->model('m_admin');
            $this->m_admin->nueva_imagen_rotativo($nombre,$t);
            $ruta = './catalogo/slider/' . $nombre;
            move_uploaded_file($image,$ruta);
        }else{
            http_response_code(401);
        }
    }
    public function eliminar_imagen_rotativo(){
        if($this->session->userdata('user')){
            $tipo = $this->input->post('tipo');
            if(strtolower($tipo) === 'principal'){
                $t = 1;
            }else if(strtolower($tipo) === 'secundario'){
                $t = 2;
            }
            $nombre = $this->input->post('nombre');
            $this->load->model('m_admin');
            $this->m_admin->eliminar_imagen_rotativo($nombre,$t);
            $ruta = './catalogo/slider/' . $nombre;
            unlink($ruta);
        }else{
            http_response_code(401);
        }
    }
    public function cambiar_enlace_imagen(){
        if($this->session->userdata('user')){
            $imagen = $this->input->post('imagen');
            $enlace = $this->input->post('enlace');
            $this->load->model('m_admin');
            $this->m_admin->cambiar_enlace_imagen($imagen,$enlace);
        }else{
            http_response_code(401);
        }
    }
    public function eliminar_producto(){
        if($this->session->userdata('user')){
            $codigo = $this->input->post('codigo');
            $this->load->model('m_admin');
            $this->m_admin->eliminar_producto($codigo);
        }else{
            http_response_code(401);
        }
    }
    public function comentarios(){
        if($this->session->userdata('user')){
            $this->load->model('m_admin');
            echo json_encode($this->m_admin->comentarios());
        }else{
            http_response_code(401);
        }
    }
    public function eliminar_comentario(){
        if($this->session->userdata('user')){
            $id = $this->input->post('id');
            $this->load->model('m_admin');
            $this->m_admin->eliminar_comentario($id);
        }else{
            http_response_code(401);
        }
    }
    public function aprobar_comentario(){
        if($this->session->userdata('user')){
            $id = $this->input->post('id');
            $this->load->model('m_admin');
            $this->m_admin->aprobar_comentario($id);
        }else{
            http_response_code(401);
        }
    }
    public function ordenar(){
        if($this->session->userdata('user')){
            $elemento = $this->input->post('elemento');
            $orden = $this->input->post('orden');
            $this->load->model('m_admin');
            $this->m_admin->ordenar($elemento,$orden);
        }else{
            http_response_code(401);
        }
    }
    public function movil($inicio,$fin){
        if($this->session->userdata('user')){
            $this->load->model('m_admin');
            $movil = $this->m_admin->movil($inicio,$fin);
            echo json_encode($movil);
        }else{
            http_response_code(401);
        }
    }
    public function producto($codigo){
        if($this->session->userdata('user')){
            $this->load->model('m_admin');
            $producto = $this->m_admin->producto($codigo);
            echo json_encode($producto,JSON_NUMERIC_CHECK);
        }else{
            http_response_code(401);
        }
    }
    public function guardar_producto(){
        if($this->session->userdata('user')){
            //lectura de datos del cliente
            $codigo = strtoupper($this->input->post('codigo'));
            $id_categoria = strtoupper($this->input->post('idCategoria'));
            $tipo = strtoupper($this->input->post('tipo'));
            $tela = strtoupper($this->input->post('tela'));
            $talla_unica = strtoupper($this->input->post('tallaUnica'));
            $tallas = strtoupper($this->input->post('tallas'));
            $observaciones = strtoupper($this->input->post('observaciones'));
            $precio = $this->input->post('precio');
            $nuevo = $this->input->post('nuevo');
            $descuento_especial = $this->input->post('descuentoEspecial');
            $img = $this->input->post('imagenes');
            //lectura de estatus de imagenes viejas
            $img_viejas = $img['viejas'];
            $imagenes = [0,0,0];
            $eliminar = [];
            $crear = [];
            foreach($img_viejas as $index => $estatus){
                $numero = $index+1;
                if($estatus === "false"){
                    array_push($eliminar, $numero);
                }else{
                    $imagenes[$index] = 1;
                }
            }
            
            if(isset($_FILES['imagenes'])){
                $img = $_FILES['imagenes'];
                //lectura de estatus de imagenes nuevas
                $img_nuevas = $img['tmp_name']['nuevas'];
                foreach($img_nuevas as $index => $imagen){
                    $numero = $index+1;
                    array_push($eliminar, $numero);
                    array_push(
                        $crear,
                        array(
                            'numero' => $numero,
                            'imagen' => $imagen
                        )
                    );
                    $imagenes[$index] = 1;
                }
            }
            
            $imgMask = $imagenes[0]*1 + $imagenes[1]*2 + $imagenes[2]*4;
            
            
            //guardado de datos
            $this->load->model('m_admin');
            if(!$nuevo){
                $this->m_admin->actualizar_producto($codigo,$id_categoria,$tipo,$tela,$talla_unica,$tallas,$observaciones,$precio,$descuento_especial,$imgMask);
                $this->cambiar_imagenes($codigo,$id_categoria,$eliminar,$crear);
                http_response_code(204);
            }else{
                $p = $this->m_admin->nuevo_producto($codigo,$id_categoria,$tipo,$tela,$talla_unica,$tallas,$observaciones,$precio,$descuento_especial,$imgMask);
                if($p){
                    $this->cambiar_imagenes($codigo,$id_categoria,$eliminar,$crear);
                    http_response_code(204);
                }else{
                    http_response_code(400);
                    echo "Ya existe un producto cargado con el código indicado";
                }
            }
        }else{
            http_response_code(401);
        }
    }
    public function faltantes(){
        $this->load->model('m_admin');
        $faltantes=$this->m_admin->faltantes();
        $codigos = array();
        foreach($faltantes as $f){
            array_push($codigos, $f->codigo);
        }
        echo json_encode($codigos);
    }
    public function novedades(){
        if($this->session->userdata('user')){
            $this->load->model('m_admin');
            echo json_encode($this->m_admin->novedades());
        }else{
            http_response_code(401);
        }
    }
    public function novedad($id){
        $this->load->model('m_admin');
        echo json_encode($this->m_admin->novedad($id));
    }
    public function guardar_novedad(){
        if($this->session->userdata('user')){
            //lectura de datos del cliente
            $id = $this->input->post('id');
            $titulo = $this->input->post('titulo');
            $categoria = $this->input->post('categoria');
            $contenido = $this->input->post('contenido');
            $video = '';
            if($this->input->post('video')){
                $video = $this->input->post('video');
            }
            $nuevo = $this->input->post('nuevo');
            //guardado de datos
            $this->load->model('m_admin');
            if(!$nuevo){
                $this->m_admin->actualizar_novedad($id,$titulo,$categoria,$contenido,$video);
                $n = $id;
            }else{
                $n = $this->m_admin->nueva_novedad($titulo,$categoria,$contenido,$video);
            }
            if(isset($_FILES['nuevaPortada'])){
                $portada = $_FILES['nuevaPortada'];
                move_uploaded_file($portada['tmp_name'], './catalogo/novedades/' . $n . '.jpg');
            }
            if(isset($_FILES['nuevoEncabezado'])){
                $encabezado = $_FILES['nuevoEncabezado'];
                move_uploaded_file($encabezado['tmp_name'], './catalogo/novedades/' . $n . '-1.jpg');
            }
            echo $n;
        }else{
            http_response_code(401);
        }
    }
    public function eliminar_novedad(){
        if($this->session->userdata('user')){
            $id = $this->input->post('id');
            $this->load->model('m_admin');
            $this->m_admin->eliminar_novedad($id);
        }else{
            http_response_code(401);
        }
    }
    private function cambiar_imagenes($codigo,$id_categoria,$eliminar,$crear){
        //eliminar imagenes viejas
        foreach($eliminar as $e){
            $this->eliminar_imagen($codigo,$e,$id_categoria);
        }
        //crear imagenes nuevas
        foreach($crear as $c){
            $this->crear_imagen($codigo,$c['numero'],$id_categoria,$c['imagen']);
        }
    }
    private function crear_imagen($codigo,$numero,$id_categoria,$imagen){
        $ruta = './catalogo/' . $id_categoria . '/';
        $img800 = $ruta . $codigo . '_' . $numero . '_800.jpg';
        $img400 = $ruta . $codigo . '_' . $numero . '_400.jpg';
        $img238 = $ruta . $codigo . '_' . $numero . '_238.jpg';
        $img67 = $ruta . $codigo . '_' . $numero . '_67.jpg';
        move_uploaded_file($imagen, $img800);
        copy($img800, $img400);
        $this->escalar_imagen($img400, 400);
        copy($img800, $img238);
        $this->escalar_imagen($img238, 238);
        copy($img800, $img67);
        $this->escalar_imagen($img67, 67);
    }
    private function eliminar_imagen($codigo,$numero,$id_categoria){
        $ruta = './catalogo/' . $id_categoria . '/';
        $img800 = $ruta . $codigo . '_' . $numero . '_800.jpg';
        $img400 = $ruta . $codigo . '_' . $numero . '_400.jpg';
        $img238 = $ruta . $codigo . '_' . $numero . '_238.jpg';
        $img67 = $ruta . $codigo . '_' . $numero . '_67.jpg';
        if(file_exists($img800)){
            unlink($img800);
        }
        if(file_exists($img400)){
            unlink($img400);
        }
        if(file_exists($img238)){
            unlink($img238);
        }
        if(file_exists($img67)){
            unlink($img67);
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
    public function whatsapp(){
        $this->load->model('m_whatsapp');
        $w = $this->m_whatsapp->listar();
        echo json_encode($w);
    }
    public function eliminar_whatsapp(){
        $id = $this->input->post('id');
        if($id){
            $this->load->model('m_whatsapp');
            $w = $this->m_whatsapp->eliminar($id);
        }
    }
    public function guardar_whatsapp(){
        $numero = $this->input->post('numero');
        if($numero){
            $this->load->model('m_whatsapp');
            $w = $this->m_whatsapp->guardar($numero);
        }
    }
}