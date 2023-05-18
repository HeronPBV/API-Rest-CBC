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

        $clubeModel = $this->model("Clube");
        $clubeModel->clube = $novoClube->clube;
        $clubeModel->saldo_disponivel = $novoClube->saldo_disponivel;

        $clubeModel = $clubeModel->insert();

        if ($clubeModel) {
            http_response_code(200);
            echo "ok";
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Problemas ao inserir preco"]);
        }

    }

}