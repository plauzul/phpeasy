<?php
session_start();

require_once "../vendor/autoload.php";

$hooks = new System\Init\Hooks();

$routes = new System\Web\Routes();