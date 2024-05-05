<?php
namespace App\Models;
use CodeIgniter\Model;
class CursosModel extends Model{
    protected $table='cursos';
    protected $primaryKey='idcurso';
    protected $returnType='array';
    protected $allowedFields = [
        '
        ', 'id_tipo', 'id_categoria', 'id_naturaleza',
        'estado'
    ];


//como es una tabla que tiene llaves forañeas vamos a crear la relacion de modelo//

public function getCursos(){
    return $this->db->table('cursos c')
    ->where('c.estado',1)
    ->join('tipos_curso tc', 'c.id_tipo = tc.idtipocurso')
    ->join('categorias_curso cc', 'c.id_categoria = cc.idcategoriacurso')
    ->join('naturalezas_curso nc','c.id_naturaleza = nc.idnaturalezacurso')
    ->get()->getResultArray();
}
public function getId($id){
    return $this->db->table('cursos c')
    ->where('c.idcurso', $id)
    ->where('c.estado', 1)
    ->join('tipos_curso tc', 'c.id_tipo = tc.idtipocurso')
    ->join('categorias_curso cc', 'c.id_categoria = cc.idcategoriacurso')
    ->join('naturalezas_curso nc','c.id_naturaleza = nc.idnaturalezacurso')
    ->get()->getResultArray();
}
public function getTiposCurso(){
    return $this->db->table('tipo_curso tc')
    ->where('tc.estado',1)
    ->get()->getResultArray();
}
public function getCategoriasCurso(){
    return $this->db->table('categorias_curso cc')
    ->where('tc.estado',1)
    ->get()->getResultArray();
}
public function getCNaturalezasCurso(){
    return $this->db->table('naturalezas_curso nc')
    ->where('tc.estado',1)
    ->get()->getResultArray();
}
}