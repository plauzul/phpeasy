<?php

namespace System\Helpers;

/**
 * Funções utilizaveis em todas as classes
 * Provimento de funções helpers utilizadas em todas as classes
 *
 * @author Paulo Henrique Ramos Ferreira
 */
class Functions {

    public static function base_dir() {
        $pathExplode = explode("\\", __DIR__);
        
        array_splice($pathExplode, - 2);
        
        return $fullPath = str_replace("\\", "/", implode("\\", $pathExplode));
    }

    public static function insertCss($path) {
        $pathFile = Functions::base_dir() . "/App/Views/" . $path;
        
        $file = file_get_contents($pathFile);
        
        return "<style>\n".$file."\n</style>\n";
    }

    public static function insertJs($path) {
        $pathFile = Functions::base_dir()."/App/Views/".$path;
        
        $file = file_get_contents($pathFile);
        
        return "<script>\n".$file."\n</script>\n";
    }
}