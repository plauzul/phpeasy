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

    private $routes;

    public function __construct() {
        $this->setRoutes();
        $this->run($this->getUrl());
    }

    protected function setRoutes() {
        $this->routes = require("../routes/web.php");
    }

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

    protected function getUrl() {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}