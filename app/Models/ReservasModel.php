<?php
namespace App\Models;
use CodeIgniter\Model;
class ReservasModel extends Model{
    protected $table='reservas';
    protected $primaryKey='ID_Reserva';
    protected $returnType='array';
    protected $allowedFields = [
        '
        ', 'ID_Cliente', 'ID_Paquete', 'fechaInicio', 'fechaFin',
        'estado'
    ];


//como es una tabla que tiene llaves forañeas vamos a crear la relacion de modelo//

public function getReservas(){
    return $this->db->table('reservas c')
    ->where('c.estado',1)
    ->join('clientes tc', 'c.ID_Cliente = tc.ID_Cliente')
    ->join('paquetesturisticos cc', 'c.ID_Paquete = cc.ID_Paquete')
    ->get()->getResultArray();
}
public function getId($id){
    return $this->db->table('reservas c')
    ->where('c.ID_Reserva', $id)
    ->where('c.estado', 1)
    ->join('clientes tc', 'c.ID_Cliente = tc.ID_Cliente')
    ->join('paquetesturisticos cc', 'c.ID_Paquete = cc.ID_Paquete')
    ->get()->getResultArray();
}
public function getClientes(){
    return $this->db->table('clientes tc')
    ->where('tc.estado',1)
    ->get()->getResultArray();
}
public function getPaquetes(){
    return $this->db->table('paquetesturisticos cc')
    ->where('cc.estado',1)
    ->get()->getResultArray();
}
}