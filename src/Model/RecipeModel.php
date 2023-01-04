<?php

namespace AMAP\Model;

use PDO;
use AMAP\Database\DbConnect;

class RecipeModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new DbConnect)->connect();
    }

    public function getAll()
    {
        $request = "SELECT * FROM Recette";
        $stmt = $this->pdo->query($request);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertRecipe($data)
    {
        $request = "INSERT INTO Recette (titre, description, photo) VALUES (?,?,?)";
        $stmt = $this->pdo->prepare($request);
        return $stmt->execute([$data->titre, $data->description, $data->photo]);
    }
}
