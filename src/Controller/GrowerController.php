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

    public function deleteGrowerCart($data)
    {

        $success = (new GrowerModel)->deleteGrowerCart($data);
        if ($success) {
            $response = ['status' => 200, 'success' => $success, 'message' => 'La suppression à bien été effectuée'];
        } else {
            $response = ['status' => 400, 'success' => $success, 'message' => 'La suppression à échoué'];
        }
        echo json_encode($response);
    }

    public function getGrowerReview($idgrowerReview)
    {
        $data = (new GrowerModel)->getGrowerReview($idgrowerReview);
        $response = ['status' => 200, 'reviews' => $data];
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

    public function insertGrowerReview($data)
    {
        if ((new GrowerModel)->insertGrowerReview($data)) {
            $response = ['status' => 200, 'message' => "Votre avis a été ajouté"];
        } else {
            $response = ['status' => 400, 'message' => "L'enregistrement de l'avis a échoué"];
        }
        echo json_encode($response);
    }

    public function getGrowerNote()
    {
        if (isset($_GET["id"])) {
            $data = (new GrowerModel)->getGrowerNote($_GET["id"]);
            $response = ['status' => 200, 'note' => $data];
            echo json_encode($response);
        }
    }
}
