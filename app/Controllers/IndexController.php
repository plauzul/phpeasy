<?php

namespace App\Controllers;

use System\Controllers\Controller;

class IndexController extends Controller {

    public function index() {
        return $this->renderWithTemplate("index/index.php", "templates/index.template.php");
    }
}