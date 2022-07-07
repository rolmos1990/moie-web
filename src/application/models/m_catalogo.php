<?php

class M_catalogo extends CI_Model{
    function catalogos(){
        $query=$this->db->query("select catalogo.*,count(ejemplar.id) as cantidad from catalogo left join ejemplar on catalogo.id=ejemplar.id_catalogo group by catalogo.id order by catalogo.id desc");
        return $query->result();
    }
    function generar_ejemplares($id_catalogo,$cantidad){
        $txt="";
        $i=0;
        while($i<$cantidad){
            $id_ejemplar=strtoupper(random_string('alnum', 6));
            $query=$this->db->query("select id from ejemplar where id='$id_ejemplar'");
            if($query->num_rows() === 0){
                $this->db->query("insert into ejemplar(id,id_catalogo) values('$id_ejemplar',$id_catalogo)");
                $txt=$txt . $id_ejemplar . "\r\n" ;
                $i++;
            }
        }
        return $txt;
    }
    function nuevo_catalogo($descripcion){
        $this->db->query("insert into catalogo(descripcion) values('$descripcion')");
        return $this->db->affected_rows();
    }
    function activar_catalogo($id,$activo){
        $this->db->query("update catalogo set activo=$activo where id=$id");
        return $this->db->affected_rows();
    }
}

?>