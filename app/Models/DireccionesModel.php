<?php
namespace App\Models;
use CodeIgniter\Model;
class DireccionesModel extends Model{
    protected $table='direcciones';
    protected $primaryKey='ID_Direccion';
    protected $returnType='array';
    protected $allowedFields = [
        'ID_Cliente', 'calle', 'ciudad', 'pais',
        'estado'
    ];


//como es una tabla que tiene llaves forañeas vamos a crear la relacion de modelo//

public function getDirecciones(){
    return $this->db->table('direcciones c')
    ->where('c.estado',1)
    ->join('clientes tc', 'c.ID_Cliente = tc.ID_Cliente')
    ->get()->getResultArray();
}
public function getId($id){
    return $this->db->table('direcciones c')
    ->where('c.ID_Direccion', $id)
    ->where('c.estado', 1)
    ->join('clientes tc', 'c.ID_Cliente = tc.ID_Cliente')
    ->get()->getResultArray();
}
public function getClientes(){
    return $this->db->table('clientes tc')
    ->where('tc.estado',1)
    ->get()->getResultArray();
}
}