<?php
return [
  'db' => [
    'driver'   => 'mysql',
    'host'     => '127.0.0.1',
    'port'     => 3306,
    'name'     => 'jambo_site',
    'user'     => 'root',
    'pass'     => '',
    'charset'  => 'utf8mb4',
    'collation'=> 'utf8mb4_unicode_ci',
  ],

  'admin' => [
    'session_key' => 'admin_user_id',
  ],

  // Producción: no mostrar warnings en pantalla (se loguean en storage/logs/php-error.log)
  'app' => [
    'debug'    => false,
    'timezone' => 'America/Lima',
  ],
];