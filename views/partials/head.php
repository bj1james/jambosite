<?php global $config, $settings; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($config['site']['name']) ?></title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- TU CSS (usar base_path para soportar subcarpetas como /jambosite) -->
  <link href="<?= base_path() ?>/public/css/style.css" rel="stylesheet">

  <style>
    :root{
      --brand-primary: <?= e($config['site']['brand_primary']) ?>;
      --brand-accent:  <?= e($config['site']['brand_accent'])  ?>;
    }
    a { color: var(--brand-accent); }
    .btn-primary { background: var(--brand-accent); border-color: var(--brand-accent); }
    .btn-primary:hover { filter: brightness(0.95); }
    .navbar-brand, h1, h2, h3, h4, h5 { color: var(--brand-primary); }
  </style>
</head>
<body>