<?php

return [
  [
      'route' => '/',
      'controller' => 'IndexController',
      'action' => 'index',
      'middleware' => 'VerifyLoginMiddleware',
      'method' => ['post','get']
  ]
];