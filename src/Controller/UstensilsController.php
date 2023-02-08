<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\UstensilsModel;

class UstensilsController
{
    public function get()
    {
        $data = (new UstensilsModel)->getAll();
        $response = ['status' => 200, 'ustensiles' => $data];
        echo json_encode($response);
    }

    public function insert($data)
    {
        if ((new UstensilsModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "L'ustensile a bien été enregistrée"];
        } else {
            $response = ['status' => 400, 'message' => "L'enregistrement de l ustensile a échoué"];
        }
        echo json_encode($response);
    }
}
