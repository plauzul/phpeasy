<?php

namespace System\Init;

/**
 * Inicia os hooks
 * 
 * Classe que inicia os hooks a partir do arquivo de configuração hook.php
 *
 * @author Paulo Henrique Ramos Ferreira
 */
class Hooks {

  /**
   * Instancia todos os hook´s que foram adicionados em config/hooks.php
   * 
   * @return void
   */
  public function __construct() {
    $hooks = require("../config/hooks.php");;

    foreach ($hooks as $value) {
      $class = "Hooks\\".$value;
      $controller = new $class();
      $controller->run();
    }
  }
}