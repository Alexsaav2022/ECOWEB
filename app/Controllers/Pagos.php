<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PagosModel;
use App\Models\RegistrosModel;

class Pagos extends Controller
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
                    $model = new PagosModel();
                    $pago = $model->getPagos();
                    //var_dump($pago); die;
                    if (!empty($pago)) {
                        $data = array(
                             "Status" => 200,
                            "Total de registros"=>count($pago),
                            "Detalles" => $pago
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
                    $model = new PagosModel();
                    $pago = $model->getId($id);
                    //var_dump($pago); die;
                    if (!empty($pago)) {
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $pago
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
                        "ID_Reserva" => $request->getVar("ID_Reserva"),
                        "monto" => $request->getVar("monto"),
                        "metodoPago" => $request->getVar("metodoPago"),
                        "fechaPago" => $request->getVar("fechaPago")
                    );
                    if (!empty($datos)) {
                        $validation->setRules([
                            "ID_Reserva" => 'required|integer',
                            "monto" => 'required|string|max_length[255]',
                            "metodoPago" => 'required|string|max_length[255]',
                            "fechaPago" => 'required|string|max_length[255]'
                        ]);
                        $validation->withRequest($this->request)->run();
                        if ($validation->getErrors()) {
                            $errors = $validation->getErrors();
                            $data = array("Status" => 404, "Detalle" => $errors);
                            return json_encode($data, true);
                        } else {
                            $datos = array(
                                "ID_Reserva" => $datos["ID_Reserva"],
                                "monto" => $datos["monto"],
                                "metodoPago" => $datos["metodoPago"],
                                "fechaPago" => $datos["fechaPago"]
                            );
                            $model = new PagosModel();
                            $pago = $model->insert($datos);
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
                                "ID_Reserva" => 'required|integer',
                                "monto" => 'required|string|max_length[255]',
                                "metodoPago" => 'required|string|max_length[255]',
                                "fechaPago" => 'required|string|max_length[255]'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                              $model = new PagosModel();
                              $pago = $model->find($id);
                                if(is_null(($pago))){
                                    
                                    $data = array (
                                        "Status" =>404,
                                        "Detalles"=> " Registro no existe"
                                    );
                                   
                                }else{
                                    $datos = array(
                                        "ID_Reserva" => $datos["ID_Reserva"],
                                        "monto" => $datos["monto"],
                                        "metodoPago" => $datos["metodoPago"],
                                        "fechaPago" => $datos["fechaPago"]

                                    );
                                    $model =new PagosModel();
                                    $pago = $model ->update($id,$datos);
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
                    $model = new PagosModel();
                    $pago = $model->find($id);
                    //var_dump($pago); die;
                    if (!empty($pago)) {
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
