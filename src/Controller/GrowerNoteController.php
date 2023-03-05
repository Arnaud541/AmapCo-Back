<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\GrowerNoteModel;

class GrowerNoteController
{
    public function get()
    {
        $data = (new GrowerNoteModel)->getAll();
        $response = ['status' => 200, 'growerNote' => $data];
        echo json_encode($response);
    }

    public function insert($data)
    {
        if ((new GrowerNoteModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "La note a bien été enregistrée"];
        } else {
            $response = ['status' => 400, 'message' => "L'enregistrement de la note a échoué"];
        }
        echo json_encode($response);
    }

    public function updateNote($data)
    {
        if ((new GrowerNoteModel)->updateNote($data)) {
            $response = ['status' => 200, 'message' => "La note a bien été modifiée"];
        } else {
            $response = ['status' => 400, 'message' => "L'enregistrement de la note a échoué"];
        }
        echo json_encode($response);
    }

    public function getUserNoteByIdGrower()
    {
        if (isset($_GET["id_producteur"]) && isset($_GET["id_utilisateur"])) {
            $data = (new GrowerNoteModel)->getUserNoteByIdGrower($_GET["id_producteur"], $_GET["id_utilisateur"]);
            if ($data && !is_null($data)) {
                $response = ['status' => 200, 'note' => $data];
                echo json_encode($response);
            }
        }
    }
}
