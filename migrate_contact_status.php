<?php
require __DIR__ . '/bootstrap.php';

/**
 * Agrega columnas de estado a contact_messages si no existen:
 * - is_read  TINYINT(1) DEFAULT 0
 * - is_saved TINYINT(1) DEFAULT 0
 * - read_at  DATETIME NULL (opcional)
 */
try {
  // Helper para saber si existe una columna
  $colExists = function(PDO $pdo, string $table, string $col): bool {
    $stmt = $pdo->prepare("SHOW COLUMNS FROM `$table` LIKE ?");
    $stmt->execute([$col]);
    return (bool)$stmt->fetch();
  };

  if (!$colExists($pdo, 'contact_messages', 'is_read')) {
    $pdo->exec("ALTER TABLE contact_messages ADD COLUMN is_read TINYINT(1) NOT NULL DEFAULT 0 AFTER message;");
  }
  if (!$colExists($pdo, 'contact_messages', 'is_saved')) {
    $pdo->exec("ALTER TABLE contact_messages ADD COLUMN is_saved TINYINT(1) NOT NULL DEFAULT 0 AFTER is_read;");
  }
  if (!$colExists($pdo, 'contact_messages', 'read_at')) {
    $pdo->exec("ALTER TABLE contact_messages ADD COLUMN read_at DATETIME NULL AFTER is_saved;");
  }

  echo "Migración de estados OK. Columnas is_read, is_saved, read_at listas.";
} catch (Exception $e) {
  http_response_code(500);
  echo "Error en migración de estados: " . htmlspecialchars($e->getMessage());
}