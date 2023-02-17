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

        $request = "SELECT PanierProducteur.id, PanierProducteur.nom, PanierProducteur.img_url, PanierProducteur.type FROM PanierProducteur
        INNER JOIN Produit ON PanierProducteur.id = Produit.id_panier
        INNER JOIN Ingredient ON Produit.id_ingredient = Ingredient.id 
        INNER JOIN Producteur ON PanierProducteur.id_producteur = Producteur.id";

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
                $request .= !empty($_GET["search"]["filters"]["type"]) ? "AND" : null;
            }
            if (!empty($_GET["search"]["filters"]["type"])) {
                $type = $_GET["search"]["filters"]["type"][0];
                $request .= " WHERE ";
                $f_type = "PanierProducteur.type" . " = " . "'$type'";
                $request .= $f_type;
                $request .= !empty($_GET["search"]["filters"]["ingredient"]) ? "AND" : null;
            }
            if (!empty($_GET["search"]["search"])) {
                $request .= " WHERE CONCAT(Producteur.nom, Producteur.prenom, PanierProducteur.nom) LIKE '%" . $_GET["search"]["search"] . "%'";
            }
        } else {
            $request .= " WHERE CONCAT(Producteur.nom, Producteur.prenom, PanierProducteur.nom) LIKE '%" . $_GET["search"]["search"] . "%'";
        }
        $stmt = $this->pdo->prepare($request);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCartBySearch($ingredient)
    {
        $request = "SELECT Produit.id_panier,PanierProducteur.nom,PanierProducteur.img_url FROM PanierProducteur INNER JOIN Produit ON PanierProducteur.id = Produit.id_panier INNER JOIN Ingredient ON Produit.id_ingredient = Ingredient.id WHERE Ingredient.nom LIKE :ingredient ;";
        $ingredient = "$ingredient%";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':ingredient', $ingredient, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $request = "INSERT INTO PanierProducteur (id_produit,id_producteur,nom,img_url,prix,type) VALUES (:id_produit,:id_producteur,:nom,:img_url,:prix,:type)";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id_produit', $data->id_produit, PDO::PARAM_INT);
        $stmt->bindParam(':id_producteur', $data->id_producteur, PDO::PARAM_INT);
        $stmt->bindParam(":nom", $data->nom, PDO::PARAM_STR);
        $stmt->bindParam(":img_url", $data->img_url, PDO::PARAM_STR);
        $stmt->bindParam(":prix", $data->prix, PDO::PARAM_STR);
        $stmt->bindParam(":type", $data->type, PDO::PARAM_STR);
        return $stmt->execute([$data->id_produit, $data->id_producteur, $data->nom, $data->img_url, $data->prix, $data->type]);
    }
}
