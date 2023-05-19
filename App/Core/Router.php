<?php

namespace App\Core;

class Router{

    private $controller;

    private $method;

    private $controllerMethod;

    private $params = [];

    function __construct(){
        
        $url = $this->parseURL();

        if(file_exists("../App/Controllers/" . ucfirst($url[1]) . ".php")){

            $this->controller = $url[1];
            unset($url[1]);

        }elseif(empty($url[1])){

            http_response_code(200);
            echo json_encode([
                "Nome" => "CBC API Rest Gerenciamento de Recursos",
                "Instrução" => "Acesse a documentação para saber os endpoints disponíveis",
                "Documentação" => "https://github.com/HeronPBV/API-Rest-CBC"
            ]);
            
            exit;

        }else{
            http_response_code(404);
            echo json_encode(["Erro" => "Recurso não encontrado"]);

            exit;
        }

        require_once "../App/Controllers/" . ucfirst($this->controller) . ".php";

        $this->controller = new $this->controller;

        $this->method = $_SERVER["REQUEST_METHOD"];
        
        switch($this->method){
            case "GET":

                if(get_class($this->controller) == "Recursos"){
                    http_response_code(400);
                    echo json_encode(["Erro" => "Método não suportado"]);
                    exit;
                }elseif(isset($url[2])){
                    $this->controllerMethod = "find";
                    $this->params = [(int)$url[2]];
                }else{
                    $this->controllerMethod = "index";
                }
                
                break;

            case "POST":
                $this->controllerMethod = "store";
                break;

            default: 
                http_response_code(400);
                echo json_encode(["Erro" => "Método não suportado"]);
                exit;
                break;
        }

        call_user_func_array([$this->controller, $this->controllerMethod], $this->params);
        
    }

    private function parseURL(){
        return explode("/", $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
    }

}