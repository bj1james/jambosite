<?php
// Bullets de "Sobre Jambo" — versión PRO con estructura uniforme.
// - Lee desde DB (about_bullets) si existe; si no, usa fallback.
// - Estructura lista para estilizar con .bullet-pro .check (ver CSS de la sección).

global $pdo;

$bullets = [];
try {
  $stmt = $pdo->query("SELECT text FROM about_bullets ORDER BY position ASC, id ASC");
  $bullets = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (Exception $e) {
  $bullets = [];
}

if (empty($bullets)) {
  $bullets = [
    'Experiencia real en soluciones de infraestructura y software.',
    'Implementaciones rápidas y confiables para PyMEs.',
    'Acompañamiento postventa y soporte continuo.'
  ];
}
?>
<ul class="list-unstyled mb-3">
  <?php foreach ($bullets as $txt): ?>
    <li class="bullet-pro">
      <span class="check">✓</span>
      <span><?= e($txt) ?></span>
    </li>
  <?php endforeach; ?>
</ul>