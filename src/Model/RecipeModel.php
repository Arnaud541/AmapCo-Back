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
        $request = "SELECT * FROM Recette";
        $stmt = $this->pdo->query($request);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $request = "INSERT INTO Recette (id_utilisateur ,titre ,description ,photo ,dureeRealisation ,saison ,difficulte ,typePlat ,regimeAlimentaire) VALUES (:id_utilisateur ,:titre,:description,:photo,:dureeRealisation,:saison,:difficulte,:typePlat,:regimeAlimentaire)";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id_utilisateur ', $data->id_utilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':titre', $data->titre, PDO::PARAM_STR);
        $stmt->bindParam(":description", $data->description, PDO::PARAM_STR);
        $stmt->bindParam(":photo", $data->photo, PDO::PARAM_STR);
        $stmt->bindParam(":dureeRealisation", $data->dureeRealisation, PDO::PARAM_INT);
        $stmt->bindParam(":saison", $data->saison, PDO::PARAM_STR);
        $stmt->bindParam(":difficulte", $data->difficulte, PDO::PARAM_STR);
        $stmt->bindParam(":typePlat", $data->typePlat, PDO::PARAM_STR);
        $stmt->bindParam(":regimeAlimentaire", $data->regimeAlimentaire, PDO::PARAM_STR);
        return $stmt->execute([$data->id_utilisateur, $data->titre, $data->description, $data->photo, $data->dureeRealisation, $data->saison, $data->difficulte, $data->typePlat, $data->regimeAlimentaire]);
    }



    public function getBySearch()
    {
        $request = "SELECT * FROM Recette WHERE CONCAT(titre,description) LIKE '%" . $_GET["search"]["search"] . "%'";
        if (!empty($_GET["search"]["filters"])) {
            $request .= " AND ";
            $filtres = [];
            foreach ($_GET["search"]["filters"] as $key => $values) {
                foreach ($values as $value) {
                    $t = $key . " = " . "'" . $value . "'";
                    array_push($filtres, $t);
                }
            }
            $t2 = implode(" AND ", $filtres);
            $request .= $t2;
        }
        $stmt = $this->pdo->query($request);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $request = "SELECT Recette.titre, Recette.photo, Recette.dureeRealisation, Recette.saison, Recette.difficulte, Recette.typePlat, Recette.regimeAlimentaire, Contenir.quantite, Ingredient.nom as nomIngredient, Ustensile.nom as nomUstensile, Etape.numero, Etape.contenu, Commentaire.contenu as commentaire 
        FROM Recette 
        INNER JOIN Contenir ON Recette.id = Contenir.id_recette 
        INNER JOIN Ingredient ON Contenir.id_ingredient = Ingredient.id
        INNER JOIN Utiliser ON Recette.id = Utiliser.id_recette
        INNER JOIN Ustensile ON Utiliser.id_ustensile = Ustensile.id
        INNER JOIN Etape ON Recette.id = Etape.id_recette
        INNER JOIN Commentaire ON Recette.id = Commentaire.id_recette
        WHERE Recette.id = :id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getComments($idRecipe)
    {
        $request = "SELECT id, contenu FROM Commentaire WHERE id_recette = :id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam('id', $idRecipe, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getUstensils($idRecipe)
    {
        $request = "SELECT id, nom FROM Ustensile INNER JOIN Utiliser ON Ustensile.id = Utiliser.id_ustensile WHERE id_recette = :id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam('id', $idRecipe, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIngredients($idRecipe)
    {
        $request = "SELECT id, nom, quantite FROM Ingredient INNER JOIN Contenir ON Ingredient.id = Contenir.id_ingredient WHERE id_recette = :id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam('id', $idRecipe, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSteps($idRecipe)
    {
        $request = "SELECT id, numero, contenu FROM Etape WHERE id_recette = :id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam('id', $idRecipe, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
