<?php
return [
    "layout" => "layouts.template",
   // "layout" => "entrust-gui::app",
    "route-prefix" => "usuarios",
    "pagination" => [
        "users" => 5,
        "roles" => 5,
        "permissions" => 5,
    ],
    "middleware" => ['web', 'entrust-gui.admin'],
    "unauthorized-url" => '/login',
    "middleware-role" => 'admin',
    "confirmable" => false,
    "users" => [
      'fieldSearchable' => [],
    ],
];
