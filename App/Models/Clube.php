<?php

use App\Core\Model;

class Clube{

    private static $table_name = 'clube';
    public $id;
    public $clube;
    public $saldo_disponivel;

    public function listAll(int $id = null){

        if(is_null($id)){

            $query = " SELECT * FROM ". self::$table_name ." ORDER BY id DESC ";
    
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
                    return null;
                }

                $this->id = $result->id;
                $this->clube = $result->clube;
                $this->saldo_disponivel = $result->saldo_disponivel;


                return $this;
            } else {
                return null;
            }

        }
    
    }


}