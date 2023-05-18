<?php

use App\Core\Model;

class Recurso{

    private static $table_name = 'recurso';
    public $id;
    public $recurso;
    public $saldo_disponivel;

    public function select(int $id){
        $query = " SELECT * FROM ". self::$table_name ." WHERE id = ? ";
        $stmt = Model::getConn()->prepare($query);
        $stmt->bindValue(1, $id);

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$result) {
                return "Recurso não encontrado";
            }

            $this->id = $result->id;
            $this->recurso = $result->recurso;
            $this->saldo_disponivel = $result->saldo_disponivel;


            return $this;
        } else {
            return "Query não executada";
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

    public function consume(Clube $clube, float $valor_consumo){
        
        $clube->saldo_disponivel -= $valor_consumo; 
        $this->saldo_disponivel -= $valor_consumo;

        if($clube->update() && $this->update()){
            return "ok";
        }
        
    }


}