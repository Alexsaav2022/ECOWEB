<?php
namespace App\Models;
use CodeIgniter\Model;
class CategoriasModel extends Model{
    protected $table='categorias';
    protected $primaryKey='ID_Categoria';
    protected $returnType='array';
    protected $allowedFields =[
        'nombre', 'estado'
    ];
}