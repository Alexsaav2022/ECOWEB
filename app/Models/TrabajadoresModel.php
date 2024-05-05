<?php
namespace App\Models;
use CodeIgniter\Model;
class TrabajadoresModel extends Model{
    protected $table='trabajadores';
    protected $primaryKey='ID_Trabajador';
    protected $returnType='array';
    protected $allowedFields = [
        'nombres','apellidos', 'dni', 'email', 'telefono','ID_Rol',
        'estado'
    ];
//como es una tabla que tiene llaves forañeas vamos a crear la relacion de modelo//

public function getTrabajadores(){
    return $this->db->table('trabajadores c')
    ->where('c.estado',1)
    ->join('roles tc', 'c.ID_Rol = tc.ID_Rol')
    ->get()->getResultArray();
}
public function getId($id){
    return $this->db->table('trabajadores c')
    ->where('c.ID_Trabajador', $id)
    ->where('c.estado', 1)
    ->join('roles tc', 'c.ID_Rol = tc.ID_Rol')
    ->get()->getResultArray();
}
public function getRoles(){
    return $this->db->table('roles tc')
    ->where('tc.estado',1)
    ->get()->getResultArray();
}
}