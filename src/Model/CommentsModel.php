<?php

namespace AMAP\Model;

use PDO;
use AMAP\Database\DbConnect;

class CommentsModel
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
        $request = "SELECT * FROM Commentaire";
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
        $request = "INSERT INTO Commentaire (id_utilisateur, id_recette, texte, contenu) VALUES (:id_utilisateur,:id_recette,:texte,:contenu)";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id_utilisateur', $data->id_utilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':id_recette', $data->id_recette, PDO::PARAM_INT);
        $stmt->bindParam(":texte" , $data->texte, PDO::PARAM_STR);
        $stmt->bindParam(":contenu" , $data->contenu, PDO::PARAM_STR);
        return $stmt->execute([$data->id_utilisateur, $data->id_recette, $data->texte, $data->contenu]);
    }
}
