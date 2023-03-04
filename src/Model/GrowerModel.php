<?php

namespace AMAP\Model;

use PDO;
use DateTime;
use AMAP\Database\DbConnect;

class GrowerModel
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
        $request = "SELECT * FROM Producteur";
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

    public function getById($idGrower)
    {
        $request = "SELECT id, CONCAT(Producteur.nom,' ',Producteur.prenom) AS nom, created_at, avatar, description FROM Producteur WHERE id=:id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam('id', $idGrower, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getGrowerCart($idgrowerCart)
    {
        $request = "SELECT * FROM PanierProducteur WHERE id_producteur=:id ";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(":id", $idgrowerCart, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteGrowerCart($data)
    {
        $id_panier = intval($data->id_panier);
        $request = "DELETE FROM PanierProducteur WHERE id = :id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(":id", $id_panier, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getGrowerReview($idgrowerReview)
    {
        $request = "SELECT CONCAT(Utilisateur.nom, ' ', Utilisateur.prenom) AS nom, note, avis, NoteProducteur.created_at  FROM NoteProducteur INNER JOIN Utilisateur ON NoteProducteur.id_utilisateur = Utilisateur.id WHERE id_producteur = :id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(":id", $idgrowerReview, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $email = $data->email;
        $stmt = $this->pdo->prepare("SELECT * FROM Producteur WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user) {
            return false;
        } else {
            $request = "INSERT INTO Producteur (email, nom, prenom, avatar, region, adresse, codePostal) VALUES (:email,:nom,:prenom,:avatar,:region,:adresse,:codePostal)";
            $stmt = $this->pdo->prepare($request);
            $stmt->bindParam(':email', $data->email, PDO::PARAM_STR);
            $stmt->bindParam(':nom', $data->nom, PDO::PARAM_STR);
            $stmt->bindParam(":prenom", $data->prenom, PDO::PARAM_STR);
            $stmt->bindParam(":avatar", $data->avatar, PDO::PARAM_STR);
            $stmt->bindParam(":region", $data->region, PDO::PARAM_STR);
            $stmt->bindParam(":adresse", $data->adresse, PDO::PARAM_STR);
            $stmt->bindParam(":codePostal", $data->codePostal, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }
    }

    public function insertGrowerReview($data)
    {
        $request = "INSERT INTO NoteProducteur (id_utilisateur, id_producteur, avis, created_at) VALUES (:id_utilisateur, id_producteur, :avis, NOW())";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id_utilisateur', $data->opinion->id_utilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':id_producteur', $data->comment->id_producteur, PDO::PARAM_INT);
        $stmt->bindParam(':avis', $data->comment->avis, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
