<?php
namespace App\Models;
use CodeIgniter\Model;
class ProveedoresModel extends Model{
    protected $table='proveedores';
    protected $primaryKey='ID_Proveedor';
    protected $returnType='array';
    protected $allowedFields =[
        'nombres', 'apellidos', 'dni', 'contacto', 'estado'
    ];
}