<?php
namespace App\Models;
use CodeIgniter\Model;
class PaquetesModel extends Model{
    protected $table='paquetesturisticos';
    protected $primaryKey='ID_Paquete';
    protected $returnType='array';
    protected $allowedFields = [
        'nombre', 'descripcion', 'destino','duracion','precio','ID_Categoria',
        'estado'
    ];
//como es una tabla que tiene llaves forañeas vamos a crear la relacion de modelo//

public function getPaquetes(){
    return $this->db->table('paquetesturisticos c')
    ->where('c.estado',1)
    ->join('categorias tc', 'c.ID_Categoria = tc.ID_Categoria')
    ->get()->getResultArray();
}
public function getId($id){
    return $this->db->table('paquetesturisticos c')
    ->where('c.ID_Paquete', $id)
    ->where('c.estado', 1)
    ->join('categorias tc', 'c.ID_Categoria = tc.ID_Categoria')
    ->get()->getResultArray();
}
public function getCategorias(){
    return $this->db->table('categorias tc')
    ->where('tc.estado',1)
    ->get()->getResultArray();
}
}