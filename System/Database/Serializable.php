<?php

namespace System\Database;

/**
 * Modela a tabela
 * 
 * Coloca a disposição das classes models, metodos pre-existente para mais facilidade e menos codigo repetido
 *
 * @author Paulo Henrique Ramos Ferreira
 */
trait Serializable {

    /**
     * Transformar todos os atributos da classe em array com seus respectivos valores
     *
     * @return array
     */
    public function serialize() {
        $temp = (array) $this;
        $array = [];
        if(!isset($temp["elements"])) {
            foreach ($temp as $k => $v) {
                $k = preg_match('/^\x00(?:.*?)\x00(.+)/', $k, $matches ) ? $matches[1] : $k;
                if (in_array($k, [])) {
                    $array[$k] = "";
                } else {
                    // if it is an object recursive call
                    if (is_object($v) && $v instanceof Serializable) {
                        $array[$k] = $v->toArray();
                    }
                    // if its an array pass por each item
                    if (is_array($v)) {
                        foreach ($v as $key => $value) {
                            if (is_object ($value) && $value instanceof Serializable) {
                                $arrayReturn[$key] = $value->toArray();
                            } else {
                                $arrayReturn[$key] = $value;
                            }
                        }
                        $array [$k] = $arrayReturn;
                    }
                    // if it is not a array and a object return it
                    if (!is_object($v) && !is_array($v)) {
                        $array[$k] = $v;
                    }
                }
            }
        } else {
            foreach ($temp["elements"] as $key => $value) {
                $value = (array) $value;
                // var_dump($value);
                foreach ($value as $k => $v) {
                    $k = preg_match('/^\x00(?:.*?)\x00(.+)/', $k, $matches ) ? $matches[1] : $k;
                    if (in_array($k, [])) {
                        $array[$key][$k] = "";
                    } else {
                        // if it is an object recursive call
                        if (is_object($v) && $v instanceof Serializable) {
                            $array[$key][$k] = $v->toArray();
                        }
                        // if its an array pass por each item
                        if (is_array($v)) {
                            foreach ($v as $key => $value) {
                                if (is_object ($value) && $value instanceof Serializable) {
                                    $arrayReturn[$key] = $value->toArray();
                                } else {
                                    $arrayReturn[$key] = $value;
                                }
                            }
                            $array[$key][$k] = $arrayReturn;
                        }
                        // if it is not a array and a object return it
                        if (!is_object($v) && !is_array($v)) {
                            $array[$key][$k] = $v;
                        }
                    }
                }
            }
        }
        return $array;
    }

    /**
     * Retorna a função serialize() codificada para json
     *
     * @return json
     */
    public function toJson() {
        return json_encode($this->serialize());
    }

    /**
     * Apenas retorna a função serialize, que por si retorna um array
     *
     * @return array
     */
    public function toArray() {
        return $this->serialize();
    }
}