<?php require __DIR__.'/partials/head.php'; ?>
<?php require __DIR__.'/partials/header.php'; ?>

<?php
  global $pdo;

  /* ===== Datos “Sobre” ===== */
  $sobre = ['title'=>'Sobre Jambo','content'=>'Somos un equipo que impulsa negocios con tecnología.'];
  try {
    $stmt = $pdo->prepare("SELECT title, content FROM pages WHERE slug = ? LIMIT 1");
    $stmt->execute(['sobre']);
    $tmp = $stmt->fetch();
    if ($tmp) $sobre = $tmp;
  } catch (Exception $e) {}

  /* ===== Slides (galería) ===== */
  $sobreSlides = [];
  try {
    $stmt = $pdo->prepare("SELECT image_url, title, caption FROM page_slides WHERE page_slug='sobre' ORDER BY position ASC, id ASC");
    $stmt->execute();
    $sobreSlides = $stmt->fetchAll();
  } catch (Exception $e) {}

  /* ===== Bullets ===== */
  $bullets = [];
  try {
    $q = $pdo->query("SELECT text FROM about_bullets ORDER BY position ASC, id ASC");
    $bullets = $q->fetchAll(PDO::FETCH_COLUMN);
  } catch (Exception $e) {}
  if (empty($bullets)) {
    $bullets = [
      'Soluciones de TI confiables',
      'Implementaciones rápidas',
      'Soporte real y continuo',
    ];
  }

  /* ===== KPIs ===== */
  $stats = [
    ['num'=>'5+',  'label'=>'Años de experiencia'],
    ['num'=>'35+', 'label'=>'Proyectos entregados'],
    ['num'=>'24/7','label'=>'Soporte'],
  ];

  /* ===== Timeline (card derecha) ===== */
  $timeline = [
    ['year'=>'2019', 'text'=>'Fundación de Jambo con visión tecnológica.'],
    ['year'=>'2021', 'text'=>'Expansión en sistemas de seguridad.'],
    ['year'=>'2023', 'text'=>'Nuevas integraciones TI + IoT.'],
    ['year'=>'2025', 'text'=>'Estandarización y metodologías claras.'],
  ];

  /* ===== Helper para normalizar URLs de imagen ===== */
  function to_abs_url($url) {
    if (!$url) return '';
    if (preg_match('#^(?:https?:)?//#i', $url)) return $url;
    return rtrim(base_path(), '/') . '/' . ltrim($url, '/');
  }
?>

<!-- =================== HERO DE SECCIÓN (sutil y elegante) =================== -->
<section style="
  padding: 64px 0 36px;
  font-family: system-ui,-apple-system,'Segoe UI',Roboto,Arial,sans-serif;
  background:
    radial-gradient(900px 520px at 12% -10%, rgba(10,132,255,.10) 0, rgba(10,132,255,0) 60%),
    radial-gradient(800px 420px at 100% -15%, rgba(14,42,54,.10) 0, rgba(14,42,54,0) 55%),
    linear-gradient(180deg,#f7f9fc 0%, #eef2f7 100%);
  border-bottom: 1px solid #e8edf4;
">
  <div style="max-width:1100px;margin:0 auto;padding:0 20px;text-align:center;">
    <h1 style="margin:0 0 8px;font-size:2.2rem;font-weight:900;letter-spacing:-.2px;color:#0E2A36;">
      <?= e($sobre['title']) ?>
    </h1>
    <p style="margin:0 auto;max-width:760px;color:#5a6672;line-height:1.6;">
      Tecnología que impulsa crecimiento y seguridad.
    </p>
  </div>
</section>

<!-- =================== GALERÍA =================== -->
<section style="padding: 22px 0 10px; font-family: system-ui,-apple-system,'Segoe UI',Roboto,Arial,sans-serif;">
  <div style="max-width:1200px;margin:0 auto;padding:0 20px;">
    <?php if (!empty($sobreSlides)): ?>
      <div id="sobreGallery" class="carousel slide carousel-fade"
           data-bs-ride="carousel" data-bs-interval="4200" data-bs-wrap="true"
           style="border-radius:18px;overflow:hidden;box-shadow:0 12px 26px rgba(0,0,0,.10);">
        <div class="carousel-inner">
          <?php $i=0; foreach ($sobreSlides as $sl): $i++;
            $img = to_abs_url($sl['image_url'] ?? '');
            $alt = $sl['title'] ?? 'Slide';
          ?>
            <div class="carousel-item <?= $i===1 ? 'active' : '' ?>">
              <img
                src="<?= e($img) ?>"
                alt="<?= e($alt) ?>"
                style="display:block;width:100%;height:360px;object-fit:cover;object-position:center;"
                loading="lazy" decoding="async"
                sizes="(min-width: 1200px) 1100px, (min-width: 768px) 900px, 92vw"
              />
              <?php if (!empty($sl['caption'] ?? '')): ?>
                <div class="carousel-caption d-none d-md-block" style="bottom:18px;">
                  <span style="display:inline-block;background:rgba(0,0,0,.45);padding:6px 10px;border-radius:10px;font-weight:700;">
                    <?= e($sl['caption']) ?>
                  </span>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#sobreGallery" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#sobreGallery" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Siguiente</span>
        </button>
      </div>
    <?php else: ?>
      <div style="height:360px;border-radius:18px;overflow:hidden;background:#f4f7fb;border:1px dashed #dbe3ec;
                  display:flex;align-items:center;justify-content:center;color:#8a97a6;">
        Agrega imágenes en “Slides de Sobre Jambo”.
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- =================== CUERPO: Texto + Bullets + KPI + Timeline =================== -->
<section style="padding: 38px 0 72px; font-family: system-ui,-apple-system,'Segoe UI',Roboto,Arial,sans-serif;">
  <div style="max-width:1200px;margin:0 auto;padding:0 20px;">
    <div class="row g-4 g-lg-5 align-items-start" style="display:flex;flex-wrap:wrap;gap:32px;">

      <!-- TARJETA TEXTO (glass suave) -->
      <div class="col-lg-7" style="flex:1 1 560px;">
        <article style="
          background: rgba(255,255,255,0.78);
          -webkit-backdrop-filter: blur(10px); backdrop-filter: blur(10px);
          border: 1px solid rgba(233,237,243,.9);
          border-radius: 22px;
          padding: 32px 30px;
          box-shadow: 0 12px 28px rgba(0,0,0,.10);
        ">
          <h4 style="color:#0A84FF;letter-spacing:.9px;margin:0 0 8px;font-weight:800;font-size:.85rem;">NOSOTROS</h4>

          <h2 style="margin:0 0 12px;font-size:1.95rem;color:#0E2A36;font-weight:900;letter-spacing:-.2px;">
            <?= e($sobre['title']) ?>
          </h2>

          <div style="margin:0 0 20px;color:#3a4450;line-height:1.7;font-size:1rem;">
            <?= nl2br(e($sobre['content'])) ?>
          </div>

          <!-- BULLETS -->
          <ul style="list-style:none;padding:0;margin:0 0 24px;">
            <?php foreach ($bullets as $b): ?>
              <li style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <span style="width:10px;height:10px;border-radius:50%;background:#0A84FF;display:inline-block;"></span>
                <span style="color:#2f3a45;font-weight:600;"><?= e($b) ?></span>
              </li>
            <?php endforeach; ?>
          </ul>

          <!-- CTA principal -->
          <a href="<?= base_path() ?>/contacto" style="
            display:inline-flex;align-items:center;gap:10px;
            background:#16a34a;color:#fff;text-decoration:none;
            border:1px solid #138a3f;padding:10px 14px;border-radius:10px;
            font-weight:800;box-shadow:0 6px 14px rgba(22,163,74,.25);
          ">
            Conócenos
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
          </a>

          <!-- KPIs compactos -->
          <div style="display:flex;gap:18px;margin-top:24px;flex-wrap:wrap;">
            <?php foreach ($stats as $s): ?>
              <div style="
                flex:1 1 140px;background:#fff;border-radius:16px;padding:14px;text-align:center;
                border:1px solid #e3e8ee;box-shadow:0 6px 16px rgba(0,0,0,.06);
              ">
                <div style="font-size:1.35rem;font-weight:900;color:#0A84FF;line-height:1;"><?= e($s['num']) ?></div>
                <div style="color:#4b5563;font-size:.9rem;font-weight:600;"><?= e($s['label']) ?></div>
              </div>
            <?php endforeach; ?>
          </div>
        </article>
      </div>

      <!-- TARJETA DERECHA: “Nuestra experiencia” (timeline) -->
      <aside class="col-lg-5" style="flex:1 1 420px;">
        <div style="
          background:#ffffff;border:1px solid #e9edf3;border-radius:22px;padding:28px;
          box-shadow:0 12px 28px rgba(0,0,0,.08);
        ">
          <h3 style="font-size:1.25rem;font-weight:900;color:#0E2A36;margin:0 0 16px;">Nuestra experiencia</h3>

          <div style="position:relative;padding-left:18px;">
            <div style="position:absolute;left:5px;top:0;bottom:0;width:2px;background:#e7ebf2;"></div>

            <?php foreach ($timeline as $t): ?>
              <div style="position:relative;padding:10px 0 10px 14px;">
                <div style="
                  position:absolute;left:-1px;top:16px;width:12px;height:12px;border-radius:50%;
                  background:#fff;border:2px solid #0A84FF;
                "></div>
                <div style="font-weight:900;color:#0E2A36;"><?= e($t['year']) ?></div>
                <div style="color:#4b5563;line-height:1.55;"><?= e($t['text']) ?></div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </aside>

    </div>
  </div>
</section>

<!-- =================== CTA FINAL =================== -->
<section style="padding:48px 0 68px;background:linear-gradient(180deg,#f7fbff 0%, #f2f7ff 100%);border-top:1px solid #e8edf4;">
  <div style="max-width:900px;margin:0 auto;text-align:center;padding:0 20px;font-family:system-ui,-apple-system,'Segoe UI',Roboto,Arial;">
    <h3 style="margin:0 0 8px;font-weight:900;color:#0E2A36;">Impulsemos tu próximo proyecto</h3>
    <p style="margin:0 0 16px;color:#6b7280;">Conversemos y definamos un plan claro y seguro.</p>
    <a href="<?= base_path() ?>/#contactanos" style="
      display:inline-flex;align-items:center;gap:10px;
      background:#0A84FF;border:1px solid #0A84FF;color:#fff;text-decoration:none;
      padding:12px 18px;border-radius:12px;font-weight:800;
      box-shadow:0 10px 22px rgba(10,132,255,.25);
    ">
      Comenzar
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
      </svg>
    </a>
  </div>
</section>

<?php require __DIR__.'/partials/footer.php'; ?>