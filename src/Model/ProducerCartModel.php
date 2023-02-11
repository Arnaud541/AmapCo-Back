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

    public function getCart($idProducerCart)
    {
        $request = "SELECT PanierProducteur.img_url,PanierProducteur.id,PanierProducteur.nom AS PanierProducteurNom ,Producteur.nom AS ProducteurNom,Producteur.prenom,PanierProducteur.description,Ingredient.nom AS IngredientNom, Produit.quantite
        FROM PanierProducteur 
        INNER JOIN Producteur ON PanierProducteur.id_producteur = Producteur.id 
        INNER JOIN Produit ON PanierProducteur.id = Produit.id_panier
        INNER JOIN Ingredient ON Produit.id_ingredient = Ingredient.id 
        WHERE PanierProducteur.id = :id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(":id", $idProducerCart, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getBySearch()
    {
        $request = "SELECT PanierProducteur.nom FROM PanierProducteur INNER JOIN Producteur ON PanierProducteur.id_producteur = Producteur.id WHERE CONCAT(Producteur.nom, Producteur.prenom, PanierProducteur.nom, PanierProducteur.type) LIKE '%" . $_GET["search"]["search"] . "%'";
        if (!empty($_GET["search"]["filters"])) {
            $request .= " AND ";
            $filtres = [];
            foreach ($_GET["search"]["filters"] as $key => $values) {
                foreach ($values as $value) {
                    $t = $key . " = " . "'" . $value . "'";
                    array_push($filtres, $t);
                }
            }
            $t2 = implode(" OR ", $filtres);
            $request .= $t2;
        }
        $stmt = $this->pdo->query($request);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCartBySearch($ingredient)
    {
        $request = "SELECT Produit.id_panier,PanierProducteur.nom,PanierProducteur.img_url FROM PanierProducteur INNER JOIN Produit ON PanierProducteur.id = Produit.id_panier INNER JOIN Ingredient ON Produit.id_ingredient = Ingredient.id WHERE Ingredient.nom LIKE ".'":ingredient"%'.";";
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
        $stmt->bindParam(":nom" , $data->nom, PDO::PARAM_STR);
        $stmt->bindParam(":img_url" , $data->img_url, PDO::PARAM_STR);
        $stmt->bindParam(":prix" , $data->prix, PDO::PARAM_STR);
        $stmt->bindParam(":type" , $data->type, PDO::PARAM_STR);
        return $stmt->execute([$data->id_produit, $data->id_producteur, $data->nom,$data->img_url,$data->prix,$data->type]);
    }
}
