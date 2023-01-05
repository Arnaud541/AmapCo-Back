<?php

namespace AMAP\Model;

use PDO;
use AMAP\Database\DbConnect;

class StepsModel
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
        $request = "SELECT * FROM Etape";
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
        $request = "INSERT INTO Etape (id_recette, numero, contenu) VALUES (:id_recette, :numero, :contenu)";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id_recette', $data->id_recette, PDO::PARAM_STR);
        $stmt->bindParam(':numero', $data->numero, PDO::PARAM_INT);
        $stmt->bindParam(":contenu" , $data->contenu, PDO::PARAM_STR);
        return $stmt->execute([$data->id_recette, $data->numero, $data->contenu]);
    }
}
