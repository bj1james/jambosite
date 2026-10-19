<?php
require __DIR__ . '/bootstrap.php';

try {
  // Crear tablas si no existen
  $pdo->exec("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(64) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

  $pdo->exec("CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(64) UNIQUE NOT NULL,
    `value` TEXT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

  $pdo->exec("CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(220) UNIQUE NOT NULL,
    excerpt TEXT NULL,
    content MEDIUMTEXT NULL,
    image_url VARCHAR(500) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

  // Usuario admin por defecto
  $exists = $pdo->query("SELECT COUNT(*) c FROM users")->fetch()['c'] ?? 0;
  if (!$exists) {
    $stmt = $pdo->prepare("INSERT INTO users(username, password_hash) VALUES(?, ?)");
    $stmt->execute(['admin', password_hash('123456', PASSWORD_DEFAULT)]);
  }

  // Settings por defecto
  $defaults = [
    ['site_name','JAMBO'],
    ['logo_url',''],
    ['brand_primary','#111111'],
    ['brand_accent','#0A84FF']
  ];
  foreach ($defaults as $kv) {
    $stmt = $pdo->prepare("INSERT IGNORE INTO settings(`key`,`value`) VALUES(?,?)");
    $stmt->execute($kv);
  }

  // Seed de servicios
  $count = $pdo->query("SELECT COUNT(*) c FROM services")->fetch()['c'] ?? 0;
  if (!$count) {
    $services = [
      ['INSTALACION DE CAMARA DE SEGURIDAD', 'Soluciones de CCTV e IP, con grabación y monitoreo.', 'Describe aquí el detalle del servicio: tipos de cámaras, NVR/DVR, cableado estructurado, monitoreo remoto, mantenimiento preventivo y correctivo.', 'https://picsum.photos/seed/cctv/800/450'],
      ['REPARACION DE EQUIPOS DE COMPUTO', 'Diagnóstico y reparación de PCs y laptops.', 'Detalle: cambio de piezas, limpieza profunda, reinstalación de SO, recuperación de datos, actualización de hardware.', 'https://picsum.photos/seed/pcfix/800/450'],
      ['DISEÑO WEB PARA TU NEGOCIO', 'Sitios modernos, rápidos y administrables.', 'Detalle: diseño responsive, SEO básico, integración con WhatsApp y formularios, hosting y dominio.', 'https://picsum.photos/seed/webdesign/800/450'],
    ];
    $stmt = $pdo->prepare("INSERT INTO services(title, slug, excerpt, content, image_url) VALUES (?,?,?,?,?)");
    foreach ($services as $s) {
      [$t,$ex,$c,$img] = $s;
      $stmt->execute([$t, slugify($t), $ex, $c, $img]);
    }
  }

  echo "Base de datos lista. Admin: /admin/login (admin / 123456).";
} catch (Exception $e) {
  http_response_code(500);
  echo 'Error en init_db: ' . e($e->getMessage());
}
