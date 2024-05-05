<?php
// los controladores se escriben la primera letra en Mayuscula
namespace App\Controllers;
use CodeIgniter\Controller;
class Saludo extends Controller // la clase del controlador debe ser escrita igual  y el extends es al controller
{
    public function index()
    {
        echo "Holis";
    }
    public function comentarios(){
        $comentarios =" QUiero decirte que te amo";
    echo json_encode($comentarios);// se busca que la variable se devuelva en formato Json
    // el metodo json_code permite transformar las variables en el formato JSON, ideal para web services con RESTFUL
    }
    public function mensajes($id){
        if(!is_numeric($id)){
            $respuesta = array(
                'error'=>true,
                'mensaje'=>'Debe ser numerico'
            );
            echo json_encode($respuesta);
            return;
        }
        $mensajes=array(

            array('id'=>1,'mensaje'=>"Frank el Mejor"),
            array('id'=>2,'mensaje'=>"ella"),
            array('id'=>3,'mensaje'=>"era mi bb... pero tambien mi perra :v")
        );
        if($id>=count($mensajes)OR $id<0){
            $respuesta=array(
                'error'=>true,
                'mensaje'=>'El id no existe'
            );
            echo json_encode($respuesta);
            return;

        }

        echo json_encode($mensajes[$id]);
    }
 

}
