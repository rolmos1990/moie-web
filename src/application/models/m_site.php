<?php

class M_site extends CI_Model{
    function get_categorias(){
        $this->db->where('visible',1);
        $this->db->order_by('orden', 'asc');
        $query=$this->db->get('categoria');
        return $query->result();
    }
    function get_categoria($id_categoria){
        $query=$this->db->get_where('categoria',array('id' => $id_categoria));
        return $query->row();
    }
    function get_categoria_por_nombre($nombre_categoria){
        $query=$this->db->get_where('categoria',array('nombre' => $nombre_categoria));
        return $query->row();
    }

    function nueva_categoria($nombre){
        $this->db->insert('categoria',array('nombre' => $nombre));
        return $this->db->insert_id();
    }
    function actualizar_categoria($id_categoria,$nuevo_nombre){
        $this->db->where('id', $id_categoria);
        $this->db->update('categoria', array('nombre' => $nuevo_nombre));
        return $this->db->affected_rows();
    }
    function eliminar_categoria($id_categoria){
        $this->db->where('id', $id_categoria);
        $this->db->delete('categoria');
        return $this->db->affected_rows();
    }
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
    function eliminar_producto($codigo){
        $this->db->delete('producto',array('codigo' => $codigo));
        return $this->db->affected_rows();
    }
    function vaciar_categoria($id_categoria){
        $this->db->delete('producto',array('id_categoria' => $id_categoria));
        return $this->db->affected_rows();
    }
    function ordenar_categorias($categoriasJSON){
        $o=1;
        $categorias=json_decode($categoriasJSON);
        foreach($categorias as $c){
            $query=$this->db->query("update categoria set orden=$o where id=$c");
            $o=$o+1;
        }
        return $this->db->affected_rows();
    }
    function ordenar_productos($productosJSON){
        $productos=json_decode($productosJSON);
        $o=1;
        foreach($productos as $p){
            $query=$this->db->query("update producto set orden=$o where codigo='$p'");
            $o=$o + 1;
        }
        return $this->db->affected_rows();
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
    function actualizar_existencia($existenciaJSON){
        $existencia=json_decode($existenciaJSON);
        
        $this->db->query("update producto set existencia=0");
        $this->db->query("update producto set existencia=1 where codigo like 'COMBO%'");

        $this->db->where('codigo != ""');
        $this->db->delete('existencia');

        foreach($existencia as $e){
            $codigo = $e->codigo;
            $this->db->insert('existencia',array(
                'codigo' => $codigo,
                'talla' => $e->talla,
                'color' => $e->color
            ));
            $this->db->query("update producto set existencia=1 where codigo='$codigo' or codigo='$codigo" . "_'");
        }
    }
    function disponibilidad($codigo){
        $this->db->select('talla');
        $this->db->select('color');
        $this->db->where('codigo',$codigo);
        $query = $this->db->get('existencia');
        return $query->result_array();
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





    function existe_producto($codigo){
        $query=$this->db->query("select codigo from producto where codigo='$codigo'");
        if($query->num_rows>0){
            return true;
        }else{
            return false;
        }
    }
    function nuevo_producto($codigo,$id_categoria,$tipo,$tela,$talla_unica,$tallas,$observaciones,$precio,$imagenes){
        $nuevo = array(
            'codigo' => $codigo,
            'id_categoria' => $id_categoria,
            'tipo' => $tipo,
            'tela' => $tela,
            'talla_unica' => $talla_unica,
            'tallas' => $tallas,
            'observaciones' => $observaciones,
            'precio' => $precio,
            'imagenes' => $imagenes
        );
        $this->db->insert('producto',$nuevo);
        return $this->db->affected_rows();
    }
    function editar_producto($codigo,$tipo,$tela,$talla_unica,$tallas,$observaciones,$precio){
        $producto = array(
            'tipo' => $tipo,
            'tela' => $tela,
            'talla_unica' => $talla_unica,
            'tallas' => $tallas,
            'observaciones' => $observaciones,
            'precio' => $precio
        );
        $this->db->where('codigo',$codigo);
        $this->db->update('producto',$producto);
        return $this->db->affected_rows();
    }
    function get_productos($id_categoria,$agotados=false){
        if($agotados){
            $query = $this->db->query("select producto.*,categoria.*,if(producto.descuento_especial > 0,CEIL(producto.precio*((100-producto.descuento_especial)/100)),CEIL(producto.precio*((100-categoria.descuento)/100))) as precio_descuento,CEIL(producto.precio*((100-categoria.descuento_mayor_1)/100)) as precio_descuento_mayor_1,producto.descuento_especial "
                    . "from producto inner join categoria on producto.id_categoria=categoria.id "
                    . "where id_categoria=$id_categoria order by producto.orden asc");
        }else{
            $query = $this->db->query("select producto.*,categoria.*,if(producto.descuento_especial > 0,CEIL(producto.precio*((100-producto.descuento_especial)/100)),CEIL(producto.precio*((100-categoria.descuento)/100))) as precio_descuento,CEIL(producto.precio*((100-categoria.descuento_mayor_1)/100)) as precio_descuento_mayor_1,producto.descuento_especial "
                    . "from producto inner join categoria on producto.id_categoria=categoria.id "
                    . "where id_categoria=$id_categoria and existencia>0 order by producto.orden asc");
        }
        return $query->result();
    }
    function get_productos_todos(){
            $query = $this->db->query("select codigo "
                    . "from producto "
                    . "order by orden asc");
        return $query->result();
    }
    function get_producto($producto){
        $query = $query = $this->db->query("select producto.*,categoria.descuento as descuento,if(producto.descuento_especial > 0,CEIL(producto.precio*((100-producto.descuento_especial)/100)),CEIL(producto.precio*((100-categoria.descuento)/100))) as precio_descuento "
                    . "from producto inner join categoria on producto.id_categoria=categoria.id "
                    . "where codigo='$producto'");
        return $query->row();
    }
    function get_producto_mayor($producto){
        $query = $query = $this->db->query("select producto.*,"
                . "categoria.*,"
                . "CEIL(producto.precio*((100-categoria.descuento_mayor_1)/100)) as precio_descuento_mayor_1, "
                . "CEIL(producto.precio*((100-categoria.descuento_mayor_2)/100)) as precio_descuento_mayor_2 "
                . "from producto inner join categoria on producto.id_categoria=categoria.id "
                . "where codigo='$producto'");
        return $query->row();
    }
    function productos_cargados(){
        $query=$this->db->query("select codigo from producto");
        $cargados=array();
        foreach($query->result() as $r){
            $cargados[]=$r->codigo;
        }
        return $cargados;
    }
    function editar_descuentos($id_categoria,$descuento,$cantidad_mayor_1,$descuento_mayor_1,$cantidad_mayor_2,$descuento_mayor_2){
        $descuentos = array('descuento' => $descuento,
            'cantidad_mayor_1' => $cantidad_mayor_1,
            'cantidad_mayor_2' => $cantidad_mayor_2,
            'descuento_mayor_1' => $descuento_mayor_1,
            'descuento_mayor_2' => $descuento_mayor_2
            );
        $this->db->where('id', $id_categoria);
        $this->db->update('categoria', $descuentos);
        return $this->db->affected_rows();
    }
    //TODO -- cambio aqui para obtener productos mayor
    function get_productos_mayor(){
        $query = $this->db->query("select producto.*,"
                . "categoria.*,"
                . "CEIL(producto.precio*((100-categoria.descuento_mayor_1)/100)) as precio_descuento_mayor_1,"
                . "CEIL(producto.precio*((100-categoria.descuento_mayor_2)/100)) as precio_descuento_mayor_2 "
                . "from producto inner join categoria on producto.id_categoria=categoria.id "
                . "where (categoria.cantidad_mayor_1>0 or categoria.cantidad_mayor_2>0) and existencia>0 and categoria.visible>0 "
                . "order by categoria.orden asc, producto.orden asc");
        return $query->result();
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
}
