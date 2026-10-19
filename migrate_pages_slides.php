<?php
require __DIR__ . '/bootstrap.php';

/*
 * Crea tablas:
 * - pages(slug,title,content)
 * - home_slides(id,image_url,title,caption,position,created_at,updated_at)
 * - page_slides(id,page_slug,image_url,title,caption,position,created_at,updated_at)
 * y agrega keys en settings: home_title, home_subtitle
 */

try {
  // pages
  $pdo->exec("
    CREATE TABLE IF NOT EXISTS pages (
      id INT AUTO_INCREMENT PRIMARY KEY,
      slug VARCHAR(64) UNIQUE NOT NULL,
      title VARCHAR(200) NOT NULL,
      content MEDIUMTEXT NULL,
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ");

  // home_slides
  $pdo->exec("
    CREATE TABLE IF NOT EXISTS home_slides (
      id INT AUTO_INCREMENT PRIMARY KEY,
      image_url VARCHAR(500) NOT NULL,
      title VARCHAR(200) NULL,
      caption VARCHAR(500) NULL,
      position INT DEFAULT 0,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ");

  // page_slides (para carrusel de páginas como 'sobre')
  $pdo->exec("
    CREATE TABLE IF NOT EXISTS page_slides (
      id INT AUTO_INCREMENT PRIMARY KEY,
      page_slug VARCHAR(64) NOT NULL,
      image_url VARCHAR(500) NOT NULL,
      title VARCHAR(200) NULL,
      caption VARCHAR(500) NULL,
      position INT DEFAULT 0,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      INDEX (page_slug)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ");

  // Seeds: settings home_title / home_subtitle
  $pairs = [
    ['home_title', 'Consultoría y servicios de TI'],
    ['home_subtitle', 'Impulsamos tu negocio con soluciones tecnológicas confiables y a medida.'],
  ];
  foreach ($pairs as $kv) {
    $stmt = $pdo->prepare("INSERT IGNORE INTO settings(`key`,`value`) VALUES(?,?)");
    $stmt->execute($kv);
  }

  // Seed página 'sobre' si no existe
  $stmt = $pdo->prepare("SELECT COUNT(*) c FROM pages WHERE slug = ?");
  $stmt->execute(['sobre']);
  if ((int)$stmt->fetch()['c'] === 0) {
    $stmtIns = $pdo->prepare("INSERT INTO pages(slug,title,content) VALUES(?,?,?)");
    $stmtIns->execute([
      'sobre',
      'Sobre Jambo',
      "Escribe aquí la historia de Jambo, misión, visión y valores.\n\nEste contenido es editable desde el Admin."
    ]);
  }

  // Slide de ejemplo para Home (solo si no hay ninguno)
  $has = $pdo->query("SELECT COUNT(*) c FROM home_slides")->fetch()['c'] ?? 0;
  if (!$has) {
    $pdo->prepare("INSERT INTO home_slides(image_url,title,caption,position) VALUES (?,?,?,?)")
        ->execute([
          'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=1200&auto=format&fit=crop',
          'Tecnología a tu medida',
          'Soluciones confiables',
          1
        ]);
  }

  // Slide de ejemplo para 'sobre' (opcional)
  $hasSobre = $pdo->prepare("SELECT COUNT(*) c FROM page_slides WHERE page_slug = ?");
  $hasSobre->execute(['sobre']);
  if (!$hasSobre->fetch()['c']) {
    $pdo->prepare("INSERT INTO page_slides(page_slug,image_url,title,caption,position) VALUES (?,?,?,?,?)")
        ->execute([
          'sobre',
          'https://images.unsplash.com/photo-1529336953121-ad5a0d43d0d2?q=80&w=1200&auto=format&fit=crop',
          'Nuestro equipo',
          'Compromiso y experiencia',
          1
        ]);
  }

  echo "Migración OK. Ya puedes ir a /admin para editar Home y Sobre.";
} catch (Exception $e) {
  http_response_code(500);
  echo "Error en migración: " . e($e->getMessage());
}