<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fbapp extends CI_Controller {

	public function index()
	{
            $this->load->model('m_site');
            $data['categorias']=$this->m_site->get_categorias();
            $this->load->view('fbapp_header',$data);
            $this->load->view('fbapp_categorias',$data);
            $this->load->view('fbapp_bottom');
	}
        public function productos($id_categoria=""){
            if($id_categoria==""){
                header('location: ' . base_url());
            }
            $this->load->model('m_site');
            $data['categorias']=$this->m_site->get_categorias();
            
            if(strtoupper($id_categoria)=='MAYOR'){
                $data['mayor'] = true;
                $data['productos'] = $this->m_site->get_productos_mayor();
                $this->load->view('fbapp_header',$data);
                $this->load->view('fbapp_productos_mayor',$data);
            }else{
                $data['categoria'] = $this->m_site->get_categoria($id_categoria);
                $data['productos'] = $this->m_site->get_productos($id_categoria,false);
                $this->load->view('fbapp_header',$data);
                $this->load->view('fbapp_productos',$data);
            }
            $this->load->view('fbapp_bottom');            
        }
        public function producto($producto){
            $this->load->model('m_site');
            $data['producto']=$this->m_site->get_producto($producto);
            $this->load->view('producto',$data);
        }
        public function producto_mayor($producto){
            $this->load->model('m_site');
            $data['producto']=$this->m_site->get_producto_mayor($producto);
            $this->load->view('producto_mayor',$data);
        }
        public function consulta($product_id=""){
            if($product_id!=""){
                $url='http://lilicardenasmodas.ddns.net/index.php/api/product_available_colors/' . $product_id;
                echo file_get_contents($url);
            }
        }
}
