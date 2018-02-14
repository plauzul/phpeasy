<?php

namespace System\Controllers;

use System\Helpers\Functions;
use System\View\Template;

/**
 * Inicia os controllers
 * 
 * E atualmente trabalha mais especificada para o retorno das views
 *
 * @author Paulo Henrique Ramos Ferreira
 */
class Controller extends Functions {

    /**
     * Renderiza uma view sem implementação de layout
     *
     * @param string $viewName caminho de onde se encontra a view a partir de Views/
     * @param array $vars variaveis que estaram disponiveis na view
     * @param int $httpStatus http status para retorno da pagina, default 200
     * @return void
     */
    public function render($viewName, $vars = null, $httpStatus = null) {
        if($vars) extract($vars, EXTR_SKIP);
        if($httpStatus) http_response_code($httpStatus);
        include_once "../App/Views/" . $viewName;
    }

    /**
     * Renderiza uma view com implementação de layout
     *
     * @param string $viewName caminho de onde se encontra a view a partir de Views/
     * @param string $templateName caminho de onde se encontra o template a partir de Views/
     * @param array $vars variaveis que estaram disponiveis na view
     * @param int $httpStatus http status para retorno da pagina, default 200
     * @return void
     */
    public function renderWithTemplate($viewName, $templateName, $vars = null, $httpStatus = null) {
        if($vars) extract($vars, EXTR_SKIP);
        if($httpStatus) http_response_code($httpStatus);
        $template = new Template($viewName, $templateName);
        include_once $template->returnView();
    }
}