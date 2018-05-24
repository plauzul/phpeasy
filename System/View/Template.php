<?php

namespace System\View;

/**
 * Prove a utilização dos template
 * 
 * Metodos que retorne views com template se utiliza dessa clase, provendo tags para diminuição do codigo php
 *
 * @author Paulo Henrique Ramos Ferreira
 */
class Template {

    /**
     * Armazena o caminho da view a apartir de Views/
     * 
     * @var string
     */
    private $viewName;
    /**
     * Armazena o caminho do template a apartir de Views/
     * 
     * @var string
     */
    private $templateName;
    /**
     * ID unico gerado a partir de cada request
     * 
     * @var string
     */
    private $uniqid;
    /**
     * Regra RegEXP para obter tudo o que esta detro das @sections da views
     * 
     * @var string
     */
    private $patternView = '/@section\(["\'](\w+)["\']\)(.*?)@endsection/';
    /**
     * RegraEXP para obter os nome das @namesection
     * 
     * @var string
     */
    private $patternTemplate = '/@namesection\(["\'](.*)["\']\)/';
    /**
     * Tags phpeasy introduzidas na view que é aterada para seu respectivo valor
     * 
     * @var array
     */
    private $tags;

    /**
     * Cria o objeto a partir dos parametros passado no construtor, e adiciona os valores iniciais aos atributos
     * 
     * @param string $viewName caminho com o nome da view e extensão a partir de app/Views/
     * @param string $templateName caminho com o nome do template e extensão a partir de app/Views/
     * @return void
     */
    public function __construct($viewName, $templateName) {
        $this->viewName = $viewName;
        $this->templateName = $templateName;
        $this->uniqid = md5(uniqid());
        $this->tags = [
            "#_#_" => "\n",
            "{{{" => "<?=",
            "}}}" => "?>",
            "@continue" => ": ?>",

            //tags if
            "@if" => "<?php if",
            "@else" => "<?php else: ?>",
            "@elseif" => "<?php elseif",
            "@#ifend" => "<?php endif; ?>",

            //tags for
            "@for" => "<?php for",
            "@#forend" => "<?php endfor; ?>",

            //tags foreach
            "@foreach" => "<?php foreach",
            "@#foreachend" => "<?php endforeach; ?>",

            //tags while
            "@while" => "<?php while",
            "@#whileend" => "<?php endwhile; ?>",
        ];
        $this->createFiles();
    }

    /**
     * Crio os arqquivo e adiciono no cache a partir do id unico criado no __construct
     * 
     * @return void
     * 
     */
    private function createFiles() {
        file_put_contents("../cache/views/".$this->uniqid.".php", file_get_contents("../app/Views/".$this->templateName));
        $this->changeTemplateValuesWithView();
    }

    /**
     * Altero os valores das @namesection a partir da regra patternTemplate, e pego os valores das views
     * que bate com o nome da @namesection com a regra patternView, e coloco a nova view com os novos valores no cache
     * 
     * @return void
     */
    private function changeTemplateValuesWithView() {
        $newTemplate = file_get_contents("../cache/views/".$this->uniqid.".php");
        $view = str_replace(["\n","\r"], '#_#_', file_get_contents("../app/Views/".$this->viewName));

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

    /**
     * Se houver alguma tag phpeasy altero ela e coloco o valor php correspondente ao valor do array
     * 
     * @param $newTemplate valor passado pelo metodo changeTemplateValuesWithView que contem o valor em string do tamplate
     * @return void
     */
    private function alterTagsValue($newTemplate) {
        foreach($this->tags as $key => $value) {
            $newTemplate = str_replace($key, $value, $newTemplate);
        }

        file_put_contents("../cache/views/".$this->uniqid.".php", $newTemplate);
    }

    /**
     * Retorno o caminho da view criada e toda altera que esta no cache
     * 
     * @return string
     */
    public function returnView() {
        return "../cache/views/".$this->uniqid.".php";
    }
}