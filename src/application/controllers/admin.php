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
            $ruta = './src/catalogo/slider/' . $nombre;
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
            $ruta = './src/catalogo/slider/' . $nombre;
            unlink($ruta);
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
