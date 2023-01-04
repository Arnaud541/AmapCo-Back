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
        $request = "SELECT * FROM Recipe";
        $stmt = $this->pdo->query($request);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByParams($params)
    {
        $request = "SELECT * FROM recipe WHERE ";
        $firstLoop = false;
        foreach($params as $param => $value){
            if($firstLoop == true){
                $request = $request." AND ";
            }
            $request = $request.$param." = :".$param;
            $firstLoop = true;
        }
        $stmt = $this->pdo->prepare($request);
        foreach($params as $param => $value){
            $stmt -> bindParam(":".$param, $value, PDO::PARAM_STR);
        }
        return $stmt->execute();
    }

    public function insertRecipe($data)
    {
        $request = "INSERT INTO Recipe (title, description, photo) VALUES (?,?,?)";
        $stmt = $this->pdo->prepare($request);
        return $stmt->execute([$data->title, $data->description, $data->photo]);
    }
}
