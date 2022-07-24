<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movil extends CI_Controller {
    public function index(){
        echo "LucyModas Movil API 0.1";
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
    public function producto($id){
        $this->load->model('m_site');
        $producto=$this->m_site->get_producto($id);
        echo json_encode($producto);
    }
}
