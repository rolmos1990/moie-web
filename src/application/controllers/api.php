<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {
    function __construct(){
        header('Access-Control-Allow-Origin: *');
        parent::__construct();
    }
    public function index(){
        echo "LucyModas Movil API 0.2";
    }
    public function categorias(){
        $this->load->model('m_site');
        $categorias=$this->m_site->get_categorias();
        echo json_encode($categorias);
    }
    public function productos($id_categoria){
        $this->load->model('m_site');
        $productos=$this->m_site->get_productos($id_categoria);
        echo json_encode($productos);
    }
    public function productos_mayor($id_categoria){
        $this->load->model('m_site');
        $productos=$this->m_site->get_productos_mayor($id_categoria);
        echo json_encode($productos);
    }
    public function producto($codigo){
        $this->load->model('m_site');
        $producto = $this->m_site->get_producto($codigo);
        echo json_encode($producto);
    }
    public function producto_mayor($codigo){
        $this->load->model('m_site');
        $producto = $this->m_site->get_producto_mayor($codigo);
        echo json_encode($producto);
    }
    public function rotativos(){
        $this->load->model('m_site');
        echo json_encode($this->m_site->get_slider());
    }
    public function juego(){
        $semilla = intval(date('Ymd'));
        mt_srand($semilla);
        $numero = mt_rand(0,999);
        echo str_pad($numero, 3, '0', STR_PAD_LEFT);
    }
    public function registrar_pago(){
        $this->load->model('m_site');
        
        $e=false;

        $nombre=trim($this->input->post('nombre'));
        if($nombre==''){
            $e=true;
            $error['nombre']='El nombre no puede estar en blanco';
        }

        $telefono=trim($this->input->post('telefono'));
        if($this->input->post('telefono')==''){
            $e=true;
            $error['telefono']='El telefono no puede estar en blanco';
        }else if(!is_numeric($this->input->post('telefono'))){
            $e=true;
            $error['telefono']='El telefono debe estar conformado solo por números';
        }else if(strlen($this->input->post('telefono'))<7){
            $e=true;
            $error['telefono']='El telefono debe estar conformado siete números';
        }

        $email=trim($this->input->post('email'));
        if($email==''){
            $e=true;
            $error['email']='El correo electrónico no puede estar en blanco';
        }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $e=true;
            $error['email']='Debe ingresar un correo electrónico válido';
        }

        $forma=$this->input->post('forma');

        if($forma=='Transferencia Bancaria'){
            $origen=$this->input->post('origen');
        }else{
            $origen="";
        }

        if($origen=='seleccionar'){
            $e=true;
            $error['origen']='Debe seleccionar un banco';
        }

        $banco=$this->input->post('banco');

        if($banco=='seleccionar'){
            $e=true;
            $error['banco']='Debe seleccionar un banco';
        }

        $numero=trim($this->input->post('numero'));


        $monto=trim($this->input->post('monto'));

        if($monto==''){
            $e=true;
            $error['monto']='El monto no puede estar en blanco';
        }

        $this->load->model('m_pago');

        if($e){
            http_response_code(400);
            echo json_encode($error);
        }else{
            if($this->m_pago->registrar_pago($nombre,$telefono,$email,$forma,$origen,$banco,$numero,$monto)>0){
                http_response_code(204);
            }else{
                http_response_code(500);
            }
        }
    }
    public function disponibilidad($id=""){
        if($id!=""){
            $disponibilidad = [];
            $url='http://lucymodas.ddns.net/api/ext/leer_disponibilidad/' . $id;
            $disponibilidad = json_decode(file_get_contents($url));
            echo json_encode($disponibilidad);
        }
    }
    public function testimonio(){
        date_default_timezone_set('America/Caracas');
        $this->load->model('m_site');
        echo json_encode($this->m_site->get_comentario());
    }
    public function testimonios(){
        $this->load->model('m_site');
        $testimonios = array_slice($this->m_site->get_comentarios(),100);
        echo json_encode($testimonios);
    }
    public function whatsapp(){
        $this->load->model('m_whatsapp');
        $w = $this->m_whatsapp->leer();
        echo json_encode($w);
    }
}