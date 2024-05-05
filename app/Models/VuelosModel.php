<?php
namespace App\Models;
use CodeIgniter\Model;
class VuelosModel extends Model{
    protected $table='vuelos';
    protected $primaryKey='ID_Vuelo';
    protected $returnType='array';
    protected $allowedFields = [
        'origen', 'destino', 'horarios', 'precios', 'ID_Proveedor',
        'estado'
    ];
//como es una tabla que tiene llaves forañeas vamos a crear la relacion de modelo//

public function getVuelos(){
    return $this->db->table('vuelos c')
    ->where('c.estado',1)
    ->join('proveedores tc', 'c.ID_Proveedor = tc.ID_Proveedor')
    ->get()->getResultArray();
}
public function getId($id){
    return $this->db->table('vuelos c')
    ->where('c.ID_Vuelo', $id)
    ->where('c.estado', 1)
    ->join('proveedores tc', 'c.ID_Proveedor = tc.ID_Proveedor')
    ->get()->getResultArray();
}
public function getProveedores(){
    return $this->db->table('proveedores tc')
    ->where('tc.estado',1)
    ->get()->getResultArray();
}
}