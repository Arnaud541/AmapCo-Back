<?php

namespace AMAP\Model;

use PDO;
use AMAP\Database\DbConnect;

class ProducerCartModel
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
        $request = "SELECT * FROM PanierProducteur";
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

    public function getCart($idCart)
    {
        $request = "SELECT PanierProducteur.img_url,PanierProducteur.id, Producteur.id AS ProducteurId, PanierProducteur.nom AS PanierProducteurNom ,Producteur.nom AS ProducteurNom,Producteur.prenom,PanierProducteur.description,Ingredient.nom AS IngredientNom, Produit.quantite
        FROM PanierProducteur 
        INNER JOIN Producteur ON PanierProducteur.id_producteur = Producteur.id 
        INNER JOIN Produit ON PanierProducteur.id = Produit.id_panier
        INNER JOIN Ingredient ON Produit.id_ingredient = Ingredient.id 
        WHERE PanierProducteur.id = :id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(":id", $idCart, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBySearch()
    {

        $request = "SELECT PanierProducteur.id, PanierProducteur.nom, PanierProducteur.img_url, PanierProducteur.type, PanierProducteur.id_producteur FROM PanierProducteur";
        $request .= !empty($_GET["search"]["filters"]["ingredient"]) || !empty($_GET["search"]["search"]) ? " INNER JOIN Produit ON PanierProducteur.id = Produit.id_panier
        INNER JOIN Ingredient ON Produit.id_ingredient = Ingredient.id 
        INNER JOIN Producteur ON PanierProducteur.id_producteur = Producteur.id" : null;
        if (!empty($_GET["search"]["filters"])) {

            if (!empty($_GET["search"]["filters"]["ingredient"])) {
                $request .= " WHERE ";

                $filtre_ingredients = [];
                foreach ($_GET["search"]["filters"]["ingredient"] as $value) {
                    $f_ingredient = "Ingredient.nom" . " = " . "'$value'";
                    array_push($filtre_ingredients, $f_ingredient);
                }

                $f_ingredient2 = implode(" OR ", $filtre_ingredients);
                $request .= $f_ingredient2;
                $request .= !empty($_GET["search"]["filters"]["type"]) ? " AND" : null;
            }
            if (!empty($_GET["search"]["filters"]["type"])) {

                $type = $_GET["search"]["filters"]["type"][0];
                $request .= empty($_GET["search"]["filters"]["ingredient"]) ? " WHERE" : null;
                $request .= " PanierProducteur.type" . " = " . "'$type'";
            }
            if (!empty($_GET["search"]["search"])) {
                if (!empty($_GET["search"]["filters"]["type"]) || !empty($_GET["search"]["filters"]["ingredient"])) {
                    $request .= " AND ";
                }
                $request .= "CONCAT(Producteur.nom, Producteur.prenom, PanierProducteur.nom) LIKE '%" . $_GET["search"]["search"] . "%'";
            }
        } else {
            $request .= " WHERE CONCAT(Producteur.nom, Producteur.prenom, PanierProducteur.nom) LIKE '%" . $_GET["search"]["search"] . "%'";
        }
        $stmt = $this->pdo->prepare($request);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function insert($data)
    {
        if (!empty($data->cart->ingredients)) {
            $date_creation = strtotime($data->cart->created_at);
            $date_creation = date('Y-m-d h:i:s', $date_creation);

            $date_fin = strtotime($data->cart->end_at);
            $date_fin = date('Y-m-d h:i:s', $date_fin);

            $request = "INSERT INTO PanierProducteur (id_producteur,nom,description,type,created_at,end_at) VALUES (:id_producteur,:nom,:description,:type,:created_at,:end_at)";
            $stmt = $this->pdo->prepare($request);
            $stmt->bindParam(':id_producteur', $data->cart->id_producteur, PDO::PARAM_INT);
            $stmt->bindParam(":nom", $data->cart->nom, PDO::PARAM_STR);
            $stmt->bindParam(":description", $data->cart->description, PDO::PARAM_STR);
            $stmt->bindParam(":type", $data->cart->type, PDO::PARAM_STR);
            $stmt->bindParam(":created_at", $date_creation, PDO::PARAM_STR);
            $stmt->bindParam(":end_at", $date_fin, PDO::PARAM_STR);
            $stmt->execute();
            $id_panier = $this->pdo->lastInsertId();

            foreach ($data->cart->ingredients as $i) {
                $request2 = "INSERT INTO Produit (id_panier, id_ingredient, quantite) VALUES (:id_panier, :id_ingredient, :quantite)";
                $stmt2 = $this->pdo->prepare($request2);
                $stmt2->bindParam('id_panier', $id_panier, PDO::PARAM_INT);
                $stmt2->bindParam(':id_ingredient', $i->ingredient, PDO::PARAM_INT);
                $stmt2->bindParam(':quantite', $i->quantite, PDO::PARAM_INT);
                $stmt2->execute();
            }

            return true;
        } else {
            return false;
        }
    }
}
