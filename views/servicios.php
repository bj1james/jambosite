<?php require __DIR__.'/partials/head.php'; ?>
<?php require __DIR__.'/partials/header.php'; ?>

<!-- ===================== HERO MINIMALISTA SERVICIOS ===================== -->
<section class="services-hero">
  <div class="container text-center">
    <h1 class="services-title">Nuestros Servicios</h1>
    <p class="services-sub">Soluciones profesionales diseñadas para proteger, optimizar y transformar tu entorno tecnológico.</p>
  </div>

  <!-- Línea decorativa minimal -->
  <div class="services-divider"></div>

  <!-- Onda suave minimalista -->
  <div class="services-wave"></div>
</section>

<section class="py-5">
  <div class="container">
    <?php include __DIR__ . '/servicios_cards.php'; ?>
  </div>
</section>

<?php require __DIR__.'/partials/footer.php'; ?>
