<?php

class M_whatsapp extends CI_Model{
    function listar(){
        $query = $this->db->get('whatsapp');
        return $query->result();
    }
    function leer(){
        $this->db->order_by('fecha');
        $this->db->limit(1);
        $query = $this->db->get('whatsapp');
        $w = $query->row();

        $this->db->where('id',$w->id);
        $this->db->update('whatsapp', array(
            'fecha' => date('Y-m-d H:i:s')
        ));

        return $w;
    }
    function guardar($numero){
        $this->db->insert('whatsapp', array(
            'numero' => $numero,
            'fecha' => date('Y-m-d H:i:s')
        ));
    }
    function eliminar($id){
        $this->db->where('id',$id);
        $this->db->delete('whatsapp');
    }
}
