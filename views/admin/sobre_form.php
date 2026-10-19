<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>

<?php
  // Datos del router
  $title   = trim((string)($page['title']   ?? 'Sobre Jambo'));
  $content = trim((string)($page['content'] ?? ''));
  $base    = rtrim(base_path(), '/');

  // Back seguro: si hay referer y es del mismo host → úsalo; si no, dashboard.
  $referer = $_SERVER['HTTP_REFERER'] ?? '';
  $hostOk  = $_SERVER['HTTP_HOST']    ?? '';
  $sameApp = $referer && (strpos($referer, $hostOk) !== false);
  $backUrl = $sameApp ? $referer : ($base . '/admin');

  // Helpers de salida segura
  $h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
?>

<style>
  .sb-wrap{max-width:1180px;margin:28px auto 60px;padding:0 16px;
    font-family:system-ui,-apple-system,"Segoe UI",Roboto,Arial;color:#0f172a}
  .sb-head{margin-bottom:18px}
  .sb-title{margin:0 0 4px;font-weight:900;letter-spacing:-.2px;color:#0f172a;
    font-size:clamp(1.3rem,2.2vw,1.8rem)}
  .sb-sub{margin:0;color:#6b7280;font-size:.95rem}

  .sb-grid{display:grid;grid-template-columns:1.15fr .85fr;gap:20px;align-items:start}
  @media (max-width:992px){.sb-grid{grid-template-columns:1fr}}

  .card{background:#fff;border:1px solid #e5e7eb;border-radius:16px;
    box-shadow:0 12px 26px rgba(0,0,0,.06);overflow:hidden}
  .card-h{padding:14px 16px;background:#f8fafc;border-bottom:1px solid #e5e7eb;
    font-weight:900;color:#0f172a}
  .card-b{padding:16px}

  .field{margin-bottom:16px}
  .label{display:block;margin:0 0 6px;color:#334155;font-weight:900}
  .input,.textarea{width:100%;padding:12px;border-radius:12px;border:1px solid #e5e7eb;
    background:#fff;color:#0f172a;font-size:1rem}
  .input:focus,.textarea:focus{border-color:#0A84FF;box-shadow:0 0 0 3px rgba(10,132,255,.20);outline:0}
  .textarea{min-height:200px;resize:vertical}
  .hint{margin-top:6px;color:#6b7280;font-size:.88rem}

  .actions{margin-top:16px;display:flex;gap:10px;flex-wrap:wrap}
  .btn{display:inline-flex;align-items:center;gap:8px;padding:10px 14px;border-radius:10px;
    border:1px solid transparent;font-weight:800;text-decoration:none;cursor:pointer}
  .btn-primary{color:#fff;background:linear-gradient(180deg,#4ac7ff,#0A84FF);
    border-color:rgba(10,132,255,.6);
    box-shadow:0 10px 22px rgba(10,132,255,.18),inset 0 1px rgba(255,255,255,.45)}
  .btn-primary:hover{filter:brightness(.98)}
  .btn-ghost{color:#374151;background:#fff;border-color:#d1d5db}
  .btn-ghost:hover{background:#f3f4f6}

  .aside{position:sticky;top:96px}
  .aside .card{margin-bottom:14px}
  .aside h3{margin:0 0 8px;font-weight:900}
  .aside p,.aside li{color:#475569;font-size:.95rem;line-height:1.55}
  .aside ul{margin:0;padding-left:18px}
</style>

<div class="sb-wrap">
  <header class="sb-head">
    <h1 class="sb-title">Sobre Jambo (Nosotros)</h1>
    <p class="sb-sub">
      Edita el contenido principal que aparece en <strong>“Sobre Jambo”</strong>.
      El extracto (~280 caracteres) se usa en la Home.
    </p>
  </header>

  <div class="sb-grid">
    <!-- ===== COLUMNA IZQUIERDA: FORMULARIO ===== -->
    <section class="card">
      <div class="card-h">Contenido</div>
      <div class="card-b">

        <!-- ✅ FORMULARIO BIEN FORMADO -->
        <form action="<?= $h($base) ?>/admin/sobre" method="post" id="sobreForm" novalidate>
          <!-- Título -->
          <div class="field">
            <label class="label" for="title">Título</label>
            <input class="input" id="title" name="title" value="<?= $h($title) ?>" maxlength="120" required>
            <div class="hint">Recomendado: 30–70 caracteres.</div>
          </div>

          <!-- Contenido -->
          <div class="field">
            <label class="label" for="content">Contenido</label>
            <textarea class="textarea" id="content" name="content" maxlength="4000" required><?= $h($content) ?></textarea>
            <div class="hint">Este texto se muestra completo en “Sobre Jambo”. La Home usará un extracto (~280 caracteres).</div>
          </div>

          <!-- Acciones -->
          <div class="actions">
            <button class="btn btn-primary" type="submit">Guardar</button>

            <!-- 🔙 Volver SIEMPRE funcional: enlace real + history.back() opcional -->
            <a href="<?= $h($backUrl) ?>" class="btn btn-ghost" id="btnBack">Volver</a>

            <!-- Enlaces directos -->
            <a href="<?= $h($base) ?>/admin/sobre/slides"  class="btn btn-ghost">Slides</a>
            <a href="<?= $h($base) ?>/admin/sobre/bullets" class="btn btn-ghost">Bullets</a>
          </div>
        </form>
      </div>
    </section>

    <!-- ===== COLUMNA DERECHA: AYUDA ===== -->
    <aside class="aside">
      <section class="card">
        <div class="card-h">Cómo se muestra</div>
        <div class="card-b">
          <p>Este contenido se renderiza como bloque descriptivo en la página <strong>Sobre Jambo</strong>. El primer resumen se usa en la Home.</p>
        </div>
      </section>

      <section class="card">
        <div class="card-h">Edición relacionada</div>
        <div class="card-b">
          <p>Las imágenes se administran en <strong>Slides</strong> y los puntos destacados en <strong>Bullets</strong>.</p>
          <div class="actions">
            <a href="<?= $h($base) ?>/admin/sobre/slides"  class="btn btn-ghost">Ir a Slides</a>
            <a href="<?= $h($base) ?>/admin/sobre/bullets" class="btn btn-ghost">Ir a Bullets</a>
          </div>
        </div>
      </section>

      <section class="card">
        <div class="card-h">Consejos</div>
        <div class="card-b">
          <ul>
            <li>Título claro y con propuesta de valor.</li>
            <li>Párrafo inicial directo (qué haces y para quién).</li>
            <li>Usa bullets para beneficios/servicios clave.</li>
          </ul>
        </div>
      </section>
    </aside>
  </div>
</div>

<script>
  // Si el usuario llegó desde otra vista del admin, usa history.back() para volver exactamente ahí;
  // si no, el href del enlace ya apunta al dashboard (/admin).
  (function(){
    const a = document.getElementById('btnBack');
    if (!a) return;
    a.addEventListener('click', function(ev){
      // Sólo intentamos back si el referer es del mismo host
      const sameApp = document.referrer && location.host && document.referrer.indexOf(location.host) !== -1;
      if (sameApp && history.length > 1){
        ev.preventDefault();
        history.back();
      }
    });
  })();
</script>

<?php require __DIR__.'/../partials/footer.php'; ?>