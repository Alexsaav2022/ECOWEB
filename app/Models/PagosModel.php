<?php
namespace App\Models;
use CodeIgniter\Model;
class PagosModel extends Model{
    protected $table='pagos';
    protected $primaryKey='ID_Pago';
    protected $returnType='array';
    protected $allowedFields = [
        'ID_Reserva', 'monto', 'metodoPago', 'fechaPago',
        'estado'
    ];


//como es una tabla que tiene llaves forañeas vamos a crear la relacion de modelo//

public function getPagos(){
    return $this->db->table('pagos c')
    ->where('c.estado',1)
    ->join('reservas tc', 'c.ID_Reserva = tc.ID_Reserva')
    ->get()->getResultArray();
}
public function getId($id){
    return $this->db->table('pagos c')
    ->where('c.ID_Pago', $id)
    ->where('c.estado', 1)
    ->join('reservas tc', 'c.ID_Reserva = tc.ID_Reserva')
    ->get()->getResultArray();
}
public function getReservas(){
    return $this->db->table('reservas tc')
    ->where('tc.estado',1)
    ->get()->getResultArray();
}
}