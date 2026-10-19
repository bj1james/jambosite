<?php require __DIR__.'/partials/head.php'; ?>
<?php require __DIR__.'/partials/header.php'; ?>

<?php
  // Datos del servicio
  $title   = trim((string)($s['title']   ?? 'Servicio'));
  $slug    = trim((string)($s['slug']    ?? ''));
  $excerpt = trim((string)($s['excerpt'] ?? ''));
  $content = (string)($s['content'] ?? '');
  $imgUrl  = trim((string)($s['image_url'] ?? ''));

  // Normaliza imagen a absoluta si viene relativa
  if ($imgUrl !== '') {
    if (function_exists('is_absolute_url')) {
      if (!is_absolute_url($imgUrl)) $imgUrl = rtrim(base_path(), '/') . '/' . ltrim($imgUrl, '/');
    } else {
      if (!preg_match('#^https?://#i', $imgUrl)) $imgUrl = rtrim(base_path(), '/') . '/' . ltrim($imgUrl, '/');
    }
  }

  // URLs auxiliares
  $homeHref    = rtrim(base_path(), '/') . '/';
  $listHref    = rtrim(base_path(), '/') . '/servicios';
  $contactHref = rtrim(base_path(), '/') . '/#contactanos';
  $selfHref    = rtrim(base_path(), '/') . '/servicio/' . rawurlencode($slug);

  // Render de contenido:
  // - Si no trae HTML, escapamos y convertimos saltos de línea a <br>.
  // - Si trae HTML (admin lo escribió), lo dejamos pasar (confianza en admin).
  $hasHtml   = (bool)preg_match('/<\s*\w[^>]*>/', $content);
  $bodyHtml  = $hasHtml ? $content : nl2br(e($content));
?>

<!-- ============================ ENCABEZADO / HERO ============================ -->
<section class="svc-hero">
  <div class="container">

    <!-- Breadcrumb -->
    <nav class="svc-breadcrumb" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="text-decoration-none" href="<?= $homeHref ?>">Inicio</a></li>
        <li class="breadcrumb-item"><a class="text-decoration-none" href="<?= $listHref ?>">Servicios</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= e($title) ?></li>
      </ol>
    </nav>

    <h1 class="svc-title display-6"><?= e($title) ?></h1>
    <?php if ($excerpt !== ''): ?>
      <p class="svc-subtitle lead mb-0"><?= e($excerpt) ?></p>
    <?php endif; ?>
  </div>
</section>

<!-- ============================ CUERPO ============================ -->
<section class="py-4 py-md-5">
  <div class="container">
    <div class="row g-4 g-lg-5">
      
      <!-- Columna principal -->
      <div class="col-lg-8">

        <?php if ($imgUrl !== ''): ?>
          <figure class="svc-cover card shadow-sm">
            <img src="<?= e($imgUrl) ?>" alt="<?= e($title) ?>" class="w-100 svc-cover-img">
          </figure>
        <?php endif; ?>

        <article class="prose card shadow-sm">
          <div class="card-body">
            <?= $bodyHtml ?>
          </div>
        </article>

        <div class="d-flex flex-wrap gap-2 mt-3">
          <a href="<?= $listHref ?>" class="btn btn-outline-secondary">← Volver a servicios</a>
          <button type="button" class="btn btn-outline-primary" id="btnCopyLink">Copiar enlace</button>
        </div>
      </div>

      <!-- Sidebar / CTA -->
      <aside class="col-lg-4">
        <div class="svc-aside card sticky-card">
          <div class="card-body">
            <h5 class="mb-2">¿Deseas más información?</h5>
            <p class="text-muted mb-3">Contáctanos y agenda una evaluación gratuita.</p>
            <a href="<?= $contactHref ?>" class="btn btn-accent w-100 mb-3">Solicitar cotización</a>

            <ul class="list-unstyled small mb-0">
              <li class="d-flex align-items-start gap-2 mb-2">
                <span class="badge-soft bg-primary-subtle text-primary">✓</span>
                <span>Asesoría especializada</span>
              </li>
              <li class="d-flex align-items-start gap-2 mb-2">
                <span class="badge-soft bg-primary-subtle text-primary">✓</span>
                <span>Implementación rápida</span>
              </li>
              <li class="d-flex align-items-start gap-2">
                <span class="badge-soft bg-primary-subtle text-primary">✓</span>
                <span>Garantía y soporte</span>
              </li>
            </ul>
          </div>
        </div>

        <!-- Compartir -->
        <div class="card mt-3">
          <div class="card-body">
            <h6 class="mb-2">Compartir</h6>
            <div class="d-flex flex-wrap gap-2">
              <a class="btn btn-light border" target="_blank" rel="noopener"
                 href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($selfHref) ?>">Facebook</a>

              <a class="btn btn-light border" target="_blank" rel="noopener"
                 href="https://twitter.com/intent/tweet?url=<?= urlencode($selfHref) ?>&text=<?= urlencode($title) ?>">X / Twitter</a>

              <a class="btn btn-light border" target="_blank" rel="noopener"
                 href="https://wa.me/?text=<?= urlencode($title.' - '.$selfHref) ?>">WhatsApp</a>
            </div>
          </div>
        </div>
      </aside>

    </div>
  </div>
</section>

<script>
  // Copiar enlace al portapapeles
  (function(){
    const btn = document.getElementById('btnCopyLink');
    if (!btn) return;
    btn.addEventListener('click', async () => {
      try {
        await navigator.clipboard.writeText('<?= $selfHref ?>');
        const old = btn.textContent;
        btn.textContent = '¡Enlace copiado!';
        setTimeout(() => { btn.textContent = old; }, 2000);
      } catch (e) {
        alert('No se pudo copiar el enlace');
      }
    });
  })();
</script>

<?php require __DIR__.'/partials/footer.php'; ?>