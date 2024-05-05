<?php
namespace App\Models;
use CodeIgniter\Model;
class CalificacionesModel extends Model{
    protected $table='calificaciones';
    protected $primaryKey='ID_Calificacion';
    protected $returnType='array';
    protected $allowedFields = [
        '
        ', 'ID_Usuario', 'ID_Paquete', 'puntuacion','fecha',
        'estado'
    ];


//como es una tabla que tiene llaves forañeas vamos a crear la relacion de modelo//

public function getCalificaciones(){
    return $this->db->table('calificaciones c')
    ->where('c.estado',1)
    ->join('usuarios tc', 'c.ID_Usuario = tc.ID_Usuario')
    ->join('paquetesturisticos cc', 'c.ID_Paquete = cc.ID_Paquete')
    ->get()->getResultArray();
}
public function getId($id){
    return $this->db->table('calificaciones c')
    ->where('c.ID_Calificacion', $id)
    ->where('c.estado', 1)
    ->join('usuarios tc', 'c.ID_Usuario = tc.ID_Usuario')
    ->join('paquetesturisticos cc', 'c.ID_Paquete = cc.ID_Paquete')
    ->get()->getResultArray();
}
public function getUsuarios(){
    return $this->db->table('usuarios tc')
    ->where('tc.estado',1)
    ->get()->getResultArray();
}
public function getPaquetes(){
    return $this->db->table('paquetesturisticos cc')
    ->where('tc.estado',1)
    ->get()->getResultArray();
}
}