<?php

namespace System\Console;

use System\Helpers\Functions;

/**
 * Providencia comandos para o phpeasy-cli
 *
 * @author Paulo Henrique Ramos Ferreira
 */
class Command {

    /**
     * Variavel que contém todos os possiveis comandos
     *
     * @var array
     */
    public $commands;

    /**
     * Adiciona os possiveis comandos para $commands
     * 
     * @return void
     */
    public function __construct() {
        $this->commands = [
            //Comados unicos
            'help' => 'help',

            //Comandos com argumentos e parametros
            'new' => [
                'controller' => 'newController',
                'model' => 'newModel',
                'view' => 'newView',
                'migration' => 'newMigration'
            ],

            //Comandos somente com argumentos
            'cache' => [
                'clean' => 'clean'
            ]
        ];
    }

    /**
     * Lista todos os comandos de $commands na tela
     * 
     * @return string
     */
    public function help() {
        echo "\ntodos os possiveis comandos\n\n";
        foreach ($this->commands as $key => $value) {
            echo "  -" . $key . "\n";
        }
    }

    /**
     * Cria um novo controller em app/Controllers
     *
     * @param string $name
     * @return string
     */
    public function newController($name) {
        if (!$name) {
            echo "Cria um novo controller";
            exit();
        }
        
        $controller = "<?php\n\nnamespace App\Controllers;\n\nuse System\Controllers\Controller;\n\nclass ".ucfirst(strtolower($name))."Controller extends Controller {\n}";
        
        if (file_exists(Functions::base_dir()."/app/Controllers/".ucfirst(strtolower($name))."Controller.php")) {
            echo "Controller já existe!";
            exit();
        }
        
        file_put_contents(Functions::base_dir()."/app/Controllers/".ucfirst(strtolower($name))."Controller.php", $controller);
        echo "Controller criado com sucesso!";
    }

    /**
     * Cria um novo model em app/Models
     *
     * @param string $name
     * @return string
     */
    public function newModel($name) {
        if (!$name) {
            echo "Cria uma nova model";
            exit();
        }
        
        $model = "<?php\n\nnamespace App\Models;\n\nuse System\Database\Model;\n\nclass ".ucfirst(strtolower($name))." extends Model {\n}";
        
        if (file_exists(Functions::base_dir()."/app/Models/".ucfirst(strtolower($name)).".php")) {
            echo "Model já existe!";
            exit();
        }
        
        file_put_contents(Functions::base_dir()."/app/Models/".ucfirst(strtolower($name)).".php", $model);
        echo "Model criada com sucesso!";
    }

    /**
     * Cria uma nova view e seus arquivos .js e .css em app/Views
     *
     * @param string $name
     * @return string
     */
    public function newView($name) {
        if(!$name) {
            echo "Cria uma nova view";
            exit();
        }
        
        if(file_exists(Functions::base_dir()."/app/Views/".strtolower($name))) {
            echo "Pasta da view já criada!";
            exit();
        }
        
        mkdir(Functions::base_dir()."/app/Views/".strtolower($name));
        
        file_put_contents(Functions::base_dir()."/app/Views/".strtolower($name)."/".strtolower($name).".php", "");
        file_put_contents(Functions::base_dir()."/app/Views/".strtolower($name)."/".strtolower($name).".js", "");
        file_put_contents(Functions::base_dir()."/app/Views/".strtolower($name)."/".strtolower($name).".css", "");
        
        echo "Arquivos da view criados com sucesso!";
    }

    /**
     * Cria uma nova migration [necessita terminar]
     *
     * @param string $name
     * @return string
     */
    public function newMigration($name) {
        if(!$name) {
            echo "Cria uma nova migration";
            exit();
        }

        echo "Escolha o tipo de migration database(d) ou table(t): ";

        $type = substr(trim(fgets(STDIN)), 0, 1);

        switch ($type) {
            case 'D':
            case 'd':
                if(file_exists(Functions::base_dir()."/migrations/create_database_".strtolower($name).".sql")) {
                    echo "Migration para database já criada!";
                    exit();
                }
                file_put_contents(Functions::base_dir()."/migrations/create_database_".strtolower($name).".sql", "#dados referentes a criação do banco de dados");
                echo "Migration criada com sucesso";
                break;

            case 'T':
            case 't':
                if(file_exists(Functions::base_dir()."/migrations/create_table_".strtolower($name).".sql")) {
                    echo "Migration para tabela já criada!";
                    exit();
                }
                file_put_contents(Functions::base_dir()."/migrations/create_table_".strtolower($name).".sql", "#dados referentes a criação da tabela");
                echo "Migration criada com sucesso";
                break;
            
            default:
                echo "Escolha uma das opções validas 'd' ou 't'";
                break;
        }
    }

    /**
     * Apaga os arquivos de cache da pasta cache/
     *
     * @return void
     */
    public function clean() {
        echo "Tem certeza de apagar todos os cache? [S/N] ";
        $value = substr(trim(fgets(STDIN)), 0, 1);
        
        switch ($value) {            
            case "s":
            case "S":
                $files = scandir(Functions::base_dir()."/cache/views");
                $total = count($files) - 2;
                foreach ($files as $file) {
                    if($file != "." && $file != "..") {
                        echo "Excluindo: $file\n";
                        unlink(Functions::base_dir()."/cache/views/".$file);
                    }
                }
                echo "Excluido um total de $total arquivos\n";
                break;

            default:
                break;
        }
    }
}