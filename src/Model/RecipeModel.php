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
        $temps = intval($data->recipe->temps);

        $request = "INSERT INTO Recette (id_utilisateur ,titre ,description,dureeRealisation ,saison ,difficulte ,typePlat ,regimeAlimentaire) VALUES (:id_utilisateur ,:titre,:description,:dureeRealisation,:saison,:difficulte,:typePlat,:regimeAlimentaire)";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(":id_utilisateur", $data->recipe->id_utilisateur, PDO::PARAM_INT);
        $stmt->bindParam(":titre", $data->recipe->nom, PDO::PARAM_STR);
        $stmt->bindParam(":description", $data->recipe->description, PDO::PARAM_STR);
        $stmt->bindParam(":dureeRealisation", $temps, PDO::PARAM_INT);
        $stmt->bindParam(":saison", $data->recipe->saison, PDO::PARAM_STR);
        $stmt->bindParam(":difficulte", $data->recipe->difficulte, PDO::PARAM_STR);
        $stmt->bindParam(":typePlat", $data->recipe->typePlat, PDO::PARAM_STR);
        $stmt->bindParam(":regimeAlimentaire", $data->recipe->regime, PDO::PARAM_STR);
        $stmt->execute();
        $id_recette = $this->pdo->lastInsertId();

        foreach ($data->recipe->ustensiles as $u) {
            $request2 = "INSERT INTO Utiliser (id_recette,id_ustensile) VALUES (:id_recette, :id_ustensile)";
            $stmt2 = $this->pdo->prepare($request2);
            $stmt2->bindParam(':id_recette', $id_recette, PDO::PARAM_INT);
            $stmt2->bindParam(':id_ustensile', $u, PDO::PARAM_INT);
            $stmt2->execute();
        }

        foreach ($data->recipe->etapes as $e) {
            $request3 = "INSERT INTO Etape (id_recette, numero, contenu) VALUES (:id_recette, :numero, :contenu)";
            $stmt3 = $this->pdo->prepare($request3);
            $stmt3->bindParam('id_recette', $id_recette, PDO::PARAM_INT);
            $stmt3->bindParam(':numero', $e->etape, PDO::PARAM_INT);
            $stmt3->bindParam(':contenu', $e->description, PDO::PARAM_STR);
            $stmt3->execute();
        }

        foreach ($data->recipe->ingredients as $i) {
            $request4 = "INSERT INTO Contenir (id_recette, id_ingredient, quantite, unite) VALUES (:id_recette, :id_ingredient, :quantite, :unite)";
            $stmt4 = $this->pdo->prepare($request4);
            $stmt4->bindParam('id_recette', $id_recette, PDO::PARAM_INT);
            $stmt4->bindParam(':id_ingredient', $i->ingredient, PDO::PARAM_INT);
            $stmt4->bindParam(':quantite', $i->quantite, PDO::PARAM_INT);
            $stmt4->bindParam(':unite', $i->unite, PDO::PARAM_STR);
            $stmt4->execute();
        }

        return true;
    }

    public function update($data)
    {
        $temps = intval($data->recipe->temps);

        $request = "UPDATE Recette SET titre = :titre ,description = :description, dureeRealisation=:dureeRealisation ,saison = :saison ,difficulte = :difficulte ,typePlat = :typePlat ,regimeAlimentaire = :regimeAlimentaire WHERE id = :id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(":id", $data->recipe->id_recette, PDO::PARAM_INT);
        $stmt->bindParam(":titre", $data->recipe->nom, PDO::PARAM_STR);
        $stmt->bindParam(":description", $data->recipe->description, PDO::PARAM_STR);
        $stmt->bindParam(":dureeRealisation", $temps, PDO::PARAM_INT);
        $stmt->bindParam(":saison", $data->recipe->saison, PDO::PARAM_STR);
        $stmt->bindParam(":difficulte", $data->recipe->difficulte, PDO::PARAM_STR);
        $stmt->bindParam(":typePlat", $data->recipe->typePlat, PDO::PARAM_STR);
        $stmt->bindParam(":regimeAlimentaire", $data->recipe->regime, PDO::PARAM_STR);
        $stmt->execute();

        foreach ($data->recipe->ustensiles as $u) {
            $request2 = "UPDATE Utiliser SET id_ustensile = :id_ustensile WHERE id_recette = :id_recette";
            $stmt2 = $this->pdo->prepare($request2);
            $stmt2->bindParam(':id_recette', $data->recipe->id_recette, PDO::PARAM_INT);
            $stmt2->bindParam(':id_ustensile', $u, PDO::PARAM_INT);
            $stmt2->execute();
        }

        foreach ($data->recipe->etapes as $e) {
            $request3 = "UPDATE Etape SET numero = :numero, contenu = :contenu WHERE id_recette = :id_recette";
            $stmt3 = $this->pdo->prepare($request3);
            $stmt3->bindParam('id_recette', $data->recipe->id_recette, PDO::PARAM_INT);
            $stmt3->bindParam(':numero', $e->etape, PDO::PARAM_INT);
            $stmt3->bindParam(':contenu', $e->description, PDO::PARAM_STR);
            $stmt3->execute();
        }

        foreach ($data->recipe->ingredients as $i) {
            $request4 = "UPDATE Contenir SET id_ingredient = :id_ingredient, quantite = :quantite, unite = :unite WHERE id_recette = :id_recette";
            $stmt4 = $this->pdo->prepare($request4);
            $stmt4->bindParam('id_recette', $data->recipe->id_recette, PDO::PARAM_INT);
            $stmt4->bindParam(':id_ingredient', $i->ingredient, PDO::PARAM_INT);
            $stmt4->bindParam(':quantite', $i->quantite, PDO::PARAM_INT);
            $stmt4->bindParam(':unite', $i->unite, PDO::PARAM_STR);
            $stmt4->execute();
        }

        return true;
    }

    public function getAssociatedRecipes()
    {
        $request2 = "SELECT Ingredient.nom AS IngredientNom FROM Ingredient INNER JOIN Produit ON Produit.id_ingredient = Ingredient.id WHERE Produit.id_panier = 8";
        $stmt = $this->pdo->prepare($request2);
        $stmt->execute();
        $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $request = "SELECT Recette.id FROM Recette 
        INNER JOIN Contenir ON Contenir.id_recette = Recette.id 
        INNER JOIN Ingredient ON Contenir.id_ingredient = Ingredient.id 
        WHERE";
        $array = [];
        foreach ($ingredients as $i) {
            $ing_field = "Ingredient.nom" . " = " . $i["IngredientNom"];
            array_push($array, $ing_field);
        }

        foreach ($array as $element) {
        }
    }

    public function getBySearch()
    {
        $request = "SELECT Recette.id, Recette.titre FROM Recette ";
        if (!empty($_GET["search"]["filters"])) {

            if (!empty($_GET["search"]["filters"]["ingredient"])) {
                $request .= "INNER JOIN Contenir ON Contenir.id_recette = Recette.id INNER JOIN Ingredient ON Contenir.id_ingredient = Ingredient.id WHERE ";
                $filtre_ingredients = [];
                foreach ($_GET["search"]["filters"]["ingredient"] as $value) {
                    $f_ingredient = "Ingredient.nom" . " = " . "'$value'";
                    array_push($filtre_ingredients, $f_ingredient);
                }

                $f_ingredient2 = implode(" OR ", $filtre_ingredients);
                $request .= $f_ingredient2;

                $request .= " AND ";

                $filtres = [];
                foreach ($_GET["search"]["filters"] as $key => $values) {
                    foreach ($values as $value) {
                        if ($key != "ingredient") {
                            $t = $key . " = " . "'" . $value . "'";
                            array_push($filtres, $t);
                        }
                    }
                }
                $t2 = implode(" AND ", $filtres);
                $request .= $t2;
                $request .= count($_GET["search"]["filters"]) > 2 ? " AND " : null;
                $request .= "CONCAT(Recette.titre,Recette.description) LIKE '%" . $_GET["search"]["search"] . "%'";
            } else {
                $request .= "WHERE ";
                $filtres = [];
                foreach ($_GET["search"]["filters"] as $key => $values) {
                    foreach ($values as $value) {
                        $t = $key . " = " . "'" . $value . "'";
                        array_push($filtres, $t);
                    }
                }
                $t2 = implode(" AND ", $filtres);
                $request .= $t2;
                $request .= " AND CONCAT(Recette.titre,Recette.description) LIKE '%" . $_GET["search"]["search"] . "%'";
            }
        } else {
            $request .= " WHERE CONCAT(Recette.titre,Recette.description) LIKE '%" . $_GET["search"]["search"] . "%'";
        }

        $stmt = $this->pdo->prepare($request);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $request = "SELECT Recette.id_utilisateur, Recette.titre, Recette.photo, Recette.dureeRealisation, Recette.saison, Recette.difficulte, Recette.typePlat, Recette.regimeAlimentaire 
        FROM Recette 
        WHERE Recette.id = :id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteRecipeById($data)
    {
        $id_recette = intval($data->id_recette);
        $request = "DELETE FROM Recette WHERE id = :id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(":id", $id_recette, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function getComments($idRecipe)
    {
        $request = "SELECT Commentaire.id, Commentaire.contenu, Commentaire.created_at, CONCAT(Utilisateur.nom, ' ', Utilisateur.prenom) AS nom, Utilisateur.avatar, NoteRecette.note 
        FROM Recette 
        INNER JOIN Commentaire ON Commentaire.id_recette = Recette.id 
        INNER JOIN Utilisateur ON Utilisateur.id = Commentaire.id_utilisateur 
        LEFT JOIN NoteRecette ON NoteRecette.id_recette = Recette.id AND NoteRecette.id_utilisateur = Utilisateur.id 
        WHERE Recette.id = :id";
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

    public function getNote($idRecipe)
    {
        $request = "SELECT AVG(note) AS note FROM NoteRecette WHERE id_recette = :id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam('id', $idRecipe, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRecipesByIdUser($idUtilisateur)
    {
        $request = "SELECT Recette.id, titre, Recette.photo FROM Recette WHERE id_utilisateur = :id";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam('id', $idUtilisateur, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSimilarRecipe($recipe)
    {
        $request = "SELECT Recette2.id, Recette2.titre, Recette2.photo, COUNT(DISTINCT Contenir.id_ingredient) AS nb_ingredients_communs
        FROM Recette
        JOIN Contenir ON Recette.id = Contenir.id_recette
        JOIN Contenir AS Contenir2 ON Contenir.id_ingredient = Contenir2.id_ingredient AND Contenir.id_recette <> Contenir2.id_recette
        JOIN Recette AS Recette2 ON Contenir2.id_recette = Recette2.id
        WHERE Recette.id = :id AND Recette.id <> Recette2.id
        GROUP BY Recette.id, Recette2.id
        ORDER BY nb_ingredients_communs DESC
        LIMIT 5;";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id', $recipe, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSimilarRecipeCart($cart)
    {
        $request = "SELECT Recette.id, Recette.titre, Recette.photo, COUNT(DISTINCT Contenir.id_ingredient) AS nb_ingredients_communs
        FROM Recette
        JOIN Contenir ON Recette.id = Contenir.id_recette
        JOIN Produit ON Contenir.id_ingredient = Produit.id
        JOIN PanierProducteur ON Produit.id_panier = PanierProducteur.id
        WHERE PanierProducteur.id = :id
        GROUP BY Recette.id
        ORDER BY nb_ingredients_communs DESC
        LIMIT 6;";
        $stmt = $this->pdo->prepare($request);
        $stmt->bindParam(':id', $cart, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
