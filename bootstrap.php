<?php
/**
 * BOOTSTRAP JAMBSITE
 * - Carga configuración
 * - Inicia sesión (guard)
 * - Conecta a MySQL vía PDO
 * - Helpers globales
 */

/* 1) Sesión */
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

/* 2) Config */
$configPath = __DIR__ . '/config.php';
if (!is_file($configPath)) { die('No se encontró config.php'); }
$config = require $configPath;

/* 3) Hora + manejo de errores (log en archivo, no en pantalla) */
if (!empty($config['app']['timezone'])) {
  date_default_timezone_set($config['app']['timezone']);
}
$logsDir = __DIR__ . '/storage/logs';
if (!is_dir($logsDir)) { @mkdir($logsDir, 0775, true); }
$logFile = $logsDir . '/php-error.log';
if (!empty($config['app']['debug'])) {
  error_reporting(E_ALL); ini_set('display_errors','1'); ini_set('log_errors','1'); ini_set('error_log',$logFile);
} else {
  error_reporting(E_ALL); ini_set('display_errors','0'); ini_set('log_errors','1'); ini_set('error_log',$logFile);
}

/* 4) Conexión PDO */
$driver = strtolower($config['db']['driver'] ?? 'mysql');
if ($driver !== 'mysql') { die('Error de conexión a la base de datos: Driver no soportado. Usa MySQL en config.php'); }
if (!extension_loaded('pdo_mysql')) { die('Extensión pdo_mysql no cargada. Actívala en php.ini y reinicia Apache.'); }

$host    = $config['db']['host']    ?? '127.0.0.1';
$port    = (int)($config['db']['port'] ?? 3306);
$name    = $config['db']['name']    ?? 'jambo_site';
$user    = $config['db']['user']    ?? 'root';
$pass    = $config['db']['pass']    ?? '';
$charset = $config['db']['charset'] ?? 'utf8mb4';

$dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";
try {
  $pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  ]);
} catch (Throwable $e) {
  if (!empty($config['app']['debug'])) { die('Error de conexión PDO: ' . $e->getMessage()); }
  die('Error de conexión a la base de datos.');
}

/* 5) Helpers */
if (!function_exists('base_path')) {
  function base_path(): string {
    $dir = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
    if ($dir === '/' || $dir === '\\') return '';
    return $dir;
  }
}
if (!function_exists('e')) {
  function e(?string $v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('view')) {
  function view(string $path, array $data = []): void {
    extract($data, EXTR_SKIP);
    require __DIR__ . '/views/' . $path . '.php';
  }
}
if (!function_exists('redirect')) {
  function redirect(string $to): void {
    if (!preg_match('#^https?://#i', $to)) {
      $to = rtrim(base_path(), '/') . '/' . ltrim($to, '/');
    }
    header('Location: ' . $to); exit;
  }
}
if (!function_exists('require_admin')) {
  function require_admin(): void {
    global $config;
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    $key = $config['admin']['session_key'] ?? 'admin_user_id';
    if (empty($_SESSION[$key])) redirect('/admin/login');
  }
}
if (!function_exists('handle_upload')) {
  function handle_upload(string $field, array $allowExt=['jpg','jpeg','png','webp','gif','svg','pdf']): ?string {
    if (empty($_FILES[$field]) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return null;
    $f = $_FILES[$field];
    if (($f['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) throw new RuntimeException('Error subiendo archivo: '.(int)$f['error']);
    $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
    if ($ext && !in_array($ext,$allowExt,true)) throw new RuntimeException('Extensión no permitida: '.$ext);

    $y=date('Y'); $m=date('m'); $dir=__DIR__."/public/uploads/{$y}/{$m}";
    if (!is_dir($dir) && !mkdir($dir,0775,true) && !is_dir($dir)) throw new RuntimeException('No se pudo crear el directorio de subida.');

    $base = pathinfo($f['name'], PATHINFO_FILENAME);
    $base = preg_replace('/[^a-z0-9_\-]+/i','_',$base) ?: 'file';
    $name = $base.'_'.uniqid('',true).($ext?".{$ext}":'');
    $dest = "{$dir}/{$name}";
    if (!move_uploaded_file($f['tmp_name'],$dest)) throw new RuntimeException('No se pudo mover el archivo subido.');
    return str_replace('\\','/',"public/uploads/{$y}/{$m}/{$name}");
  }
}
if (!function_exists('slugify')) {
  function slugify(string $text): string {
    if (function_exists('iconv')) { $t=@iconv('UTF-8','ASCII//TRANSLIT//IGNORE',$text); if ($t!==false) $text=$t; }
    $text=preg_replace('~[^\\pL\\d]+~u','-',$text); $text=trim($text,'-'); $text=strtolower($text);
    $text=preg_replace('~[^-a-z0-9]+~','',$text); return $text ?: 'item';
  }
}

/* 6) Helpers de URL para imágenes (arregla error en Home/Sobre) */
if (!function_exists('is_absolute_url')) {
  function is_absolute_url(?string $url): bool {
    if (!$url) return false;
    return (bool)preg_match('#^(?:https?:)?//#i',$url) || strncmp($url,'data:',5)===0;
  }
}
if (!function_exists('abs_url')) {
  function abs_url(?string $path): string {
    if (!$path) return '';
    if (is_absolute_url($path)) return $path;
    return rtrim(base_path(),'/').'/'.ltrim($path,'/');
  }
}