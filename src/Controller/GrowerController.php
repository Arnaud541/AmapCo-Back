<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\GrowerModel;

class GrowerController
{
    public function get()
    {
        $data = (new GrowerModel)->getAll();
        $response = ['status' => 200, 'producteurs' => $data];
        echo json_encode($response);
    }

    public function getById()
    {
        if (isset($_GET["id"])) {
            $data = (new GrowerModel)->getById($_GET['id']);
            $response = ['status' => 200, 'producteur' => $data];
            echo json_encode($response);
        }
    }

    public function getGrowerCart()
    {
        if (isset($_GET["id"])) {
            $data = (new GrowerModel)->getGrowerCart($_GET['id']);
            $response = ['status' => 200, 'carts' => $data];
            echo json_encode($response);
        }
    }

    public function getGrowerReview()
    {
        if (isset($_GET["id"])) {
            $data = (new GrowerModel)->getGrowerReview($_GET['id']);
            $response = ['status' => 200, 'review' => $data];
            echo json_encode($response);
        }
    }

    public function getByIdProducerCart($id_producteur)
    {
        $data = (new GrowerModel)->getByIdProducerCart($id_producteur);
        $response = ['status' => 200, 'growerInfos' => $data];
        echo json_encode($response);
    }

    public function insert($data)
    {
        if ((new GrowerModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "Le producteur a bien été enregistrée"];
        } else {
            $response = ['status' => 400, 'message' => "L'enregistrement du producteur a échoué"];
        }
        echo json_encode($response);
    }
    // public function login()
    // {
    //     if ((new GrowerModel)->login()) {
    //         $response = ['status' => 200, 'message' => "Connexion réussie"];
    //     } 
    //     else {
    //         $response = ['status' => 400, 'message' => "Connexion échouée"];
    //     }
    //     echo json_encode($response);
    // }
}
