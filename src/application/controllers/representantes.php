<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Representantes extends CI_Controller {
    public function index(){
        date_default_timezone_set('America/Caracas');
        $this->top();
        $this->load->view('rep_inicio');
        $this->load->view('bottom');
    }
    public function mision_vision(){
        date_default_timezone_set('America/Caracas');
        $this->top();
        $this->load->view('rep_mision_vision');
        $this->load->view('bottom');
    }
    public function negocio(){
        date_default_timezone_set('America/Caracas');
        $this->top();
        $this->load->view('rep_negocio');
        $this->load->view('bottom');
    }
    public function catalogo(){
        date_default_timezone_set('America/Caracas');
        $this->top();
        $this->load->view('rep_catalogo');
        $this->load->view('bottom');
    }
    public function registro(){
        date_default_timezone_set('America/Caracas');
        $this->top();
        if(isset($_POST['nombre'])){
            
            $this->load->model('m_app');
            $r = $this->m_app->nuevo_representante($_POST);
            if($r){
                $data['id'] = $r;
                $this->load->view('rep_registro_exito',$data);
            }else{
                $this->load->view('rep_registro_error');
            }
        }else{
            $this->load->view('rep_registro');
        }
        $this->load->view('bottom');
    }
    private function top(){
        $data['representantes'] = true;
        $this->load->view('top',$data);
    }
    
}
