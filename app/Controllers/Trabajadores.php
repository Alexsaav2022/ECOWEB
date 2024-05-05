<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\TrabajadoresModel;
use App\Models\RegistrosModel;

class Trabajadores extends Controller
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
                    $model = new TrabajadoresModel();
                    $trabajador = $model->getTrabajadores();
                    //var_dump($trabajador); die;
                    if (!empty($trabajador)) {
                        $data = array(
                             "Status" => 200,
                            "Total de registros"=>count($trabajador),
                            "Detalles" => $trabajador
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
                    $model = new TrabajadoresModel();
                    $trabajador = $model->getId($id);
                    //var_dump($trabajador); die;
                    if (!empty($trabajador)) {
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $trabajador
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
                        "nombres" => $request->getVar("nombres"),
                        "apellidos" => $request->getVar("apellidos"),
                        "dni" => $request->getVar("dni"),
                        "email" => $request->getVar("email"),
                        "telefono" => $request->getVar("telefono"),
                        "ID_Rol" => $request->getVar("ID_Rol")
                    );
                    if (!empty($datos)) {
                        $validation->setRules([
                            "nombres" => 'required|string|max_length[255]',
                            "apellidos" => 'required|string|max_length[255]',
                            "dni" => 'required|string|max_length[255]',
                            "email" => 'required|string|max_length[255]',
                            "telefono" => 'required|string|max_length[255]',
                            "ID_Rol" => 'required|integer'
                        ]);
                        $validation->withRequest($this->request)->run();
                        if ($validation->getErrors()) {
                            $errors = $validation->getErrors();
                            $data = array("Status" => 404, "Detalle" => $errors);
                            return json_encode($data, true);
                        } else {
                            $datos = array(
                                "nombres" => $datos["nombres"],
                                "apellidos" => $datos["apellidos"],
                                "dni" => $datos["dni"],
                                "email" => $datos["email"],
                                "telefono" => $datos["telefono"],
                                "ID_Rol" => $datos["ID_Rol"]
                            );
                            $model = new TrabajadoresModel();
                            $trabajador = $model->insert($datos);
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
                                "nombres" => 'required|string|max_length[255]',
                                "apellidos" => 'required|string|max_length[255]',
                                "dni" => 'required|string|max_length[255]',
                                "email" => 'required|string|max_length[255]',
                                "telefono" => 'required|string|max_length[255]',
                                "ID_Rol" => 'required|integer'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                              $model = new TrabajadoresModel();
                              $trabajador = $model->find($id);
                                if(is_null(($trabajador))){
                                    
                                    $data = array (
                                        "Status" =>404,
                                        "Detalles"=> " Registro no existe"
                                    );
                                   
                                }else{
                                    $datos = array(
                                        "nombres" => $datos["nombres"],
                                        "apellidos" => $datos["apellidos"],
                                        "dni" => $datos["dni"],
                                        "email" => $datos["email"],
                                        "telefono" => $datos["telefono"],
                                        "ID_Rol" => $datos["ID_Rol"]

                                    );
                                    $model =new TrabajadoresModel();
                                    $trabajador = $model ->update($id,$datos);
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
                    $model = new TrabajadoresModel();
                    $trabajador = $model->find($id);
                    //var_dump($trabajador); die;
                    if (!empty($trabajador)) {
                        $datos = array("estado" => 0);
                        $trabajador = $model->update($id, $datos);
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
