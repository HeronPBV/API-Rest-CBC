<?php

use App\Core\Controller;

class Recursos extends Controller{

    public function store(){

        $dadosConsumo = $this->getRequestBody();

        $isValid = $this->IsRequestValid($dadosConsumo);
        if(!is_bool($isValid)){
            http_response_code(400);
            echo json_encode([
                "Erro" => $isValid,
                "Instruções" => "São necessários três parametros: 'clube_id', 'recurso_id' e 'valor_consumo', dessa exata forma, devendo o valor de consumo ser positivo"
            ]);
            die();
        }

        $recursoModel = $this->model("Recurso");
        $clubeModel = $this->model("Clube");

        $clube_id = (int)$dadosConsumo->clube_id;
        $recurso_id = (int)$dadosConsumo->recurso_id;
        $valor_consumo = (float)(str_replace(",", ".", $dadosConsumo->valor_consumo));

        $retornoClube = $clubeModel->select($clube_id);
        if(is_array($retornoClube)){
            http_response_code(400);
            echo json_encode($retornoClube);
            die();
        }
        $retornoRecurso = $recursoModel->select($recurso_id);
        if(is_array($retornoRecurso)){
            http_response_code(400);
            echo json_encode($retornoRecurso);
            die();
        }

        $retornoTemSaldo = $this->HasEnoughResorces($clubeModel, $recursoModel, $valor_consumo);
        if(is_bool($retornoTemSaldo) && $retornoTemSaldo == true){

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
                echo json_encode(["Erro" => "Problemas ao consumir o recurso"]);
            }

        }else{
            http_response_code(400);
            echo json_encode(["Erro" => $retornoTemSaldo]);
        }
    
        
    }

    private function HasEnoughResorces(Clube $clube, Recurso $recurso, float $valor_consumo){

        if($recurso->saldo_disponivel < $valor_consumo){
            return "O saldo disponível do recurso é insuficiente";
        }elseif($clube->saldo_disponivel < $valor_consumo){
            return "O saldo disponível do clube é insuficiente";
        }else{
            return true;
        }

    }

    private function IsRequestValid($request){

        if(empty($request)){
            return "É necessário um corpo para essa requisição";
        }elseif(empty($request->clube_id) || empty($request->recurso_id) || empty($request->valor_consumo)){
            return "Os dados inseridos são inválidos";
        }elseif((float)($request->valor_consumo) < 0){
            return "Não é possivel consumir um valor negativo";
        }else{
            return true;
        }

    }


}