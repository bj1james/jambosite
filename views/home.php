<?php require __DIR__.'/partials/head.php'; ?>
<?php require __DIR__.'/partials/header.php'; ?>

<!-- ========================== HERO (fondo + overlay + texto delante) ========================== -->
<?php
  $homeTitle = ($home['title'] ?? '') ?: 'Servicios de TI para tu negocio';
  $homeSub   = ($home['subtitle'] ?? '') ?: 'Soluciones tecnológicas confiables, rápidas y a tu medida.';
?>
<section class="hero-fw section-wrap theme-hero-azur hero-bottom-shadow">
  <?php if (!empty($slides)): ?>
    <div id="heroCarousel"
         class="hero-carousel carousel slide carousel-fade hero-pro"
         data-bs-ride="carousel"
         data-bs-interval="4500"
         data-bs-pause="hover"
         data-bs-wrap="true">

      <div class="carousel-inner">
        <?php $i=0; foreach ($slides as $sl): $i++;
          $img = $sl['image_url'] ?? '';
          if ($img && !is_absolute_url($img)) { $img = base_path() . '/' . ltrim($img, '/'); }
          $bg  = e($img ?: '');
        ?>
        <div class="carousel-item <?= $i===1 ? 'active' : '' ?>">
          <div class="hero-slide" style="position:relative;">
            <div class="hero-bg" style="background-image:url('<?= $bg ?>');"></div>

            <!-- NUEVO OVERLAY POTENTE -->
            <div class="overlay-boost"></div>

            <!-- TEXTO PRO -->
            <div class="hero-center text-center px-3">
              <h1 class="hero-title-pro mb-2"><?= e($homeTitle) ?></h1>
              <p class="hero-subtitle-pro mb-0"><?= e($homeSub) ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Indicadores -->
      <div class="carousel-indicators">
        <?php for ($k=0; $k<count($slides); $k++): ?>
          <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $k ?>" class="<?= $k===0?'active':'' ?>"></button>
        <?php endfor; ?>
      </div>

      <!-- Controles -->
      <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>
    </div>
  <?php else: ?>
    <div class="hero-carousel hero-pro d-flex align-items-center justify-content-center" style="height:560px;">
      <div class="text-center px-3">
        <h1 class="hero-title-pro"><?= e($homeTitle) ?></h1>
        <p class="hero-subtitle-pro"><?= e($homeSub) ?></p>
      </div>
    </div>
  <?php endif; ?>
</section>

<!-- ========= SEPARADOR ONDA entre HERO y NOSOTROS ========= -->

<!-- ============================ SECCIÓN “NOSOTROS / SOBRE JAMBO” ============================ -->
<?php
  global $pdo, $settings;

  // Página 'sobre'
  $sobre = ['title'=>'Sobre Jambo','content'=>'Somos un equipo que impulsa negocios con tecnología.'];
  try {
    $stmt = $pdo->prepare("SELECT title, content FROM pages WHERE slug = ? LIMIT 1");
    $stmt->execute(['sobre']);
    $tmp = $stmt->fetch();
    if ($tmp) $sobre = $tmp;
  } catch (Exception $e) {}

  // Slides 'sobre'
  $sobreSlides = [];
  try {
    $stmt = $pdo->prepare("SELECT image_url, title, caption FROM page_slides WHERE page_slug='sobre' ORDER BY position ASC, id ASC");
    $stmt->execute();
    $sobreSlides = $stmt->fetchAll();
  } catch (Exception $e) {}

  // Extracto corto
  $texto = trim(strip_tags($sobre['content'] ?? ''));
  if (mb_strlen($texto) > 280) {
    $c = mb_strpos($texto.' ', ' ', 250);
    if ($c === false) $c = 280;
    $texto = mb_substr($texto, 0, $c) . '…';
  }

  // KPIs
  $k1 = '5+';   $l1 = 'Años de experiencia';
  $k2 = '35+';  $l2 = 'Proyectos entregados';
  $k3 = '24/7'; $l3 = 'Soporte y atención';
?>

<!-- ****** BLOQUE DARK MODERNO (encapsulado, inline styles, sin tocar tu CSS) ****** -->
<section style="position:relative;font-family:system-ui,-apple-system,'Segoe UI',Roboto,Arial;">
  <!-- Fondo dark a juego con el hero -->
  <div style="
    background:
      radial-gradient(1000px 540px at 12% -10%, rgba(10,132,255,.12) 0, rgba(10,132,255,0) 62%),
      radial-gradient(900px 420px at 100% -20%, rgba(0,0,0,.22) 0, rgba(0,0,0,0) 55%),
      linear-gradient(180deg,#0b1220 0%, #0e1422 100%);
    border-top: 1px solid rgba(255,255,255,.06);
    padding: 42px 0 68px;
  ">
    <div class="container" style="max-width:1200px;margin:0 auto;padding:0 20px;">
      <div class="row g-5 align-items-center" style="display:flex;flex-wrap:wrap;gap:32px;">

        <!-- IZQUIERDA: Tarjeta glass-dark (texto + bullets + KPIs) -->
        <div class="col-lg-6" style="flex:1 1 520px;">
          <article style="
            background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.03));
            border:1px solid rgba(255,255,255,.14);
            border-radius:22px;
            padding:30px 28px;
            box-shadow:0 16px 36px rgba(0,0,0,.35), inset 0 1px rgba(255,255,255,.12);
            color:#E6EDF7;
          ">
            <div style="color:#79c0ff;letter-spacing:1px;margin:0 0 8px;font-weight:800;font-size:.85rem;text-transform:uppercase;">
              Nosotros
            </div>

            <h2 style="margin:0 0 12px;font-size:1.95rem;color:#ffffff;font-weight:900;letter-spacing:-.2px;">
              <?= e($sobre['title'] ?? 'Sobre Jambo') ?>
            </h2>

            <p style="margin:0 0 18px;color:#cbd5e1;line-height:1.7;font-size:1rem;">
              <?= nl2br(e($texto)) ?>
            </p>

            <!-- Bullets (tu partial actual) -->
            <div style="margin-bottom:22px;">
              <?php include __DIR__ . '/partials/about_bullets.php'; ?>
            </div>

            <!-- CTA -->
            <a href="<?= base_path() ?>/sobre-jambo"
               style="display:inline-flex;align-items:center;gap:8px;padding:10px 14px;border-radius:10px;
                      border:1px solid rgba(10,132,255,.7);background:#0A84FF;color:#fff;font-weight:900;
                      text-decoration:none;box-shadow:0 12px 24px rgba(10,132,255,.25);">
              Conócenos
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                   viewBox="0 0 24 24" width="18" height="18">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
              </svg>
            </a>

            <!-- KPIs (dark) -->
            <div style="display:flex;gap:14px;margin-top:22px;flex-wrap:wrap;">
              <div style="flex:1 1 120px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.18);
                          border-radius:14px;padding:14px;text-align:center;box-shadow:0 6px 16px rgba(0,0,0,.35);">
                <div style="font-size:1.3rem;font-weight:900;color:#79c0ff;line-height:1;"><?= e($k1) ?></div>
                <div style="color:#cbd5e1;font-size:.9rem;font-weight:700;"><?= e($l1) ?></div>
              </div>
              <div style="flex:1 1 120px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.18);
                          border-radius:14px;padding:14px;text-align:center;box-shadow:0 6px 16px rgba(0,0,0,.35);">
                <div style="font-size:1.3rem;font-weight:900;color:#79c0ff;line-height:1;"><?= e($k2) ?></div>
                <div style="color:#cbd5e1;font-size:.9rem;font-weight:700;"><?= e($l2) ?></div>
              </div>
              <div style="flex:1 1 120px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.18);
                          border-radius:14px;padding:14px;text-align:center;box-shadow:0 6px 16px rgba(0,0,0,.35);">
                <div style="font-size:1.3rem;font-weight:900;color:#79c0ff;line-height:1;"><?= e($k3) ?></div>
                <div style="color:#cbd5e1;font-size:.9rem;font-weight:700;"><?= e($l3) ?></div>
              </div>
            </div>
          </article>
        </div>

        <!-- DERECHA: Carrusel encapsulado (dark frame) -->
        <div class="col-lg-6" style="flex:1 1 520px;">
          <?php if (!empty($sobreSlides)): ?>
            <div id="sobreCarouselHome"
                 class="carousel slide carousel-fade"
                 data-bs-ride="carousel" data-bs-interval="4200" data-bs-pause="hover" data-bs-wrap="true"
                 style="
                   border-radius:20px;overflow:hidden;
                   background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.03));
                   border:1px solid rgba(255,255,255,.14);
                   box-shadow:0 16px 38px rgba(0,0,0,.45), inset 0 1px rgba(255,255,255,.10);
                 ">
              <div class="carousel-inner">
                <?php $i=0; foreach ($sobreSlides as $sl): $i++;
                  $imgS = $sl['image_url'] ?? '';
                  if ($imgS && !is_absolute_url($imgS)) { $imgS = base_path() . '/' . ltrim($imgS, '/'); }
                  $imgS = e($imgS ?: '');
                ?>
                  <div class="carousel-item <?= $i===1 ? 'active' : '' ?>">
                    <img src="<?= $imgS ?>" class="img" alt="<?= e($sl['title'] ?? 'Sobre Jambo') ?>"
                         style="display:block;width:100%;height:340px;object-fit:cover;object-position:center;">
                    <!-- Overlay sutil -->
                    <div style="position:absolute;inset:0;background:
                                linear-gradient(to bottom, rgba(0,0,0,0.00), rgba(0,0,0,0.14) 70%, rgba(0,0,0,0.24));
                                pointer-events:none;"></div>
                    <?php if (!empty($sl['caption'])): ?>
                      <div class="carousel-caption d-none d-md-block" style="bottom:16px;">
                        <span style="display:inline-block;background:rgba(0,0,0,.55);color:#fff;padding:6px 10px;border-radius:10px;font-weight:800;">
                          <?= e($sl['caption']) ?>
                        </span>
                      </div>
                    <?php endif; ?>
                  </div>
                <?php endforeach; ?>
              </div>

              <button class="carousel-control-prev" type="button" data-bs-target="#sobreCarouselHome" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#sobreCarouselHome" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
              </button>
            </div>
          <?php else: ?>
            <div class="ratio ratio-16x9 rounded d-flex align-items-center justify-content-center"
                 style="height:340px;border:1px dashed rgba(255,255,255,.25);color:#9fb3cf;background:rgba(255,255,255,.04);">
              Agrega slides en “Sobre Jambo”.
            </div>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- ============================ SERVICIOS ============================ -->
<<!-- ============================ SERVICIOS (contraste claro, moderno) ============================ -->
<section style="position:relative; font-family:system-ui,-apple-system,'Segoe UI',Roboto,Arial;">
  <style>
    /* ====== Paleta (AURORA: perla → celeste suave) ====== */
    :root{
      --svx-bg-top:   #fffaf3;  /* perla muy leve */
      --svx-bg-bot:   #f4f9ff;  /* celeste pálido */
      --svx-ring:     rgba(10,132,255,.22);
      --svx-title:    #0e2a36;  /* grafito azulado */
      --svx-subtle:   #667482;
      --svx-accent:   #0A84FF;  /* tu acento */
      --svx-border:   #e8edf4;
      --svx-chip-bg:  #eef6ff;
      --svx-chip-tx:  #105fb3;
    }

    /* ====== PALETAS ALTERNATIVAS (descomenta UNA) ====== */

    /* (B) Arena/Marfil (cálido, elegante) */
    /*
    :root{
      --svx-bg-top:#fff6ea; --svx-bg-bot:#fffefb; --svx-ring:rgba(246,174,45,.25);
      --svx-title:#1b2833; --svx-subtle:#6d7884; --svx-accent:#f6ae2d;
      --svx-border:#efe6da; --svx-chip-bg:#fff1d8; --svx-chip-tx:#915a00;
    }
    */

    /* (C) Menta/Teal (fresco, tecnológico) */
    /*
    :root{
      --svx-bg-top:#f3fff9; --svx-bg-bot:#eefcff; --svx-ring:rgba(0,196,140,.22);
      --svx-title:#0f2530; --svx-subtle:#5c6b74; --svx-accent:#00c48c;
      --svx-border:#dbefe8; --svx-chip-bg:#e9fff7; --svx-chip-tx:#00785d;
    }
    */

    /* ====== Estilos del bloque ====== */
    .svx-wrap{
      position:relative;
      background:
        radial-gradient(1200px 620px at 8% -10%, var(--svx-ring) 0, transparent 55%),
        radial-gradient(1000px 520px at 100% -20%, var(--svx-ring) 0, transparent 50%),
        linear-gradient(180deg, var(--svx-bg-top) 0%, var(--svx-bg-bot) 100%);
      border-top: 1px solid var(--svx-border);
      padding: 56px 0 72px;
    }
    .svx-container{ max-width:1200px; margin:0 auto; padding:0 20px; }
    .svx-head{
      display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:18px;
    }
    .svx-title{
      margin:0; color:var(--svx-title); font-weight:900; letter-spacing:-.2px;
      font-size: clamp(1.6rem, 2.8vw, 2rem);
    }
    .svx-chip{
      display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:999px;
      background: var(--svx-chip-bg); color: var(--svx-chip-tx); font-weight:800; font-size:.9rem;
      border:1px solid rgba(16,95,179,.15);
    }
    .svx-chip svg{ width:16px; height:16px }
    /* Línea sutil bajo el título */
    .svx-underline{
      width:72px; height:4px; border-radius:4px; background: var(--svx-accent);
      box-shadow:0 6px 16px rgba(10,132,255,.25); margin:8px 0 20px;
    }

    /* Banda contenedora de cards (tu include las pinta) */
    .svx-grid{ margin-top: 8px; }
  </style>

  <div class="svx-wrap">
    <div class="svx-container">
      <div class="svx-head">
        <div>
          <h2 class="svx-title">Nuestros servicios</h2>
          <div class="svx-underline"></div>
        </div>
        <span class="svx-chip" title="Soluciones confiables">
          <!-- mini icon -->
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
            <path d="M12 2l7 4v6c0 5-3.4 9.4-7 10-3.6-.6-7-5-7-10V6l7-4Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M9 12l2 2 4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Certificado JAMBO
        </span>
      </div>

      <!-- Tu grid de tarjetas (se mantiene igual) -->
      <div class="svx-grid">
        <?php $services = $servicesHome ?? []; include __DIR__.'/servicios_cards.php'; ?>
      </div>
    </div>
  </div>
</section>

<!-- ============================ CONTACTO ============================ -->
<section id="contactanos" class="pad-72 section-surface theme-cta-lilac">
  <div class="container" style="max-width:900px;">
    <div class="row g-4">
      <div class="col-12 text-center">
        <h3 class="title mb-1">Contáctanos</h3>
        <p class="subtitle mb-4">Envíanos un mensaje y te responderemos a la brevedad.</p>
      </div>

      <div class="col-12">
        <form action="<?= base_path() ?>/contacto" method="post" class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nombre *</label>
            <input class="form-control" name="first_name" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Apellido *</label>
            <input class="form-control" name="last_name" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email *</label>
            <input type="email" class="form-control" name="email" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Celular</label>
            <input class="form-control" name="phone" placeholder="+51 9XX XXX XXX">
          </div>
          <div class="col-12">
            <label class="form-label">Mensaje</label>
            <textarea class="form-control" name="message" rows="5" placeholder="Cuéntanos qué necesitas"></textarea>
          </div>
          <div class="col-12 text-center">
            <button class="btn btn-accent btn-lg px-4 rounded-3 shadow-sm">Enviar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__.'/partials/footer.php'; ?>
``