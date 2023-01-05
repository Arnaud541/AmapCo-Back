<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\GrowerModel;

class GrowerController
{
    public function get()
    {
        $data = (new GrowerModel)->getAll();
        $response = ['status' => 200, 'producteur' => $data];
        echo json_encode($response);
    }

    public function insert($data)
    {
        if ((new GrowerModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "Le producteur a bien été enregistrée"];
        } 
        else {
            $response = ['status' => 400, 'message' => "L'enregistrement du producteur a échoué"];
        }
        echo json_encode($response);
    }
}
