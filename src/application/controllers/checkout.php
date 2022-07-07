<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends CI_Controller {
    public function index(){
        echo 'Checkout';
    }
    public function generar_link_pago(){
        $id_venta = $this->input->post('id_venta');
        $monto = $this->input->post('monto');
        $nombre_cliente = $this->input->post('nombre_cliente');
        $ci_cliente = $this->input->post('ci_cliente');
        $telefono_cliente = $this->input->post('telefono_cliente');
        $direccion = $this->input->post('direccion');
        $ciudad = $this->input->post('ciudad');
        $sandbox = $this->input->post('sandbox');

        $this->load->model('m_checkout');
        $id_pago = $this->m_checkout->generar($id_venta,$monto,$nombre_cliente,$ci_cliente,$telefono_cliente,$direccion,$ciudad,$sandbox);

        echo 'http://lucymodas.com/checkout/pagar/' . $id_pago;
    }
    public function pagar($id){
        $this->load->model('m_checkout');
        $data = $this->m_checkout->leer($id);
        if($data != null){
            $this->load->view('checkout_payu',$data);
        }else{
            http_response_code(404);
        }
    }
    public function confirmacion($id){
        $id_transaccion = $this->input->post($transaction_id);
        $estatus_transaccion = $this->input->post($response_message_pol);
        $this->load->model('m_checkout');
        $this->m_checkout->confirmar($id, $id_transaccion, $estatus_transaccion);
    }
}
