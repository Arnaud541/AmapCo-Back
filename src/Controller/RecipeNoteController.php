<?php


namespace AMAP\Controller;

require 'vendor/autoload.php';

use AMAP\Model\RecipeNoteModel;

class RecipeNoteController
{
    public function get()
    {
        $data = (new RecipeNoteModel)->getAll();
        $response = ['status' => 200, 'recipeNote' => $data];
        echo json_encode($response);
    }

    public function insert($data)
    {
        if ((new RecipeNoteModel)->insert($data)) {
            $response = ['status' => 200, 'message' => "La note a bien été enregistrée"];
        } else {
            $response = ['status' => 400, 'message' => "L'enregistrement de la note a échoué"];
        }
        echo json_encode($response);
    }

    public function updateNote($data)
    {
        if ((new RecipeNoteModel)->updateNote($data)) {
            $response = ['status' => 200, 'message' => "La note a bien été modifiée"];
        } else {
            $response = ['status' => 400, 'message' => "L'enregistrement de la note a échoué"];
        }
        echo json_encode($response);
    }

    public function getUserNoteByIdRecipe()
    {
        if (isset($_GET["id_recette"]) && isset($_GET["id_utilisateur"])) {
            $data = (new RecipeNoteModel)->getUserNoteByIdRecipe($_GET["id_recette"], $_GET["id_utilisateur"]);
            if ($data && !is_null($data)) {
                $response = ['status' => 200, 'note' => $data];
                echo json_encode($response);
            }
        }
    }
}
