<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller {
    public function __construct(){
        $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
        $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
        $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
        $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
        if ($iphone || $android || $palmpre || $ipod || $berry == true) {
            $request = parse_url($_SERVER['REQUEST_URI']);
            $path = $request["path"];
            $result = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
            header('Location: http://m.lucymodas.com' . str_replace('site', '#', $result));
        }   
        parent::__construct();
    }
    public function index(){
        date_default_timezone_set('America/Caracas');
        $this->load->model('m_site');
        $data['slides']=$this->m_site->get_slider();
        $config=$this->m_site->get_configuraciones();
        if($config['promo'] == 'SI'){
            $file_headers = @get_headers(base_url() . '/img/promo/promo' . mdate('%d-%m-%y') . '.png');
            if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
                $config['promo'] = 'NO';
            }
        }
        $data['config']=$config;
        $this->top();
        $this->load->view('start',$data);
        $this->load->view('bottom');
    }
    public function top($data=[]){
        $this->load->model('m_site');
        //$data['categorias'] = $this->m_site->get_categorias();

        $this->load->helper('callService');
        $this->load->helper('migrationConverter');
        $callService = new callservicehelper();
        $categoriesData = $callService->getCategories(100,0);
        $data['categorias'] = migrationconverterhelper::categories($categoriesData["data"]);
        $data['banner']=$this->m_site->get_banner();
        $data['config']=$this->m_site->get_configuraciones();
        $this->load->view('top',$data);
    }
    public function quienes_somos(){
        $this->load->model('m_site');
        $this->top();
        $this->load->view('quienes_somos');
        $this->load->view('bottom');
    }
    public function preguntas_frecuentes(){
        $this->load->model('m_site');
        $this->top();
        $this->load->view('preguntas_frecuentes');
        $this->load->view('bottom');
    }
    public function thanks(){
        $this->load->model('m_site');
        $this->top();
        
        $reference_sale = explode("-",$this->input->get('reference_sale'));
        
        $data['email'] = $this->input->get('buyerEmail'); //Email
        $data['name']= $this->input->get('cc_holder'); //Nombre de Comprador
        $data['description'] = $this->input->get('description'); //Motivo y Pedido ID
        $data['success'] = $this->input->get('polTransactionState') == "4" ? 'completado' : 'fallido';
        
        $this->load->view('thanks',$data);
        $this->load->view('bottom');
    }
    public function politicas_cambios(){
        $this->load->model('m_site');
        $this->top();
        $this->load->view('politicas_cambios');
        $this->load->view('bottom');
    }
    public function politicas_envios(){
        $this->load->model('m_site');
        $this->top();
        $this->load->view('politicas_envios');
        $this->load->view('bottom');
    }
    public function novedades($id=0){
        $this->load->model('m_site');
        $this->top();
        if($id === 0){
            $data['novedades'] = $this->m_site->novedades();
            $this->load->view('novedades',$data);
        }else{
            if($this->input->post('nombre')){
                $nombre = $this->input->post('nombre');
                $reaccion = $this->input->post('reaccion');
                $comentario = $this->input->post('comentario');
                $this->m_site->guardar_comentario_novedad($id,$nombre,$reaccion,$comentario);
            }
            $data['novedad'] = $this->m_site->novedad($id);
            $this->load->view('novedad',$data);
        }
        $this->load->view('bottom');
    }
    public function productos($categoria,$producto=false){
        if($categoria==""){
            header('location: ' . base_url());
        }
        date_default_timezone_set('America/Caracas');
        $data['ver']=$producto;
        $this->load->model('m_site');
        $this->top();

        $this->load->helper('callService');
        $this->load->helper('migrationConverter');

        $callService = new callservicehelper();

        if(strtoupper($categoria)=='MAYOR'){
            $data['productos'] = $this->m_site->get_productos_mayor();
            $this->load->view('productos_mayor',$data);
            $this->load->view('compras_al_mayor');
        }else{
            //$data['categoria'] = $this->m_site->get_categoria($categoria);
            $categoriaData = $callService->getCategory($categoria);
            $data["categoria"] = migrationconverterhelper::category($categoriaData);

            $products = $callService->getProducts(100,0, "category::" . $categoria ."|published::1");
            $productsData = migrationconverterhelper::products($products["data"]);

            $data['productos'] = $productsData;
            $this->load->view('productos',$data);
            if($categoria == 9){
                $this->load->view('panales');
            }
        }
        $this->load->view('bottom');
    }
    public function producto($producto){
        $this->load->model('m_site');

        $this->load->helper('callService');
        $this->load->helper('migrationConverter');

        $callService = new callservicehelper();

        $productData = $callService->getProduct($producto);

        $data["producto"] = migrationconverterhelper::product($productData);

        $data["disponibilidad"] = migrationconverterhelper::sizes($productData);
        $this->load->view('producto',$data);
    }
    public function producto_mayor($producto){
        $this->load->model('m_site');
        $data['producto']=$this->m_site->get_producto_mayor($producto);
        $data['disponibilidad'] = $this->group_by('talla',$this->m_site->disponibilidad($producto));
        $this->load->view('producto_mayor',$data);
    }
    public function consulta($id=""){
        if($id!=""){
            $disponibilidad = [];
            $this->load->model('m_site');
            $disponibilidad = $this->group_by('talla',$this->m_site->disponibilidad($id));
            return $disponibilidad;
        }
    }
    public function consulta_json($product_id=""){
        if($product_id!=""){
            $disponibilidad='';
            $url='http://' . SERVIDOR_LUCY . '/api/ext/leer_disponibilidad/' . $product_id;
            $disponibilidad=$disponibilidad . file_get_contents($url);
            echo $disponibilidad;
        }
    }
    
    public function como_comprar(){
        $this->load->model('m_site');
        $this->top();
        $this->load->view('como_comprar');
        $this->load->view('bottom');
    }
    public function pago(){
        $this->load->model('m_site');
        
        
        if(isset($_POST['nombre'])){
            $e=false;

            $nombre=trim($this->input->post('nombre'));
            $error['nombre']['data']=$nombre;
            if($nombre==''){
                $e=true;
                $error['nombre']['error']='El nombre no puede estar en blanco';
            }

            $telefono=trim($this->input->post('telefono'));
            $error['telefono']['telefono']=$this->input->post('telefono');
            if($this->input->post('telefono')==''){
                $e=true;
                $error['telefono']['error']='El telefono no puede estar en blanco';
            }else if(!is_numeric($this->input->post('telefono'))){
                $e=true;
                $error['telefono']['error']='El telefono debe estar conformado solo por números';
            }else if(strlen($this->input->post('telefono'))<7){
                $e=true;
                $error['telefono']['error']='El telefono debe estar conformado siete números';
            }

            $email=trim($this->input->post('email'));
            $error['email']['data']=$email;
            if($email==''){
                $e=true;
                $error['email']['error']='El correo electrónico no puede estar en blanco';
            }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $e=true;
                $error['email']['error']='Debe ingresar un correo electrónico válido';
            }

            $forma=$this->input->post('forma');
            $error['forma']['data']=$forma;

            if($forma=='Transferencia Bancaria'){
                $origen=$this->input->post('origen');
            }else{
                $origen="";
            }
            $error['origen']['data']=$origen;
            if($origen=='seleccionar'){
                $e=true;
                $error['origen']['error']='Debe seleccionar un banco';
            }

            $banco=$this->input->post('banco');
            $error['banco']['data']=$banco;
            if($banco=='seleccionar'){
                $e=true;
                $error['banco']['error']='Debe seleccionar un banco';
            }

            $numero=trim($this->input->post('numero'));
            $error['numero']['data']=$numero;

            $monto=trim($this->input->post('monto'));
            $error['monto']['data']=$monto;
            if($monto==''){
                $e=true;
                $error['monto']['error']='El monto no puede estar en blanco';
            }

            $this->load->model('m_pago');

            if($e){
                $this->top();
                $this->load->view('pago',$error);
                $this->load->view('bottom');
            }else{
                if($this->m_pago->registrar_pago($nombre,$telefono,$email,$forma,$origen,$banco,$numero,$monto)>0){
                    $data['conversion']=1;
                    $this->top($data);
                    $this->load->view('pago_exito',$error['telefono']);
                    $this->load->view('bottom');
                }else{
                    $this->top();
                    $this->load->view('pago_error');
                    $this->load->view('bottom');
                }
            }
        }else{
            $this->top();
            $this->load->view('pago');
            $this->load->view('bottom');
        }
    }
    public function renove(){
        $this->load->model('m_site');
        
        
        $this->top();
        if($this->input->post('ci_letra')){
            $e=false;
            
            $ci_letra=trim($this->input->post('ci_letra'));
            $ci_numero=trim($this->input->post('ci_numero'));
            $catalogo=trim($this->input->post('catalogo'));
            
            $error['ci']['letra']=$ci_letra;
            $error['ci']['numero']=$ci_numero;
            if($ci_numero==''){
                $e=true;
                $error['ci']['error']='La cédula o RIF no puede estar en blanco';
            }
            
            $error['catalogo']['id']=$catalogo;
            if($catalogo==''){
                $e=true;
                $error['catalogo']['error']='El código del catalogo no puede estar en blanco';
            }
            
            if($e){
                $this->load->view('renove',$error);
            }else{
                $ci=$ci_letra . $ci_numero;
                
                //$r=@file_get_contents('http://lilicardenasmodas.ddns.net/index.php/api/save_catalog/' . $ci . '/' . $catalogo);
                $r=@file_get_contents('http://localhost:88/index.php/api/save_catalog/' . $ci . '/' . $catalogo);
                
                $result=intval($r);
                if($result>0){
                    $this->load->view('renove_exito');
                }elseif($result==-4){
                    $error['catalogo']['error']='El codigo ya ha sido activado anteriormente por otra persona';
                    $this->load->view('renove',$error);
                }elseif($result==-1){
                    $error['catalogo']['error']='El codigo introducido corresponde a un catalogo que ya ha caducado';
                    $this->load->view('renove',$error);
                }elseif($result==-2){
                    $error['catalogo']['error']='No existe ningún catálogo con este código';
                    $this->load->view('renove',$error);
                }elseif($result==-3){
                    $error['ci']['error']='No existe ningún cliente registrado con esta cédula de identidad o RIF';
                    $this->load->view('renove',$error);
                }else{
                    $this->load->view('renove_error');
                }
                
            }
        }else{
            $this->load->view('renove');
        }
        $this->load->view('bottom');
    }
    function catalogo(){
        date_default_timezone_set('America/Caracas');
        $this->load->model('m_site');
        
        
        $this->top();
        $this->load->view('catalogo');
        $this->load->view('bottom');
    }
    public function guardar_premarketing(){
        $nombre=$this->input->post('nombre');
        $telefono=$this->input->post('telefono');
        $contacto=$nombre . ';' . $telefono;
        $contactos=fopen('./contactos.json', 'a+');
        fwrite($contactos, $contacto . PHP_EOL);
        fclose($contactos);
        date_default_timezone_set('America/Caracas');
        $this->load->model('m_site');
        
        
        $this->top();
        $this->load->view('premarketing_exito');
    }
    public function descargar_catalogo(){
        $this->load->library('zip');
        $this->load->model('m_site');
        date_default_timezone_set('America/Caracas');
        $categorias=$this->m_site->get_categorias();
        foreach($categorias as $c){
            $imagenes=$this->m_site->get_imagenes($c->id,'des');
            foreach($imagenes as $i){
                $imagen=file_get_contents('./descargable/' . $c->id . '/' . $i->nombre);
                $this->zip->add_data('/' . $c->nombre . '/' . $i->nombre , $imagen);
            }   
        }
        $this->zip->download('Catalogo_LiliCardenasModas_' . date('d-m-Y_H:i',now()) . '.zip');
    }
    public function tracking(){
        date_default_timezone_set('America/Caracas');
        $this->load->model('m_site');
        
        
        $this->top();
        $this->load->view('tracking');
        $this->load->view('bottom');
    }
    public function comentarios(){
        date_default_timezone_set('America/Caracas');
        $this->load->model('m_site');
        $data['comentarios'] = $this->m_site->get_comentarios();
        $this->top();
        if($this->input->post('comentario')){
            $nombre = $this->input->post('nombre');
            $experiencia = $this->input->post('experiencia');
            $comentario = $this->input->post('comentario');
            
            $foto =  $_FILES['foto']['name'];
            if($foto !== ""){
                $foto_cargada = true;
            }else{
                $foto_cargada = false;
            }
            $r = $this->m_site->guardar_comentario($nombre,$comentario,$experiencia,$foto_cargada);
            if($r){
                $this->load->view('comentario_exito');
                if($foto_cargada){
                    move_uploaded_file($_FILES['foto']['tmp_name'], './img/comentario/' . $r . '.jpg');
                    $this->escalar_imagen('./img/comentario/' . $r . '.jpg', 45);
                }
            }else{
                $this->load->view('comentario_error');
            }
        }
        $this->load->view('comentarios',$data);
        $this->load->view('bottom');
    }
    private function escalar_imagen($imagen,$nuevo_alto){
        list($ancho, $alto) = getimagesize($imagen);
        $nuevo_ancho = floor($ancho * ($nuevo_alto / $alto));
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
    public function tracking_info($num_pedido){
        try{
            $eventos = json_decode(file_get_contents('http://' . SERVIDOR_LUCY . '/api/ext/rastrear_venta/' . $num_pedido));
        } catch (Exception $ex) {
            $eventos = -1;
        }
        if($eventos <= 0){
            echo $eventos;
        }else{
            $data['eventos'] = $eventos;
            $data['num_pedido'] = $num_pedido;
            $this->load->view('tracking_info',$data);
        }
    }
    public function comentario(){
        date_default_timezone_set('America/Caracas');
        $this->load->model('m_site');
        echo json_encode($this->m_site->get_comentario());
    }
    public function email(){
        $email = $this->input->post('email');
        $this->load->model('m_site');
        $this->m_site->registrar_email($email);
        $this->session->set_userdata('email_promo',$email);
        http_response_code(204);
    }
    public function fotos_disponibles($id_categoria=0,$id_producto=''){
        $this->load->model('m_site');
        if($id_categoria === 0){
            $categorias=$this->m_site->get_categorias();
            foreach($categorias as $categoria){
                echo '<a href="' . base_url() . 'site/fotos_disponibles/' . $categoria->id . '">' . $categoria->nombre . '</a><br>';
            }
        }else{
            if($id_producto === ''){
                $categoria=$this->m_site->get_categoria($id_categoria);
                $productos=$this->m_site->get_productos($id_categoria);
                echo '<h1>' . $categoria->nombre . '</h1>';
                foreach ($productos as $producto){
                    echo '<a href="' . base_url() . 'site/fotos_disponibles/' . $id_categoria . '/' . $producto->codigo . '">' . $producto->codigo . '</a><br>';
                }
            }else{
                $creado = 0;
                $zipname = $id_producto . '.zip';
                $zip = new ZipArchive;
                $zip->open($zipname, ZipArchive::CREATE);
                $path = 'catalogo/' . $id_categoria . '/' . $id_producto . '_1_800.jpg';
                if(file_exists($path)){
                    $zip->addFromString(basename($path),  file_get_contents($path));  
                    $creado = 1;
                }
                $path = 'catalogo/' . $id_categoria . '/' . $id_producto . '_2_800.jpg';
                if(file_exists($path)){
                    $zip->addFromString(basename($path),  file_get_contents($path));  
                    $creado = 1;
                }
                $zip->close();
                if($creado){
                    header('location: ' . base_url() . $id_producto . '.zip');
                }else{
                    echo 'Error al crear el archivo ZIP';
                }
            }
        }
    }
    private function group_by($key, $data) {
        $result = array();
    
        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }
    
        return $result;
    }
}
