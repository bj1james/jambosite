<?php
require __DIR__ . '/bootstrap.php';

try {
  $pdo->exec("
    CREATE TABLE IF NOT EXISTS contact_messages (
      id INT AUTO_INCREMENT PRIMARY KEY,
      first_name VARCHAR(100) NOT NULL,
      last_name  VARCHAR(100) NOT NULL,
      email      VARCHAR(200) NOT NULL,
      phone      VARCHAR(30)  NULL,
      message    TEXT         NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ");
  echo "Tabla contact_messages OK";
} catch (Exception $e) {
  http_response_code(500);
  echo "Error migración: " . htmlspecialchars($e->getMessage());
}