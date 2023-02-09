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

    public function getNote()
    {
        $data = (new GrowerNoteModel)->getNote();
        $response = ['status' => 200, 'growerNote' => $data];
        echo json_encode($response);
    }

    public function insert($data)
    {
        if ((new GrowerNoteModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "La note a bien été enregistrée"];
        } 
        else {
            $response = ['status' => 400, 'message' => "L'enregistrement de la note a échoué"];
        }
        echo json_encode($response);
    }
}
