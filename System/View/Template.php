<?php

namespace System\View;

/**
 * Prove a utilização dos template
 * Metodos que retorne views com template se utiliza dessa clase, provendo tags para diminuição do codigo php
 *
 * @author Paulo Henrique Ramos Ferreira
 */
class Template {

    private $viewName;
    private $templateName;
    private $uniqid;
    private $patternView = '/@section\(["\'](\w+)["\']\)(.*?)@endsection/';
    private $patternTemplate = '/@namesection\(["\'](.*)["\']\)/';
    private $tags;

    public function __construct($viewName, $templateName) {
        $this->viewName = $viewName;
        $this->templateName = $templateName;
        $this->uniqid = md5(uniqid());
        $this->tags = [
            "#_#_" => "\n",
            "{{{" => "<?=",
            "}}}" => "?>",
            "@continue" => ": ?>",

            //tags for
            "@for" => "<?php for",
            "@endfor" => "<?php endfor; ?>",

            //tags foreach
            "@foreach" => "<?php foreach",
            "@endforeach" => "<?php endforeach; ?>",

            //tags while
            "@while" => "<?php while",
            "@endforeach" => "<?php endwhile; ?>",
        ];
        $this->createFiles();
    }

    private function createFiles() {
        file_put_contents("../cache/views/".$this->uniqid.".php", file_get_contents("../app/Views/".$this->templateName));
        $this->changeTemplateValuesWithView();
    }

    private function changeTemplateValuesWithView() {
        $newTemplate = file_get_contents("../cache/views/".$this->uniqid.".php");
        $view = str_replace(["\n","\r"], '#_#_', file_get_contents("../app/views/".$this->viewName));

        preg_match_all($this->patternView, $view, $outputView);
        
        preg_match_all($this->patternTemplate, $newTemplate, $outputTemplate);
        
        foreach($outputTemplate[1] as $keyTemplate => $valueTemplate) {
            foreach($outputView[1] as $keyView => $valueView) {
                if($valueTemplate == $valueView) {
                    $newTemplate = preg_replace('/@namesection\("'.$valueTemplate.'"\)/', $outputView[2][$keyView], $newTemplate);
                }
            }
        }

        $this->alterTagsValue($newTemplate);
    }

    public function alterTagsValue($newTemplate) {
        foreach($this->tags as $key => $value) {
            $newTemplate = str_replace($key, $value, $newTemplate);
        }

        file_put_contents("../cache/views/".$this->uniqid.".php", $newTemplate);
    }

    public function returnView() {
        return "../cache/views/".$this->uniqid.".php";
    }
}