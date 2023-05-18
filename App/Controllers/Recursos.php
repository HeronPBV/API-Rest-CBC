<?php

use App\Core\Controller;

class Recursos extends Controller{

    public function store(){

        $dadosConsumo = $this->getRequestBody();

        $recursoModel = $this->model("Recurso");
        $clubeModel = $this->model("Clube");

        $clube_id = $dadosConsumo->clube_id;
        $recurso_id = $dadosConsumo->recurso_id;
        $valor_consumo = floatval($dadosConsumo->valor_consumo);

        //Verificar antes se há recursos suficientes

        $clubeModel->listAll($clube_id);
        $recursoModel->select($recurso_id);
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

        
        
    }

}