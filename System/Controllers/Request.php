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
     * Variavel que contem os respectivos chave e valor da request
     *
     * @var object
     */
    public $params;

    /**
     * Chama metodo para passar valores para o objeto params
     * 
     * @return void
     */
    public function __construct() {
        $this->params = new \stdClass();
        $this->getParams();
    }

    /**
     * Obtêm os paâmetros da requisição
     *
     * @return void
     */
    private function getParams() {
        if(!empty($_REQUEST)) {
            foreach($_REQUEST as $key => $value) {
                $this->params->$key = $value;
            }
        }
    }
}