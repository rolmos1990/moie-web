<?php

class M_checkout extends CI_Model{
    function generar($id_venta,$monto,$nombre_cliente,$ci_cliente,$telefono_cliente,$direccion,$ciudad,$sandbox){
        $data = array(
            'id_venta' => $id_venta,
            'monto' => $monto,
            'nombre_cliente' => $nombre_cliente,
            'ci_cliente' => $ci_cliente,
            'telefono_cliente' => $telefono_cliente,
            'direccion' => $direccion,
            'ciudad' => $ciudad,
            'sandbox' => $sandbox
        );
        $this->db->insert('checkout', $data);
        return $this->db->insert_id();
    }
    function leer($id){
        $this->db->where('id',$id);
        $query = $this->db->get('checkout');
        return $query->row_array();
    }
    function confirmar($id, $id_transaccion, $estatus_transaccion){
        $this->db->where('id',$id);
        $this->db->update('checkout', array(
            'id_transaccion' => $id_transaccion,
            'estatus_transaccion' => $estatus_transaccion
        ));
    }
}
