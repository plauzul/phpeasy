<?php

namespace System\Database;

/**
 * Modela a tabela
 * 
 * Coloca a disposição das classes models, metodos pre-existente para mais facilidade e menos codigo repetido
 *
 * @author Paulo Henrique Ramos Ferreira
 */
class Model extends Connection {

    /**
     * Tabela atual da instancia que ira se trabalhar
     *
     * @var string
     */
    protected $table;

    /**
     * Inicia o construtor da classe pai
     * 
     * @return void
     */
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