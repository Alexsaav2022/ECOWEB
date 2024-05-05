<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CalificacionesModel;
use App\Models\RegistrosModel;

class Calificaciones extends Controller
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
                    $model = new CalificacionesModel();
                    $calificacion = $model->getCalificaciones();
                    //var_dump($calificacion); die;
                    if (!empty($calificacion)) {
                        $data = array(
                            "Status" => 200,
                            "Total de registros"=>count($calificacion),
                            "Detalles" => $calificacion
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
                    $model = new CalificacionesModel();
                    $calificacion = $model->getId($id);
                    //var_dump($calificacion); die;
                    if (!empty($calificacion)) {
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $calificacion
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
                        "ID_Usuario" => $request->getVar("ID_Usuario"),
                        "ID_Paquete" => $request->getVar("ID_Paquete"),
                        "puntuacion" => $request->getVar("puntuacion"),
                        "fecha" => $request->getVar("fecha")
                    );
                    if (!empty($datos)) {
                        $validation->setRules([
                            "ID_Usuario" => 'required|integer',
                            "ID_Paquete" => 'required|integer',
                            "puntuacion" => 'required|string|max_length[255]',
                            "fecha" => 'required|string|max_length[255]'
                        ]);
                        $validation->withRequest($this->request)->run();
                        if ($validation->getErrors()) {
                            $errors = $validation->getErrors();
                            $data = array("Status" => 404, "Detalle" => $errors);
                            return json_encode($data, true);
                        } else {
                            $datos = array(
                                "ID_Usuario" => $datos["ID_Usuario"],
                                "ID_Paquete" => $datos["ID_Paquete"],
                                "puntuacion" => $datos["puntuacion"],
                                "fecha" => $datos["fecha"]
                            );
                            $model = new CalificacionesModel();
                            $calificacion = $model->insert($datos);
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
                                "ID_Usuario" => 'required|integer',
                                "ID_Paquete" => 'required|integer',
                                "puntuacion" => 'required|string|max_length[255]',
                                "fecha" => 'required|string|max_length[255]'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                              $model = new CalificacionesModel();
                              $calificacion = $model->find($id);
                                if(is_null(($calificacion))){
                                    
                                    $data = array (
                                        "Status" =>404,
                                        "Detalles"=> " Registro no existe"
                                    );
                                   
                                }else{
                                    $datos = array(
                                        "ID_Usuario" => $datos["ID_Usuario"],
                                        "ID_Paquete" => $datos["ID_Paquete"],
                                        "puntuacion" => $datos["puntuacion"],
                                        "fecha" => $datos["fecha"]

                                    );
                                    $model =new CalificacionesModel();
                                    $calificacion = $model ->update($id,$datos);
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
                    $model = new CalificacionesModel();
                    $calificacion = $model->find($id);
                    //var_dump($calificacion); die;
                    if (!empty($calificacion)) {
                        $datos = array("estado" => 0);
                        $calificacion = $model->update($id, $datos);
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
