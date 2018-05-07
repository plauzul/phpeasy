<?php

namespace System\Database;

/**
 * Modela a tabela
 * 
 * Coloca a disposição das classes models, metodos pre-existente para mais facilidade e menos codigo repetido
 *
 * @author Paulo Henrique Ramos Ferreira
 */
abstract class Model {
    use Serializable;

    /**
     * Tabela atual da instancia que ira se trabalhar
     *
     * @var string
     */
    protected $table;

    /**
     * Variavel que contem a instancia do banco de dados
     *
     * @var Connection
     */
    protected $db;

    /**
     * Variavel que contem os resultados da consulta para que elas possam ser dinamicas
     *
     * @var PDOStatement
     */
    private $stmt;

    /**
     * Variavel que conterá os resultados de getAll
     *
     * @var array
     */
    public $elements;

    /**
     * Inicia o construtor da classe pai
     * 
     * @return void
     */
    public function __construct() {
        $this->db = Connection::getInstance();
    }

    /**
     * Cria um novo registro no banco de dados
     *
     * @param array $data
     * @return Model
     */
    public function create($data) {
        $this->stmt = $this->db->prepare("INSERT INTO $this->table (".implode(", ", str_replace(":", "", array_keys($data))).") VALUES (".implode(", ", array_keys($data)).")");
        foreach ($data as $key => $value) {
            $this->stmt->bindValue($key, $value);
        }
        $this->stmt->execute();
        return $this->db->lastInsertId();
    }

    /**
     * Faz busca de registros
     *
     * @param array $fields
     * @param array $values
     * @return Model
     */
    public function read($fields, $values = null) {
        if(!$values) {
            $this->stmt = $this->db->prepare("SELECT ".implode(", ", $fields)." FROM $this->table");
        } else {
            $this->stmt = $this->db->prepare("SELECT ".implode(", ", $fields)." FROM $this->table WHERE ".implode(" ", $values)."");
        }
        $this->stmt->execute();
        return $this;
    }

    /**
     * Atualiza algum registro
     *
     * @param array $fields
     * @param array $where
     * @return Model
     */
    public function update($fields, $where = null) {
        $sql = "";
        foreach ($fields as $key => $value) {
            $sql .= str_replace(":", "", $key)." = $key, ";
        }
        $sql = substr($sql, 0, -2);
        if(!$where) {
            $this->stmt = $this->db->prepare("UPDATE $this->table SET ".$sql);
        } else {
            $this->stmt = $this->db->prepare("UPDATE $this->table SET ".$sql." WHERE ".implode(" ", $where));
        }
        foreach ($fields as $key => $value) {
            $this->stmt->bindValue($key, $value);
        }
        $this->stmt->execute();
        return $this;
    }

    /**
     * Deleta algum registro
     *
     * @param array $data
     * @return Model
     */
    public function delete($data) {
        $this->stmt = $this->db->prepare("DELETE FROM $this->table WHERE ".implode(" ", $data)."");
        $this->stmt->execute();
        return $this;
    }

    /**
     * Executa query sql personalizada
     *
     * @param string $query
     * @return Model
     */
    public function query($query) {
        $this->stmt = $this->db->prepare($query);
        $this->stmt->execute();
        return $this;
    }

    /**
     * Retorna um unico conjunto de dados de uma busca
     *
     * @return object
     */
    public function get() {
        $this->stmt->setFetchMode(\PDO::FETCH_CLASS, get_class($this));
        return $this->stmt->fetch();
    }

    /**
     * Retorna um array de dados de uma busca
     *
     * @return array
     */
    public function getAll() {
        $this->stmt->setFetchMode(\PDO::FETCH_CLASS, get_class($this));
        $this->elements = $this->stmt->fetchAll();
        return $this;
    }

    /**
     * Retorna o total da consulta
     *
     * @return int
     */
    public function count() {
        return $this->stmt->fetch(\PDO::FETCH_NUM)[0] ?? 0;
    }

    /**
     * Retorna um booleano informando se tem ou não determinado registro
     *
     * @return boolean
     */
    public function has() {
        return (boolean) $this->stmt->rowCount();
    }
}