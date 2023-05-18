<?php

use App\Core\Controller;

class Clubes extends Controller{

    public function index(){

        $clubeModel = $this->model("Clube");

        $clubes = $clubeModel->listAll();

        echo json_encode($clubes, JSON_UNESCAPED_UNICODE);
    }

}