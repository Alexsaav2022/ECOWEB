<?php
namespace App\Models;
use CodeIgniter\Model;
class ComentariosModel extends Model{
    protected $table='comentarios';
    protected $primaryKey='ID_Comentario';
    protected $returnType='array';
    protected $allowedFields = [
        '
        ', 'ID_Usuario', 'ID_Paquete', 'contenido','fecha',
        'estado'
    ];


//como es una tabla que tiene llaves forañeas vamos a crear la relacion de modelo//

public function getComentarios(){
    return $this->db->table('comentarios c')
    ->where('c.estado',1)
    ->join('usuarios tc', 'c.ID_Usuario = tc.ID_Usuario')
    ->join('paquetesturisticos cc', 'c.ID_Paquete = cc.ID_Paquete')
    ->get()->getResultArray();
}
public function getId($id){
    return $this->db->table('comentarios c')
    ->where('c.ID_Comentario', $id)
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