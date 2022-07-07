<?php
class M_Admin extends CI_Model{
    function categorias(){
        $this->db->order_by('orden', 'asc');
        $query=$this->db->get('categoria');
        return $query->result();
    }
    function categoria($id){
        $this->db->where('id',$id);
        $query_categoria = $this->db->get('categoria');
        $categoria = $query_categoria->row_array();
        
        $this->db->select('codigo, precio, existencia, fecha, imagenes');
        $this->db->where('id_categoria',$id);
        $this->db->order_by('producto.orden','asc');
        $query_productos = $this->db->get('producto');
        $categoria['productos'] = $query_productos->result_array();
        
        return $categoria;
    }
    function nueva_categoria($nombre){
        $this->db->insert('categoria',array('nombre' => $nombre));
        return $this->db->insert_id();
    }
    function cambiar_nombre_categoria($id,$nombre){
        $this->db->set('nombre',$nombre);
        $this->db->where('id',$id);
        $this->db->update('categoria');
        return $this->db->affected_rows();
    }
    function actualizar_categoria($id){
        $this->db->set('actualizacion',date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('categoria');
        return $this->db->affected_rows();
    }
    function vaciar_categoria($id){
        $this->db->delete('producto',array('id_categoria' => $id));
        return $this->db->affected_rows();
    }
    function eliminar_categoria($id){
        $this->db->delete('producto',array('id_categoria' => $id));
        $this->db->delete('categoria',array('id' => $id));
        return $this->db->affected_rows();
    }
    function descuentos($id,$descuentos){
        $this->db->set('descuento',$descuentos['detal']);
        $this->db->set('cantidad_mayor_1',$descuentos['descuento1']['cantidad']);
        $this->db->set('descuento_mayor_1',$descuentos['descuento1']['porcentaje']);
        $this->db->set('cantidad_mayor_2',$descuentos['descuento2']['cantidad']);
        $this->db->set('descuento_mayor_2',$descuentos['descuento2']['porcentaje']);
        $this->db->where('id',$id);
        $this->db->update('categoria');
        return $this->db->affected_rows();
    }
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
    function producto($codigo){
        $this->db->select('codigo,tipo,tela,talla_unica as tallaUnica,tallas,observaciones,precio,descuento_especial as descuentoEspecial,imagenes,fecha,id_categoria as idCategoria');
        $this->db->where('codigo',$codigo);
        $query = $this->db->get('producto');
        return $query->row();
    }
    function nuevo_producto($codigo,$id_categoria,$tipo,$tela,$talla_unica,$tallas,$observaciones,$precio,$descuento_especial,$imagenes){
        $query = $this->db->get_where('producto',array('codigo' => $codigo));
        if($query->num_rows() > 0){
            return 0;
        }else{
            $data = array(
                'codigo' => $codigo,
                'id_categoria' => $id_categoria,
                'tipo' => $tipo,
                'tela' => $tela,
                'talla_unica' => $talla_unica,
                'tallas' => $tallas,
                'observaciones' => $observaciones,
                'precio' => $precio,
                'descuento_especial' => $descuento_especial,
                'imagenes' => $imagenes,
                'fecha' => date('Y-m-d H:i:s')
            );
            $this->db->insert('producto',$data);
            return $this->db->affected_rows();
        }
            
    }
    function actualizar_producto($codigo,$id_categoria,$tipo,$tela,$talla_unica,$tallas,$observaciones,$precio,$descuento_especial,$imagenes){
        $data = array(
            'codigo' => $codigo,
            'id_categoria' => $id_categoria,
            'tipo' => $tipo,
            'tela' => $tela,
            'talla_unica' => $talla_unica,
            'tallas' => $tallas,
            'observaciones' => $observaciones,
            'precio' => $precio,
            'descuento_especial' => $descuento_especial,
            'imagenes' => $imagenes,
            'fecha' => date('Y-m-d H:i:s')
        );
        $this->db->where('codigo',$codigo);
        $this->db->update('producto',$data);
        
        return $this->db->affected_rows();
    }
    function productos_cargados(){
        $this->db->select('codigo');
        $query=$this->db->get("producto");
        $cargados=array();
        foreach($query->result() as $r){
            $cargados[]=$r->codigo;
        }
        return $cargados;
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
