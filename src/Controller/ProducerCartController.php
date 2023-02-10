<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\ProducerCartModel;

class ProducerCartController
{
    public function get()
    {
        $data = (new ProducerCartModel)->getAll();
        $response = ['status' => 200, 'producerCart' => $data];
        echo json_encode($response);
    }

    public function getBySearch(){
        $carts = (new ProducerCartModel)->getBySearch();
        $response = ['status' => 200, 'producerCart' => $carts];
        echo json_encode($response);
    }

    public function getCart($idProducerCart)
    {
            $data = (new ProducerCartModel)->getCart($idProducerCart);
            $response = ['status' => 200, 'detail' => $data];
            echo json_encode($response);
    }

    public function insert($data)
    {
        if ((new ProducerCartModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "Le panier a bien été enregistrée"];
        } 
        else {
            $response = ['status' => 400, 'message' => "L'enregistrement du panier a échoué"];
        }
        echo json_encode($response);
    }
}
