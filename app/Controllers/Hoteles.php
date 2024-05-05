<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\HotelesModel;
use App\Models\RegistrosModel;

class Hoteles extends Controller
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
                    $model = new HotelesModel();
                    $hotel = $model->getHoteles();
                    //var_dump($hotel); die;
                    if (!empty($hotel)) {
                        $data = array(
                            "Status" => 200,
                            "Total de registros"=>count($hotel),
                            "Detalles" => $hotel
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
                    $model = new HotelesModel();
                    $hotel = $model->getId($id);
                    //var_dump($hotel); die;
                    if (!empty($hotel)) {
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $hotel
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
                        "nombre" => $request->getVar("nombre"),
                        "ubicacion" => $request->getVar("ubicacion"),
                        "categoria" => $request->getVar("categoria"),
                        "precios" => $request->getVar("precios"),
                        "ID_Proveedor" => $request->getVar("ID_Proveedor")
                    );
                    if (!empty($datos)) {
                        $validation->setRules([
                            "nombre" => 'required|string|max_length[255]',
                            "ubicacion" => 'required|string|max_length[255]',
                            "categoria" => 'required|string|max_length[255]',
                            "precios" => 'required|string|max_length[255]',
                            "ID_Proveedor" => 'required|integer'
                        ]);
                        $validation->withRequest($this->request)->run();
                        if ($validation->getErrors()) {
                            $errors = $validation->getErrors();
                            $data = array("Status" => 404, "Detalle" => $errors);
                            return json_encode($data, true);
                        } else {
                            $datos = array(
                                "nombre" => $datos["nombre"],
                                "ubicacion" => $datos["ubicacion"],
                                "categoria" => $datos["categoria"],
                                "precios" => $datos["precios"],
                                "ID_Proveedor" => $datos["ID_Proveedor"]
                            );
                            $model = new HotelesModel();
                            $hotel = $model->insert($datos);
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
                                "nombre" => 'required|string|max_length[255]',
                                "ubicacion" => 'required|string|max_length[255]',
                                "categoria" => 'required|string|max_length[255]',
                                "precios" => 'required|string|max_length[255]',
                                "ID_Proveedor" => 'required|integer'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                              $model = new HotelesModel();
                              $hotel = $model->find($id);
                                if(is_null(($hotel))){
                                    
                                    $data = array (
                                        "Status" =>404,
                                        "Detalles"=> " Registro no existe"
                                    );
                                   
                                }else{
                                    $datos = array(
                                        "nombre" => $datos["nombre"],
                                        "ubicacion" => $datos["ubicacion"],
                                        "categoria" => $datos["categoria"],
                                        "precios" => $datos["precios"],
                                        "ID_Proveedor" => $datos["ID_Proveedor"]

                                    );
                                    $model =new HotelesModel();
                                    $hotel = $model ->update($id,$datos);
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
                    $model = new HotelesModel();
                    $hotel = $model->find($id);
                    //var_dump($hotel); die;
                    if (!empty($hotel)) {
                        $datos = array("estado" => 0);
                        $curso = $model->update($id, $datos);
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
