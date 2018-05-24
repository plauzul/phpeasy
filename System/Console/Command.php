<?php

namespace System\Console;

use System\Helpers\Functions;
use System\Database\Connection;

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
                'migration' => 'newMigration',
                'middleware' => 'newMiddleware'
            ],

            //Comandos somente com argumentos
            'cache' => [
                'clean' => 'clean'
            ],
            'run' => [
                'migrations' => 'runMigration'
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
        if(!$name) {
            echo "Cria um novo controller";
            exit();
        }
        
        $controller = "<?php\n\nnamespace App\Controllers;\n\nuse System\Controllers\Controller;\n\nclass ".ucfirst(strtolower($name))."Controller extends Controller {\n}";
        
        if(file_exists(Functions::base_dir()."/app/Controllers/".ucfirst(strtolower($name))."Controller.php")) {
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
        if(!$name) {
            echo "Cria uma nova model";
            exit();
        }
        
        $model = "<?php\n\nnamespace App\Models;\n\nuse System\Database\Model;\n\nclass ".ucfirst(strtolower($name))." extends Model {\n}";
        
        if(file_exists(Functions::base_dir()."/app/Models/".ucfirst(strtolower($name)).".php")) {
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
     * Cria uma nova migration
     *
     * @param string $name
     * @return string
     */
    public function newMigration($name) {
        if(!$name) {
            echo "Cria uma nova migration";
            exit();
        }

        $file = Functions::base_dir()."/migrations/".date("Y_m_d_H_i_s")."_".str_replace("_", "", strtolower($name)).".sql";

        if(file_exists($file)) {
            echo "Migration já criada!";
            exit();
        }

        file_put_contents($file, "");
        echo "Migration criada com sucesso!";
    }

    /**
     * Cria um novo middleware
     * 
     * @param string $name
     * @return string
     */
    public function newMiddleware($name) {
        if(!$name) {
            echo "Cria um novo middleware";
            exit();
        }

        $middleware = "<?php\n\nnamespace App\Middleware;\n\nclass ".ucfirst(strtolower($name))."middleware {\n}";

        if(file_exists(Functions::base_dir()."/app/Middleware/".ucfirst(strtolower($name))."Middleware.php")) {
            echo "Middleware já existe!";
            exit();
        }

        file_put_contents(Functions::base_dir()."/app/Middleware/".ucfirst(strtolower($name))."Middleware.php", $middleware);
        echo "Middleware criado com sucesso!";
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
                    if($file[0] != ".") {
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

    /**
     * Executa todas as migrations criada
     *
     * @param string $name
     * @return string
     */
    public function runMigration() {
        $dir = Functions::base_dir()."/migrations";

        $files = scandir($dir);

        sort($files);

        $db = Connection::getInstance();

        foreach($files as $file) {
            if($file[0] != ".") {
                $stmt = $db->prepare(file_get_contents($dir."/".$file));
                $stmt->execute();
            }
        }
    }
}