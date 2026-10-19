<?php
// test_login.php
require __DIR__.'/bootstrap.php';   // <— Debe crear $pdo y base_path()

$u = 'admin';
$p = 'admin1234'; // usa aquí exactamente la clave que actualizaste (si dejaste admin1234, mantenla)

$stmt = $pdo->prepare("SELECT DATABASE() AS db");
$stmt->execute(); $dbRow = $stmt->fetch();

$stmt = $pdo->prepare("SELECT username, is_active, password_hash FROM users WHERE username=? LIMIT 1");
$stmt->execute([$u]);
$row = $stmt->fetch();

$result = [
  'bootstrap_path' => realpath(__DIR__.'/bootstrap.php'),
  'db'             => $dbRow ? $dbRow['db'] : '(desconocida)',
  'rowFound'       => (bool)$row,
  'active'         => $row ? (int)$row['is_active'] : null,
  'hash_len'       => $row ? strlen($row['password_hash']) : null,
  'verify'         => $row ? password_verify($p, $row['password_hash']) : null,
];
header('Content-Type: text/plain; charset=utf-8');
var_export($result);