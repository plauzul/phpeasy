<?php

namespace System\Web;

/**
 * Inicia o roteamento da aplicação
 * 
 * Leva cada rota para seu controller conrespondente
 *
 * @author Paulo Henrique Ramos Ferreira
 */
class Routes {

    /**
     * Armaze as todas as rotas declaradas em routes/web.php
     * 
     * @var string
     */
    private $routes;

    /**
     * Adiciono os valores em $routes e chamo run() passando o getUrl()
     * 
     * @return void
     */
    public function __construct() {
        $this->setRoutes();
        $this->run($this->getUrl());
    }

    /**
     * Adiciono os valores em $routes
     * 
     * @return void
     */
    protected function setRoutes() {
        $this->routes = require("../routes/web.php");
    }

    /**
     * Apartir da url atual vejo se bate com alguma declarada em routes/web.php se caso tenho instancio o contreller al qual ela estiver apontando
     * 
     * @return void
     */
    protected function run($url) {
        foreach ($this->routes as $route) {
            if ($url == $route['route']) {
                foreach ($route['method'] as $method) {
                    if (strtoupper($method) == $_SERVER['REQUEST_METHOD']) {
                        $class = "App\\Controllers\\".ucfirst($route['controller']);
                        $controller = new $class();
                        $controller->{$route['action']}();
                    }
                }
            }
        }
    }

    /**
     * Obtém o valor atual da url
     * 
     * @return array
     */
    protected function getUrl() {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}