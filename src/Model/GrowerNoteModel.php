<?php

namespace AMAP\Model;

use PDO;
use AMAP\Database\DbConnect;

class GrowerNoteModel
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
        $request = "SELECT * FROM NoteProducteur";
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

    public function getNote()
    {
        $request = "select nom,prenom,id from Utilisateur inner join NoteProducteur on Utilisateur.id = NoteProducteur.id_utilisateur where NoteProducteur.id_producteur = :id_producteur;";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(":id_producteur",$id_producteur,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $request = "INSERT INTO NoteProducteur (id_utilisateur, note, avis) VALUES (:id_utilisateur,:note,:avis)";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id_utilisateur', $data->id_utilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':note', $data->note, PDO::PARAM_STR);
        $stmt->bindParam(":avis" , $data->avis, PDO::PARAM_STR);
        return $stmt->execute([$data->id_utilisateur, $data->note, $data->avis]);
    }
}
