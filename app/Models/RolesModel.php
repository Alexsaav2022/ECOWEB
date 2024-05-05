<?php
namespace App\Models;
use CodeIgniter\Model;
class RolesModel extends Model{
    protected $table='roles';
    protected $primaryKey='ID_Rol';
    protected $returnType='array';
    protected $allowedFields =[
        'puesto', 'estado'
    ];
}