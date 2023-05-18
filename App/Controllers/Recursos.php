<?php

use App\Core\Controller;

class Recursos extends Controller{

    public function store(){

        $dadosConsumo = $this->getRequestBody();

        if(empty($dadosConsumo)){
            http_response_code(400);
            echo json_encode(["erro" => "Faltam dados na requisição"]);
            die();
        }

        $recursoModel = $this->model("Recurso");
        $clubeModel = $this->model("Clube");

        $clube_id = $dadosConsumo->clube_id;
        $recurso_id = $dadosConsumo->recurso_id;
        $valor_consumo = (float)(str_replace(",", ".", $dadosConsumo->valor_consumo));

        $clubeModel->listAll($clube_id);
        $recursoModel->select($recurso_id);

        if($this->HasEnoughResorces($clubeModel, $recursoModel, $valor_consumo)){

            $saldo_anterior = $clubeModel->saldo_disponivel;

            if($recursoModel->consume($clubeModel, $valor_consumo)){
                http_response_code(200);
                echo json_encode([
                    "clube" => $clubeModel->clube,
                    "saldo_anterior" => $saldo_anterior,
                    "saldo_atual" => $clubeModel->saldo_disponivel
                ]);
            }else{
                http_response_code(500);
                echo json_encode(["erro" => "Problemas ao consumir o recurso"]);
            }

        }else{
            http_response_code(400);
            echo json_encode(["erro" => "Não há recursos suficientes"]);
        }
    
        
    }

    private function HasEnoughResorces(Clube $clube, Recurso $recurso, float $valor_consumo){

        if($recurso->saldo_disponivel >= $valor_consumo && $clube->saldo_disponivel >= $valor_consumo){
            return true;
        }else{
            return false;
        }

    }


}