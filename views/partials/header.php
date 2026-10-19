<?php
// views/partials/header.php
$siteName = $set['site_name'] ?? 'JAMBO';

/* Ruta actual (para marcar activo) respetando subcarpeta /jambosite */
$uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$base    = rtrim(base_path(), '/');
if ($base !== '' && strpos($uriPath, $base) === 0) {
  $uriPath = substr($uriPath, strlen($base));
}
$uriPath = rtrim($uriPath, '/') ?: '/';
?>
<!-- HEADER AUTOCONTENIDO (sin CSS externo) -->
<header role="banner"
        style="position:sticky;top:0;z-index:1030;background:#111826;color:#E7EDF5;
               border-bottom:1px solid rgba(255,255,255,.10);box-shadow:0 6px 16px rgba(0,0,0,.08);
               font-family:system-ui,-apple-system,'Segoe UI',Roboto,Arial,sans-serif;">
  <style>
    .hb-wrap{max-width:1200px;margin:0 auto;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:12px}
    .hb-brand{display:inline-flex;align-items:center;gap:10px;text-decoration:none;color:inherit}
    .hb-brand__name{font-weight:900;letter-spacing:.2px;color:#E7EDF5}
    .hb-nav{display:flex;align-items:center;gap:20px}
    .hb-link{display:inline-flex;align-items:center;color:#B8C4D2;text-decoration:none;font-weight:700;padding:8px 10px;border-radius:8px;
             transition:color .15s ease, background .15s ease, box-shadow .15s ease}
    .hb-link:hover{color:#E7EDF5;background:rgba(255,255,255,.06)}
    .hb-link.is-active{color:#fff;background:rgba(10,132,255,.18);box-shadow:inset 0 0 0 1px rgba(10,132,255,.25)}
    @media (max-width:992px){.hb-wrap{padding:10px 14px}.hb-nav{gap:14px}.hb-brand__name{font-size:1.05rem}}
    /* Forzar horizontalidad ante CSS global agresivo */
    header[role="banner"] .hb-nav{display:flex !important}
    header[role="banner"] .hb-link{display:inline-flex !important}
  </style>

  <div class="hb-wrap">
    <a class="hb-brand" href="<?= $base !== '' ? $base.'/' : '/' ?>" aria-label="Ir al inicio">
      <span class="hb-brand__name"><?= e($siteName) ?></span>
    </a>

    <nav class="hb-nav" aria-label="Navegación principal">
      <a class="hb-link <?= $uriPath==='/' ? 'is-active' : '' ?>"
         href="<?= $base !== '' ? $base.'/' : '/' ?>">Inicio</a>
      <a class="hb-link <?= ($uriPath==='/sobre-jambo' || $uriPath==='/sobre') ? 'is-active' : '' ?>"
         href="<?= $base ?>/sobre-jambo">Nosotros</a>
      <a class="hb-link <?= $uriPath==='/servicios' ? 'is-active' : '' ?>"
         href="<?= $base ?>/servicios">Servicios</a>
      <a class="hb-link <?= $uriPath==='/contacto' ? 'is-active' : '' ?>"
         href="<?= $base ?>/contacto">Contáctanos</a>
    </nav>
  </div>
</header>