<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsuariosModel;
use App\Models\RegistrosModel;

class Usuarios extends Controller
{
    public function index()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
        //var_dump($registro); die;
        foreach ($registro as $key => $value) {
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                //var_dump($registro); die;
                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value['cliente_id'] . ':' . $value['llave_secreta'])) {
                    $model = new UsuariosModel();
                    $usuario = $model->getUsuarios();
                    //var_dump($usuario); die;
                    if (!empty($usuario)) {
                        $data = array(
                            "Status" => 200,
                            "Total de registros"=>count($usuario),
                            "Detalles" => $usuario
                        );
                    } else {
                        $data = array(
                            "Status" => 200,
                            "Total de registros"=>0,
                            "Detalles" => "No hay registro -_-"
                        );
                    }
                    return json_encode($data, true);
                } else {
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto o tu cwdigo está mal -_-"
                    );
                }
            } else {
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    public function show($id)
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
        //var_dump($registro); die;
        foreach ($registro as $key => $value) {
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                //var_dump($registro); die;
                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value['cliente_id'] . ':' . $value['llave_secreta'])) {
                    $model = new UsuariosModel();
                    if(is_numeric($id)){
                        $usuario = $model -> getId($id);
                    }else if(is_string($id)){
                        $usuario = $model -> getLogin($id);
                    }
                    //var_dump($usuario); die;
                    if (!empty($usuario)) {
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $usuario
                        );
                    } else {
                        $data = array(
                            "Status" => 404,
                            "Detalles" => "No hay registro o tu c0digo está mal -_-"
                        );
                    }
                    return json_encode($data, true);
                } else {
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto o tu cwdigo está mal -_-"
                    );
                }
            } else {
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    public function create()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
        // var_dump($registro); die; 
        foreach ($registro as $key => $value) {
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value['cliente_id'] . ':' . $value['llave_secreta'])) {
                    $datos = array(
                        "nombreUsuario" => $request->getVar("nombreUsuario"),
                        "email" => $request->getVar("email"),
                        "contrasena" => $request->getVar("contrasena"),
                        "ID_Rol" => $request->getVar("ID_Rol")

                    );
                    if (!empty($datos)) {
                        $validation->setRules([
                            "nombreUsuario" => 'required|string|max_length[255]',
                            "email"=>'required|valid_email',
                            "contrasena" => 'required|string|max_length[255]',
                            "ID_Rol" => 'required|integer'
                        ]);
                        $validation->withRequest($this->request)->run();
                        if ($validation->getErrors()) {
                            $errors = $validation->getErrors();
                            $data = array("Status" => 404, "Detalle" => $errors);
                            return json_encode($data, true);
                        } else {
                            $datos = array(
                                "nombreUsuario" => $datos["nombreUsuario"],
                                "email" => $datos["email"],
                                "contrasena" => $datos["contrasena"],
                                "ID_Rol" => $datos["ID_Rol"]
                            );
                            $model = new UsuariosModel();
                            $usuario = $model->insert($datos);
                            $data = array(
                                "Status" => 200,
                                "Detalle" => "Registro existoso"
                            );
                            return json_encode($data, true);
                        }
                    } else {
                        $data = array(
                            "Status" => 404,
                            "Detalle" => "Registro con errores"
                        );
                        return json_encode($data, true);
                    }
                } else {
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            } else {
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    public function update($id)
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();

        // var_dump($registro); die; 

        foreach($registro as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['cliente_id'].':'.$value['llave_secreta'])){
                        $datos =$this->request->getRawInput();// jala todo el bloque de datos  y lo valida
                        if(!empty($datos)){
                            $validation->setRules([
                            "nombreUsuario" => 'required|string|max_length[255]',
                            "email"=>'required|valid_email',
                            "contrasena" => 'required|string|max_length[255]',
                            "ID_Rol" => 'required|integer'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                              $model = new UsuariosModel();
                              $usuario = $model->find($id);
                                if(is_null(($usuario))){
                                    
                                    $data = array (
                                        "Status" =>404,
                                        "Detalles"=> " Registro no existe"
                                    );
                                   
                                }else{
                                    $datos = array(
                                        "nombreUsuario" => $datos["nombreUsuario"],
                                        "email" => $datos["email"],
                                        "contrasena" => $datos["contrasena"],
                                        "ID_Rol" => $datos["ID_Rol"]

                                    );
                                    $model =new UsuariosModel();
                                    $usuario = $model ->update($id,$datos);
                                    $data=array(
                                        "Status"=>200,
                                        "Detalle"=> "Datos Actualizados"
                                    );
                                    return json_encode($data,true);

                                }  

                            }
                        }
                        else{
                            $data = array(
                                "Status"=>404,
                                "Detalle"=>"Registro con errores"
                            );
                            return json_encode($data, true);
                        }
                }
                else{
                    $data = array(
                        "Status"=>404,
                        "Detalles"=>"El token es incorrecto"
                    );
                }
            }
            else{
                $data = array(
                    "Status"=>404,
                    "Detalles"=>"No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }

    public function delete($id)
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
        //var_dump($registro); die;
        foreach ($registro as $key => $value) {
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
                //var_dump($registro); die;
                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value['cliente_id'] . ':' . $value['llave_secreta'])) {
                    $model = new UsuariosModel();
                    $usuario = $model->find($id);
                    //var_dump($usuario); die;
                    if (!empty($usuario)) {
                        $datos = array("estado" => 0);
                        $usuario = $model->update($id, $datos);
                        $data = array(
                            "Status" => 200,
                            "Detalles" => "Se ha eliminado el registro" 
                        );
                        return json_encode($data, true);
                    } 
                    else {
                        $data = array(
                            "Status" => 404,
                            "Detalles" => "No hay registro -_-"
                        );
                    }
                    return json_encode($data, true);
                } else {
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto o tu cwdigo está mal -_-"
                    );
                }
            } else {
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
}
}
