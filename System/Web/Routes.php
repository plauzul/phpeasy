<?php

namespace System\Web;

use System\Helpers\Functions;

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
     * Verefica se alguma url não foi encontrada
     * 
     * @var boolean
     */
    private $hasUrlNotFound;

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
                $this->hasUrlNotFound = true;
                foreach ($route['method'] as $method) {
                    if (strtoupper($method) == $_SERVER['REQUEST_METHOD']) {
                        if(isset($route['middleware'])) {
                            $class = "App\\Middleware\\".ucfirst($route['middleware']);
                            $middleware = new $class();
                            $middleware->run();
                        }
                        $class = "App\\Controllers\\".ucfirst($route['controller']);
                        $controller = new $class();
                        $controller->{$route['action']}();
                    }
                }
            }
        }

        if(!$this->hasUrlNotFound) {
            $this->urlNotFound();
        }
    }

    /**
     * Executado caso não encontre nenhuma url atual que bata  com alguma cadastrada em routes/web.php
     *
     * @return void
     */
    protected function urlNotFound() {
        http_response_code(404);
        echo json_encode(['status' => 'url_not_found']);
    }

    /**
     * Obtém o valor atual da url
     * 
     * @return array
     */
    protected function getUrl() {
        $app = require(Functions::base_dir()."/config/app.php");
        $url = 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $newUrl = str_replace($app['url'], "", $url);

        return parse_url($newUrl, PHP_URL_PATH);
    }
}