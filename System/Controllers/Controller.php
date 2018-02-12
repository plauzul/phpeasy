<?php

namespace System\Controllers;

use System\Helpers\Functions;
use System\View\Template;

/**
 * Inicia os controllers
 * E trabalha mais especificada para o retorno das views
 *
 * @author Paulo Henrique Ramos Ferreira
 */
class Controller extends Functions {

    private $template;

    public function render($action, $vars = null, $httpStatus = null) {
        if($vars) extract($vars, EXTR_SKIP);
        if($httpStatus) http_response_code($httpStatus);
        include_once "../App/Views/" . $action;
        return $this;
    }

    public function renderWithTemplate($viewName, $templateName, $vars = null, $httpStatus = null) {
        if($vars) extract($vars, EXTR_SKIP);
        if($httpStatus) http_response_code($httpStatus);
        $template = new Template($viewName, $templateName);
        include_once $template->returnView();
        return $this;
    }
}