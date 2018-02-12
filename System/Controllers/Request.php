<?php

namespace System\Controllers;

/**
 * Obtem os parâmetros da url
 * Retorna os parametros obtido para a classe que a pediu, e sanitiza caracteres especiais
 *
 * @author Paulo Henrique Ramos Ferreira
 */
class Request {

    public $params;

    public function __construct() {
        $this->params = new \stdClass();
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->getParamsGET();
                break;
            case 'POST':
                $this->getParamsPOST();
                break;
        }
    }

    public function getParamsGET() {
        if(isset(explode("?", $_SERVER['REQUEST_URI'])[1])) {
            $queryString = explode("?", $_SERVER['REQUEST_URI'])[1];
            $values = explode("&", $queryString);
            foreach ($values as $key => $value) {
                $this->params->{explode("=", $value)[0]} = filter_var(explode("=", $value)[1], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
    }

    public function getParamsPOST() {
        foreach ($_POST as $key => $value) {
            $this->params->$key = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
    }

    public function redirectTo($path) {
        header("location:$path");
    }
}