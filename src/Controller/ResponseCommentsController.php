<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\ResponseCommentsModel;

class ResponseCommentsController
{
    public function get()
    {
        $data = (new ResponseCommentsModel)->getAll();
        $response = ['status' => 200, 'reponse' => $data];
        echo json_encode($response);
    }

    public function insert($data)
    {
        if ((new ResponseCommentsModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "La reponse a bien été enregistrée"];
        } 
        else {
            $response = ['status' => 400, 'message' => "L'enregistrement de la reponse a échoué"];
        }
        echo json_encode($response);
    }
}
