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

    public function getNote($id_producteur)
    {
        $request = "select nom,prenom,id from Utilisateur inner join NoteProducteur on Utilisateur.id = NoteProducteur.id_utilisateur where NoteProducteur.id_producteur = :id_producteur;";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(":id_producteur", $id_producteur, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserNoteByIdGrower($idGrower, $idUser)
    {
        var_dump($idUser);
        $request = "SELECT note FROM NoteProducteur WHERE id_producteur = :id_producteur AND id_utilisateur = :id_utilisateur";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id_producteur', $idGrower, PDO::PARAM_INT);
        $stmt->bindParam(':id_utilisateur', $idUser, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $request = "INSERT INTO NoteProducteur (id_utilisateur, id_producteur, note) VALUES (:id_utilisateur,:id_producteur,:note)";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id_utilisateur', $data->id_utilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':id_producteur', $data->id_producteur, PDO::PARAM_INT);
        $stmt->bindParam(":note", $data->note, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateNote($data)
    {
        $request = "UPDATE NoteProducteur SET note = :note WHERE id_utilisateur = :id_utilisateur AND id_producteur = :id_producteur";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id_utilisateur', $data->id_utilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':id_producteur', $data->id_producteur, PDO::PARAM_INT);
        $stmt->bindParam(":note", $data->note, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
