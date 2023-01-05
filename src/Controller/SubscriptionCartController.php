<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\SubsciptionCartModel;

class SubsciptionCartController
{
    public function get()
    {
        $data = (new SubsciptionCartModel)->getAll();
        $response = ['status' => 200, 'commentaires' => $data];
        echo json_encode($response);
    }

    public function insert($data)
    {
        if ((new SubsciptionCartModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "Le commentaire a bien été enregistrée"];
        } 
        else {
            $response = ['status' => 400, 'message' => "L'enregistrement de le commentaire a échoué"];
        }
        echo json_encode($response);
    }
}
