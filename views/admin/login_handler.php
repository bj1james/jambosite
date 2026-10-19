<?php
// views/admin/login_handler.php
require __DIR__ . '/../../bootstrap.php';  // carga $pdo, helpers y $config

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  redirect('/admin/login');
}

$username = trim($_POST['username'] ?? '');
$password = (string)($_POST['password'] ?? '');

// Busca usuario
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
$stmt->execute([$username]);
$user = $stmt->fetch();

$ok = false;
if ($user && (int)$user['is_active'] === 1) {
  // 1) TEMP: comparar texto plano
  if (array_key_exists('password', $user) && $user['password'] !== null) {
    $ok = hash_equals((string)$user['password'], $password);
  }
  // 2) Back-compat con hash (por si ya lo tenías)
  if (!$ok && !empty($user['password_hash']) && strlen($user['password_hash']) >= 20) {
    $ok = password_verify($password, $user['password_hash']);
  }
}

if (!$ok) {
  view('admin/login', ['error' => 'Credenciales inválidas']); exit;
}

// Sesión (misma clave que require_admin)
$key = $config['admin']['session_key'] ?? 'admin_user_id';
$_SESSION[$key] = (int)$user['id'];

// (Opcional) datos para cabecera del admin
$_SESSION['user'] = [
  'id'           => (int)$user['id'],
  'username'     => $user['username'],
  'display_name' => $user['display_name'],
  'email'        => $user['email'],
  'role'         => $user['role'],
];

// Marca último login
$pdo->prepare("UPDATE users SET last_login_at = NOW() WHERE id=?")->execute([(int)$user['id']]);

redirect('/admin');