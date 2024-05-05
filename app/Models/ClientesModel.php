<?php
namespace App\Models;
use CodeIgniter\Model;
class ClientesModel extends Model{
    protected $table='clientes';
    protected $primaryKey='ID_Cliente';
    protected $returnType='array';
    protected $allowedFields =[
        'nombres', 'apellidos', 'dni', 'email', 'telefono', 'estado'
    ];
}