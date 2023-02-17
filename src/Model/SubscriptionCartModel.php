<?php

namespace AMAP\Model;

use PDO;
use AMAP\Database\DbConnect;

class SubscriptionCartModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new DbConnect)->connect();
    }

    public function getSubVerification($id_panier, $id_utilisateur)
    {
        $request = "SELECT COUNT(*) AS subVerification FROM AbonnementPanier WHERE id_panier = :id_panier AND id_utilisateur = :id_utilisateur";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id_panier', $id_panier, PDO::PARAM_INT);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $stmt->execute();
        $bool = $stmt->fetch(PDO::FETCH_ASSOC);
        return $bool["subVerification"] === 1 ? true : false;
    }

    public function insert($data)
    {
        $date = date('Y-m-d H:i:s');
        $id_panier = intval($data->id_panier);
        $request = "INSERT INTO AbonnementPanier (id_panier, id_utilisateur, date_debut) VALUES (:id_panier, :id_utilisateur, :date_debut)";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id_panier', $id_panier, PDO::PARAM_INT);
        $stmt->bindParam(':id_utilisateur', $data->id_utilisateur, PDO::PARAM_INT);
        $stmt->bindParam(":date_debut", $date, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function subscribedCart($id)
    {
        $request = "SELECT PanierProducteur.id_producteur, PanierProducteur.nom, PanierProducteur.img_url, CONCAT(Producteur.nom, ' ', Producteur.prenom)
        AS Nom
        FROM PanierProducteur
        INNER JOIN Producteur ON PanierProducteur.id_producteur = Producteur.id
        INNER JOIN AbonnementPanier ON PanierProducteur.id = AbonnementPanier.id_panier
        INNER JOIN Utilisateur ON AbonnementPanier.id_utilisateur = Utilisateur.id
        WHERE Utilisateur.id = :utilisateur";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':utilisateur', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
