<?php

class M_app extends CI_Model{
    function get_categorias(){
        $this->db->order_by('orden', 'asc');
        $query=$this->db->get('categoria');
        return $query->result();
    }
    function get_categoria($id_categoria){
        $query=$this->db->get_where('categoria',array('id' => $id_categoria));
        return $query->row();
    }
    function get_imagenes($id_categoria,$sitio){
        $query=$this->db->query("select * from imagen as i inner join existencia as e on i.nombre=e.nombre_imagen where i.id_categoria=$id_categoria and sitio='$sitio' and e.existencia>0 order by i.orden desc");
        return $query->result();
    }
    function nuevo_representante($post){
        do{
            $id = $this->aleatorio();
            $query = $this->db->get_where('lucychat.usuario', array('id' => $id));
            $existe = $query->num_rows();
        }while($existe > 0);
        
        $data = array(
            'id' => $id,
            'nombre' => $post['nombre'],
            'cedula' => $post['cedula'],
            'direccion' => $post['direccion'],
            'ciudad' => $post['ciudad'],
            'departamento' => $post['departamento'],
            'edad' => $post['edad'],
            'sexo' => $post['sexo'],
            'telefono_movil' => $post['telefono_movil'],
            'telefono_fijo' => $post['telefono_fijo'],
            'tiene_android' => $post['tiene_android'],
            'telefono_marca' => $post['telefono_marca'],
            'telefono_modelo' => $post['telefono_modelo'],
            'telefono_so' => $post['telefono_so'],
            'ref1_nombre' => $post['ref1_nombre'],
            'ref1_cedula' => $post['ref1_cedula'],
            'ref1_telefono_movil' => $post['ref1_telefono_movil'],
            'ref1_telefono_fijo' => $post['ref1_telefono_fijo'],
            'ref2_nombre' => $post['ref2_nombre'],
            'ref2_cedula' => $post['ref2_cedula'],
            'ref2_telefono_movil' => $post['ref2_telefono_movil'],
            'ref2_telefono_fijo' => $post['ref2_telefono_fijo'],
            'experiencia' => $post['experiencia'],
            'experiencia_lugar' => $post['experiencia_lugar'],
            'experiencia_tiempo' => $post['experiencia_tiempo'],
            'aspiraciones' => $post['aspiraciones']
        );
        
        $this->db->insert('lucychat.usuario',$data);
        if($this->db->affected_rows() > 0){
            return $id;
        }else{
            return false;
        }
    }
    function representantes(){
        $this->db->where('tipo','rep');
        $query = $this->db->get('lucychat.usuario');
        return $query->result();
    }
    function representante($id){
        $query = $this->db->get_where('lucychat.usuario',array('id' => $id));
        return $query->row();
    }
    function cambiar_representante($id){
        $this->db->query("update lucychat.usuario set habilitado = !habilitado where id='$id'");
        return $this->db->affected_rows();
    }
    
    private function aleatorio(){
        $letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numeros = '0123456789';
        $randstring = '';
        for ($i = 0; $i < 3; $i++) {
            $randstring = $randstring . $letras[rand(0, strlen($letras)-1)];
        }
        for ($i = 0; $i < 3; $i++) {
            $randstring = $randstring . $numeros[rand(0, strlen($numeros)-1)];
        }
        return $randstring;
    }
}
