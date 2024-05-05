<?php
namespace App\Models;
use CodeIgniter\Model;
class UsuariosModel extends Model{
    protected $table='usuarios';
    protected $primaryKey='ID_Usuario';
    protected $returnType='array';
    protected $allowedFields = [
        'nombreUsuario', 'email', 'contrasena','ID_Rol',
        'estado'
    ];
//como es una tabla que tiene llaves forañeas vamos a crear la relacion de modelo//

public function getUsuarios(){
    return $this->db->table('usuarios c')
    ->where('c.estado',1)
    ->join('roles tc', 'c.ID_Rol = tc.ID_Rol')
    ->get()->getResultArray();
}
public function getLogin($usu){
    $usuario = explode('&', $usu);
    if(count($usuario) == 2){
        $usuarios = $usuario[0];
        $password = $usuario[1];
        //$sucursal = $usuario[2];
        return $this -> db -> table('usuarios c')
        ->where('c.email', $usuarios)
        ->where('c.contrasena', $password)
        ->where('c.estado', 1)
        ->join('roles tc', 'c.ID_Rol = tc.ID_Rol')
        ->get()->getResultArray();
    }else{
        return 'El usuario no es valido';
    }
}


public function getId($id){
    return $this->db->table('usuarios c')
    ->where('c.ID_Usuario', $id)
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