<?php

namespace System\Controllers;

/**
 * Obtem os parâmetros da url
 * 
 * Retorna os parametros obtido para a classe que a pediu, e sanitiza caracteres especiais
 *
 * @author Paulo Henrique Ramos Ferreira
 */
class Request {

    /**
     * Variavel que contem os respectivos chave e valor da url
     *
     * @var object
     */
    public $params;

    /**
     * Chama determinado metodo a partir do REQUEST_METHOD
     * 
     * @return void
     */
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

    /**
     * Obtêm os parâmetros da url se caso esteja no verbo GET
     *
     * @return void
     */
    private function getParamsGET() {
        if(isset(explode("?", $_SERVER['REQUEST_URI'])[1])) {
            $queryString = explode("?", $_SERVER['REQUEST_URI'])[1];
            $values = explode("&", $queryString);
            foreach ($values as $key => $value) {
                $this->params->{explode("=", $value)[0]} = filter_var(explode("=", $value)[1], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
    }

    /**
     * Obtêm os paâmetros da url se caso esteja no verbo POST
     *
     * @return void
     */
    private function getParamsPOST() {
        foreach ($_POST as $key => $value) {
            $this->params->$key = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
    }
}