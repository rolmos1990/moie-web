<?php

class M_pago extends CI_Model{
    function registrar_pago($nombre,$telefono,$email,$forma,$origen,$banco,$numero,$monto){
        $this->db->query("insert into pago(nombre,telefono,email,forma,origen,banco,numero,monto,fechahora) values('$nombre','$telefono','$email','$forma','$origen','$banco','$numero','$monto',now() + interval 2 hour)");
        return $this->db->insert_id();
    }
    function pagos($desde){
        $query=$this->db->query("select * from pago where id>$desde");
        $result=$query->result_array();
        return json_encode($result);
    }
}
