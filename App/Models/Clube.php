<?php

use App\Core\Model;

class Clube{

    private static $table_name = 'clube';
    public $id;
    public $clube;
    public $saldo_disponivel;

    public function listAll(int $id = null){

        if(is_null($id)){

            $query = " SELECT * FROM ". self::$table_name ." ORDER BY id ASC ";
    
            $stmt = Model::getConn()->prepare($query);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    
                return $result;
            } else {
                return [];
            }
        
        }else{

            $query = " SELECT * FROM ". self::$table_name ." WHERE id = ? ";
            $stmt = Model::getConn()->prepare($query);
            $stmt->bindValue(1, $id);

            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_OBJ);

                if (!$result) {
                    return "Clube não encontrado";
                }

                $this->id = $result->id;
                $this->clube = $result->clube;
                $this->saldo_disponivel = $result->saldo_disponivel;


                return $this;
            } else {
                return "Query não executada";
            }

        }
    
    }

    public function insert(){
        
        $query = " INSERT INTO ". self::$table_name ." (clube, saldo_disponivel) VALUES (?, ?) ";
        
        $stmt = Model::getConn()->prepare($query);
        $stmt->bindValue(1, $this->clube);
        $stmt->bindValue(2, $this->saldo_disponivel);

        if ($stmt->execute()) {
            $this->id = Model::getConn()->lastInsertId();
            return $this;
        } else {
            print_r($stmt->errorInfo());
            return null;
        }

    }

    public function update(){

        $query = " UPDATE ". self::$table_name ." SET saldo_disponivel = ? WHERE id = ? ";

        $stmt = Model::getConn()->prepare($query);
        $stmt->bindValue(1, $this->saldo_disponivel);
        $stmt->bindValue(2, $this->id);

        if ($stmt->execute()) {
            return $this;
        } else {
            print_r($stmt->errorInfo());
            return null;
        }

    }




}