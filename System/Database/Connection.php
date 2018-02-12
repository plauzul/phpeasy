<?php

namespace System\Database;

use System\Helpers\Functions;

/**
 * Inicia a conexão.
 * Com os dados passado pelo database.php a Connection inicia a conexão com o BD
 *
 * @author Paulo Henrique Ramos Ferreira
 */
class Connection {

    protected $db;

    public function __construct() {
        $config = require(Functions::base_dir()."/config/database.php");
        try {
            $db = new \PDO($config["drive"] . ":host=" . $config["host"] . ";dbname=" . $config["dbname"], $config["user"], $config["password"]);
            $this->db = $db;
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
}