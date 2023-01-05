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
        $params = [];
        if (isset($_GET['params'])) {
            foreach ($_GET['params'] as $param => $value) {
                $params[$param] = $value;
            }
        }
        $request = "SELECT * FROM Recette";
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
        $request = "INSERT INTO Recette (id_utilisateur ,titre,description,photo,dureeRealisation,saison,difficulte,typePlat,regimeAlimentaire) VALUES (:id_utilisateur ,:titre,:description,:photo,:dureeRealisation,:saison,:difficulte,:typePlat,:regimeAlimentaire)";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id_utilisateur ', $data->id_utilisateur , PDO::PARAM_INT);
        $stmt->bindParam(':titre', $data->titre, PDO::PARAM_STR);
        $stmt->bindParam(":description" , $data->description, PDO::PARAM_STR);
        $stmt->bindParam(":photo" , $data->photo, PDO::PARAM_STR);
        $stmt->bindParam(":dureeRealisation" , $data->dureeRealisation, PDO::PARAM_INT);
        $stmt->bindParam(":saison" , $data->saison, PDO::PARAM_STR);
        $stmt->bindParam(":difficulte" , $data->difficulte, PDO::PARAM_STR);
        $stmt->bindParam(":typePlat" , $data->typePlat, PDO::PARAM_STR);
        $stmt->bindParam(":regimeAlimentaire" , $data->regimeAlimentaire, PDO::PARAM_STR);
        return $stmt->execute([$data->id_utilisateur , $data->titre, $data->description,$data->photo,$data->dureeRealisation,$data->saison,$data->difficulte,$data->typePlat,$data->regimeAlimentaire]);
    }
}
