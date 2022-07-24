<?php
class M_Admin extends CI_Model{
    function rotativo($tipo){
        $this->db->order_by('orden', 'asc');
        $query=$this->db->get('slider');
        return $query->result();
    }
    function nueva_imagen_rotativo($nombre,$tipo){
        $this->db->insert('slider',array('nombre' => $nombre, 'enlace' => 'como-comprar'));
        return $this->db->affected_rows();
    }
    function cambiar_enlace_imagen($imagen,$enlace){
        $this->db->set('enlace',$enlace);
        $this->db->where('nombre',$imagen);
        $this->db->update('slider');
        return $this->db->affected_rows();
    }
    function eliminar_imagen_rotativo($nombre,$tipo){
        $this->db->where('nombre',$nombre);
        //$this->db->where('tipo',$tipo);
        $this->db->delete('slider');
    }
    function eliminar_producto($codigo){
        $this->db->where('codigo',$codigo);
        $this->db->delete('producto');
    }
    function comentarios(){
        $this->db->order_by('fecha','desc');
        $this->db->order_by('id','desc');
        $query = $this->db->get('comentario');
        return $query->result();
    }
    function eliminar_comentario($id){
        $this->db->where('id',$id);
        $this->db->delete('comentario');
    }
    function aprobar_comentario($id){
        $this->db->set('aprobado','!aprobado',false);
        $this->db->where('id',$id);
        $this->db->update('comentario');
    }
    function ordenar($elemento,$orden){
        $i = 1;
        foreach($orden as $o){
            $this->db->set('orden',$i);
            if($elemento === 'categoria'){
                $this->db->where('id',$o);
            }else if($elemento === 'producto'){
                $this->db->where('codigo',$o);
            }else if($elemento === 'rotativo'){
                $this->db->where('nombre',$o);
            }
            $this->db->update($elemento);
            $i++;
        }
    }
    function movil($inicio,$fin){
        $this->db->select('count(*) as cantidad,concat_ws("-",day(fecha),month(fecha),year(fecha)) as fecha');
        $this->db->group_by(array('year(fecha)','month(fecha)','day(fecha)'));
        $this->db->where('fecha >=', $inicio . ' 00:00:00');
        $this->db->where('fecha <=', $fin . ' 23:59:59');
        $query = $this->db->get('lucychat.usuario');
        $result = array();
        $i = 0;
        foreach($query->result() as $row){
            $i++;
            $r = array(
                'x' => $i,
                'etiqueta' => $row->fecha,
                'cantidad' => $row->cantidad
            );
            array_push($result,$r);
        }
        return $result;
    }
    function novedades(){
        $this->db->select('id,titulo,left(contenido,150) as vistaPrevia',false);
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

        return $novedad;
    }
    function nueva_novedad($titulo,$categoria,$contenido,$video){
        $data = array(
            'titulo' => $titulo,
            'categoria' => $categoria,
            'contenido' => $contenido,
            'video' => $video
        );
        $this->db->insert('novedad',$data);
        return $this->db->insert_id();
            
    }
    function actualizar_novedad($id,$titulo,$categoria,$contenido,$video){
        $data = array(
            'titulo' => $titulo,
            'categoria' => $categoria,
            'contenido' => $contenido,
            'video' => $video
        );
        $this->db->where('id',$id);
        $this->db->update('novedad',$data);
        return $this->db->affected_rows();
    }
    function eliminar_novedad($id){
        $this->db->where('id',$id);
        $this->db->delete('novedad');
    }
    function faltantes(){
        $this->db->select('e.codigo');
        $this->db->from('existencia as e');
        $this->db->join('producto as p', 'e.codigo = p.codigo', 'left');
        $this->db->where('p.codigo', null);
        $this->db->group_by('e.codigo');
        $query = $this->db->get();
        return $query->result();
    }
}
