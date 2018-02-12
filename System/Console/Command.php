<?php

namespace System\Console;

use System\Helpers\Functions;
use System\Database\Migrations;

/**
 * Providencia comandos para o phpeasy-cli
 *
 * @author Paulo Henrique Ramos Ferreira
 */
class Command {

    public $commands;

    public function __construct() {
        $this->commands = [
            //Comados unicos
            'help' => 'help',
            'serve' => 'serve',

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

    public function help() {
        echo "\ntodos os possiveis comandos\n\n";
        foreach ($this->commands as $key => $value) {
            echo "  -" . $key . "\n";
        }
    }

    public function serve() {
        system("php -S localhost:8000");
    }

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

    public function clean() {
        echo "Tem certeza de apagar todos os cache? [S/N] ";
        $value = substr(trim(fgets(STDIN)), 0, 1);
        
        switch ($value) {            
            case "s":
            case "S":
                $directory = dir(Functions::base_dir()."/cache/views");
                $i = 0;
                while ($arquivo = $directory->read()) {
                    $i++;
                    if($i > 2) {
                        unlink(Functions::base_dir()."/cache/views/".$arquivo);
                    }
                }
                $directory->close();
                break;
            
            default:
                break;
        }
    }
}