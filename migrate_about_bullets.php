<?php
require __DIR__ . '/bootstrap.php';

/**
 * Crea la tabla about_bullets:
 * - id, text (VARCHAR 255), position (INT), created_at, updated_at
 */
try {
  $pdo->exec("
    CREATE TABLE IF NOT EXISTS about_bullets (
      id INT AUTO_INCREMENT PRIMARY KEY,
      text VARCHAR(255) NOT NULL,
      position INT NOT NULL DEFAULT 0,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ");
  echo 'Tabla about_bullets lista.';
} catch (Exception $e) {
  http_response_code(500);
  echo 'Error migración: ' . htmlspecialchars($e->getMessage());
}