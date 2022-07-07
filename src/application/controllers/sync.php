<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sync extends CI_Controller {
    public function index(){
        echo "Sync JSON api";
    }
    public function pagos($desde=0){
        $this->load->model('m_pago');
        if($desde){
            echo $this->m_pago->pagos($desde);
        }else{
            echo($this->m_pago->pagos(0));
        }
    }
    public function existencia(){
        $this->load->model('m_site');
        $existencia = $this->input->post('existencia');
        
        if($existencia == false || $existencia == ''){
            echo "No se puede conectar con inventario, existencia no sincronizada";
        }else{
            $this->m_site->actualizar_existencia($existencia);
            echo "Existencia sincronizada";
        }
    }
    public function productos(){
        $this->load->model('m_site');
        $productos = $this->m_site->get_productos_todos();
        $pr = array();
        foreach($productos as $p){
            array_push($pr, $p->codigo);
        }
        echo json_encode($pr);
    }
}
