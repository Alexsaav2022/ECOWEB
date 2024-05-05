<?php
namespace App\Models;
use CodeIgniter\Model;
class HotelesModel extends Model{
    protected $table='hoteles';
    protected $primaryKey='ID_Hotel';
    protected $returnType='array';
    protected $allowedFields = [
        'nombre', 'ubicacion', 'categoria', 'precios', 'ID_Proveedor',
        'estado'
    ];


//como es una tabla que tiene llaves forañeas vamos a crear la relacion de modelo//

public function getHoteles(){
    return $this->db->table('hoteles c')
    ->where('c.estado',1)
    ->join('proveedores tc', 'c.ID_Proveedor = tc.ID_Proveedor')
    ->get()->getResultArray();
}
public function getId($id){
    return $this->db->table('hoteles c')
    ->where('c.ID_Hotel', $id)
    ->where('c.estado', 1)
    ->join('proveedores tc', 'c.ID_Proveedor = tc.ID_Proveedor')
    ->get()->getResultArray();
}
public function getClientes(){
    return $this->db->table('proveedores tc')
    ->where('tc.estado',1)
    ->get()->getResultArray();
}
}