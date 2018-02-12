<?php

namespace System\Database;

/**
 * Modela a tabela
 * Coloca a disposição das classes models, metodos pre-existente para mais facilidade e menos codigo repetido
 *
 * @author Paulo Henrique Ramos Ferreira
 */
class Model extends Connection {

    protected $table;

    public function __construct() {
        parent::__construct();
    }

    public function create($data) {}

    public function read($data) {}

    public function update($data) {}

    public function delete($data) {}

    public function find($id) {}

    public function query($query) {}
}