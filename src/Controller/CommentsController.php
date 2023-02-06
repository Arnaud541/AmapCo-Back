<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\CommentsModel;

class CommentsController
{
    public function get()
    {
        if (isset($_GET["id"])) {
            $data = (new CommentsModel)->getAll($_GET["id"]);
            $response = ['status' => 200, 'commentaires' => $data];
            echo json_encode($response);
        }
    }

    public function insert($data)
    {
        if ((new CommentsModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "Le commentaire a bien été enregistrée"];
        } else {
            $response = ['status' => 400, 'message' => "L'enregistrement de le commentaire a échoué"];
        }
        echo json_encode($response);
    }
}
