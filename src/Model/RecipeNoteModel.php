<?php

namespace AMAP\Model;

use PDO;
use AMAP\Database\DbConnect;

class RecipeNoteModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new DbConnect)->connect();
    }

    public function getAll()
    {
        $params = [];
        if (isset($_GET['params'])) {
            foreach ($_GET['params'] as $param => $value) {
                $params[$param] = $value;
            }
        }
        $request = "SELECT * FROM NoteRecette";
        $firstLoop = false;
        foreach ($params as $param => $value) {
            if ($firstLoop == true) {
                $request = $request . " AND ";
            } else {
                $request = $request . " WHERE ";
            }
            $request = $request . $param . " = :" . $param;
            $firstLoop = true;
        }
        $stmt = $this->pdo->prepare($request);
        foreach ($params as $param => $value) {
            $stmt->bindParam(":" . $param, $value, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $request = "INSERT INTO NoteRecette (id_recette, id_utilisateur, note) VALUES (:id_recette, :id_utilisateur, :note)";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id_recette', $data->id_recette, PDO::PARAM_INT);
        $stmt->bindParam(':id_utilisateur', $data->id_utilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':note', $data->note, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getUserNoteByIdRecipe($idRecipe, $idUser)
    {
        $request = "SELECT note FROM NoteRecette WHERE id_recette = :id_recette AND id_utilisateur = :id_utilisateur";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id_recette', $idRecipe, PDO::PARAM_INT);
        $stmt->bindParam(':id_utilisateur', $idUser, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
