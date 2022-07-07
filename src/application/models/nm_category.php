<?php

class NM_category extends CI_Model{
    function categorias(){
        $query=$this->db->query("select catalogo.*,count(ejemplar.id) as cantidad from catalogo left join ejemplar on catalogo.id=ejemplar.id_catalogo group by catalogo.id order by catalogo.id desc");
        return $query->result();
    }
}

?>
