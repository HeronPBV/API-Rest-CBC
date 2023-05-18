<?php

use App\Core\Controller;

class Clubes extends Controller{

    public function index(){

        $clubeModel = $this->model("Clube");

        $clubes = $clubeModel->listAll();

        echo json_encode($clubes, JSON_UNESCAPED_UNICODE);
    }

    public function find(int $id){

        $clubeModel = $this->model("Clube");

        $clube = $clubeModel->listAll($id);

        echo json_encode($clube, JSON_UNESCAPED_UNICODE);

    }

    public function store(){

        $novoClube = $this->getRequestBody();

        if(empty($novoClube)){
            http_response_code(400);
            echo json_encode(["erro" => "Faltam dados na requisição"]);
            die();
        }

        $clubeModel = $this->model("Clube");
        $clubeModel->clube = $novoClube->clube;
        $clubeModel->saldo_disponivel = $novoClube->saldo_disponivel;

        $clubeModel = $clubeModel->insert();

        if ($clubeModel) {
            http_response_code(200);
            echo json_encode(["mensagem" => "ok"]);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Problemas ao inserir novo clube"]);
        }

    }

}