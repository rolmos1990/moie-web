<?php

class M_site extends CI_Model{
    function nueva_imagen($id_categoria,$nombre,$sitio){
        $query_orden=$this->db->query("select max(orden) as orden from imagen where id_categoria=$id_categoria and sitio='$sitio'");
        $row_orden=$query_orden->row();
        $orden=$row_orden->orden + 1;
        $this->db->insert('imagen',array('nombre' => $nombre, 'id_categoria' => $id_categoria, 'sitio' => $sitio, 'orden' => $orden ));
        $archivo=str_replace('.jpg','',$nombre);
        $referencia=preg_split('/_/',$archivo);
        foreach($referencia as $r){
            $sql2="REPLACE INTO articulo_imagen(referencia_articulo, nombre_imagen, categoria_imagen, sitio_imagen) VALUES ('$r', '$nombre', $id_categoria, '$sitio')";
            $this->db->query($sql2);
        }
        return $archivo;
    }
    function get_slider(){
        $this->db->order_by('orden', 'asc');
        $query=$this->db->get('slider');
        return $query->result();
    }
    function nuevo_slide($nombre){
        $this->db->insert('slider',array('nombre' => $nombre, 'enlace' => 'img/como_comprar.jpg'));
        return $this->db->affected_rows();
    }
    function eliminar_slide($nombre){
        $this->db->where('nombre',$nombre);
        $this->db->delete('slider');
    }
    function cambiar_enlace_slide($nombre,$enlace){
        $this->db->query("update slider set enlace='$enlace' where nombre='$nombre'");
        return $this->db->affected_rows();
    }
    function ordenar_slider($sliderJSON){
        $o=1;
        $slider=json_decode($sliderJSON);
        foreach($slider as $s){
            $query=$this->db->query("update slider set orden=$o where nombre='$s'");
            $o=$o+1;
        }
        return $this->db->affected_rows();
    }

    function get_configuraciones($tipo=false){
        $query = $this->db->get('configuracion');
        $config = array();
        foreach($query->result() as $c){
            $config[$c->clave] = $c->valor;
            if($tipo){
                $config[$c->clave] = array('valor' => $c->valor, 'tipo' => $c->tipo);
            }
        }
        return $config;
    }
    function guardar_configuraciones($config){
        $g = 0;
        foreach($config as $c){
            $clave = $c['clave'];
            $valor = $c['valor'];
            $this->db->query("update configuracion set valor='$valor' where clave='$clave'");
            $g = $g + $this->db->affected_rows();
        }
        return $g;
    }
    function get_comentarios($todos=false){
        if(!$todos){
            $this->db->where('aprobado',true);
        }
        $this->db->order_by('id','desc');
        $query = $this->db->get('comentario');
        return $query->result();
    }
    function get_comentario(){
        $query = $this->db->query('select id,nombre,comentario,experiencia,foto from comentario where aprobado=1 order by rand() limit 1');
        return $query->row();
    }
    function guardar_comentario($nombre,$comentario,$experiencia,$foto){
        $data = array(
            'nombre' => $nombre,
            'comentario' => $comentario,
            'experiencia' => $experiencia,
            'foto' => $foto
        );
        $this->db->insert('comentario',$data);
        if($this->db->affected_rows()>0){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    function cambiar_comentario($id){
        $this->db->query("update comentario set aprobado = !aprobado where id=$id");
        return $this->db->affected_rows();
    }
    function eliminar_comentario($id){
        $this->db->query("delete from comentario where id=$id");
        return $this->db->affected_rows();
    }
    function registrar_email($email){
        $query = $this->db->get_where('email',array('email' => $email));
        if($query->num_rows() === 0){
            $this->db->insert('email',array(
                'email' => $email
            ));
        }
    }
    function novedades(){
        $this->db->select('id,titulo,left(contenido,150) as vista_previa',false);
        $query = $this->db->get('novedad');
        $novedades = $query->result_array();

        foreach($novedades as $index => $n){
            $this->db->select('reaccion,count(*) as cantidad');
            $this->db->where('id_novedad',$n['id']);
            $this->db->where('reaccion !=','""',false);
            $this->db->group_by('reaccion');
            $this->db->order_by('cantidad','desc');
            $query_reacciones = $this->db->get('comentario_novedad');
            $novedades[$index]['reacciones'] = $query_reacciones->result_array();
        }

        return $novedades;
    }
    function novedad($id){
        $this->db->where('id',$id);
        $query = $this->db->get('novedad');
        $novedad = $query->row_array();

        $this->db->where('id_novedad',$id);
        $query_comentarios = $this->db->get('comentario_novedad');
        $novedad['comentarios'] = $query_comentarios->result_array();

        $this->db->where('categoria',$novedad['categoria']);
        $this->db->where('id!=',$id,false);
        $this->db->order_by('id','desc');
        $this->db->limit(3,0);
        $query_relacionadas = $this->db->get('novedad');
        $novedad['relacionadas'] = $query_relacionadas->result_array();

        return $novedad;
    }
    function guardar_comentario_novedad($id_novedad,$nombre,$reaccion,$comentario){
        $data = Array(
            'nombre' => $nombre,
            'reaccion' => $reaccion,
            'comentario' => $comentario,
            'id_novedad' => $id_novedad
        );
        $this->db->insert('comentario_novedad',$data);
    }

    function get_banner(){
        $this->db->order_by('orden', 'asc');
        $query=$this->db->get('banner');
        return $query->result();
    }
    function nuevo_banner_img($nombre){
        $this->db->insert('banner',array('nombre' => $nombre, 'enlace' => 'img/como_comprar.jpg'));
        return $this->db->affected_rows();
    }
    function eliminar_banner_img($nombre){
        $this->db->where('nombre',$nombre);
        $this->db->delete('banner');
    }
    function cambiar_enlace_banner_img($nombre,$enlace){
        $this->db->query("update banner set enlace='$enlace' where nombre='$nombre'");
        return $this->db->affected_rows();
    }
    function ordenar_banner($bannerJSON){
        $o=1;
        $banner=json_decode($bannerJSON);
        foreach($banner as $s){
            $query=$this->db->query("update banner set orden=$o where nombre='$s'");
            $o=$o+1;
        }
        return $this->db->affected_rows();
    }

}
