<?php

namespace System\Helpers;

/**
 * Funções utilizaveis em todas as classes
 * 
 * Provimento de funções helpers utilizadas em todas as classes
 *
 * @author Paulo Henrique Ramos Ferreira
 */
class Functions {

    /**
     * Retorna o diretorio raiz completo da aplicação
     *
     * @return void
     */
    public static function base_dir() {
        if(PHP_OS == "Linux") {
            $pathExplode = explode("/", __DIR__);
            array_splice($pathExplode, - 2);
            return implode("/", $pathExplode);
        } else {
            $pathExplode = explode("\\", __DIR__);        
            array_splice($pathExplode, - 2);            
            return str_replace("\\", "/", implode("\\", $pathExplode));
        }
    }

    /**
     * Insere o css na pagina
     *
     * @param string $path caminho de onde se encontra o .css a partir de Views/
     * @return string
     */
    public static function insertCss($path) {
        $pathFile = Functions::base_dir()."/app/Views/".$path;
        
        $file = file_get_contents($pathFile);
        
        return "<style>\n".$file."\n</style>\n";
    }

    /**
     * Insere o js na pagina
     *
     * @param string $path caminha de onde se encontra o .js a oartir de Views/
     * @return string
     */
    public static function insertJs($path) {
        $pathFile = Functions::base_dir()."/app/Views/".$path;
        
        $file = file_get_contents($pathFile);
        
        return "<script>\n".$file."\n</script>\n";
    }
}