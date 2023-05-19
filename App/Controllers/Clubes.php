<?php

use App\Core\Controller;

class Clubes extends Controller{

    public function index(){

        $clubeModel = $this->model("Clube");

        $clubes = $clubeModel->select();

        echo json_encode($clubes, JSON_UNESCAPED_UNICODE);
    }

    public function find(int $id){

        $clubeModel = $this->model("Clube");

        $clube = $clubeModel->select($id);

        echo json_encode($clube, JSON_UNESCAPED_UNICODE);

    }

    public function store(){

        $novoClube = $this->getRequestBody();

        $isValid = $this->IsRequestValid($novoClube);
        if(!is_bool($isValid)){
            http_response_code(400);
            echo json_encode([
                "Erro" => $isValid,
                "Instruções" => "São necessários dois parametros: 'clube' e 'saldo_disponivel', dessa exata forma, devendo o saldo ser um valor positivo"
            ]);
            die();
        }

        $clubeModel = $this->model("Clube");
        $clubeModel->clube = $novoClube->clube;
        $clubeModel->saldo_disponivel = (float)(str_replace(",", ".", $novoClube->saldo_disponivel));

        $clubeModel = $clubeModel->insert();

        if ($clubeModel) {
            http_response_code(200);
            echo json_encode(["Mensagem" => "ok"]);
        } else {
            http_response_code(500);
            echo json_encode(["Erro" => "Problemas ao inserir novo clube"]);
        }

    }

    private function IsRequestValid($request){

        if(empty($request)){
            return "É necessário um corpo para essa requisição";
        }elseif(empty($request->clube) || !is_string($request->clube) || empty($request->saldo_disponivel)){
            return "Os dados inseridos são inválidos";
        }elseif((float)($request->saldo_disponivel) < 0){
            return "Um clube não pode ter saldo negativo";
        }else{
            return true;
        }

    }

}