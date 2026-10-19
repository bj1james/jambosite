<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>

<?php
  // Valores actuales (con fallback)
  $siteName      = e($set['site_name']     ?? 'JAMBO');
  $logoUrl       = $set['logo_url']        ?? '';
  $brandPrimary  = $set['brand_primary']   ?? '#111111';
  $brandAccent   = $set['brand_accent']    ?? '#0A84FF';

  // Normaliza imagen a URL absoluta si hace falta
  $previewLogo = $logoUrl;
  if ($previewLogo && !is_absolute_url($previewLogo)) {
    $previewLogo = base_path() . '/' . ltrim($previewLogo, '/');
  }
?>

<style>
/* ============================
   Ajustes del sitio - PRO UI
============================ */
.settings-shell{ max-width: 980px; margin: 0 auto; padding: 36px 20px 60px; }

.topbar {
  display: flex; justify-content: space-between; align-items: center;
  gap: 12px; margin-bottom: 18px;
}
.topbar-left{ display:flex; align-items:center; gap:12px; }
.btn-back {
  display:inline-flex; align-items:center; gap:8px;
  padding:8px 12px; border-radius:10px;
  background:#f8fafc; border:1px solid #e2e8f0; color:#334155;
  font-weight:700; text-decoration:none; transition:.16s ease;
}
.btn-back:hover{ background:#ecf2ff; border-color:#bcd0ff; color:#1e40af; transform:translateY(-1px); }
.btn-back svg{ width:16px; height:16px; }

.page-title{ font-size:1.8rem; font-weight:900; color:#0f172a; margin:0; }
.page-sub{ color:#64748b; margin: 2px 0 0; font-size:.95rem; }

/* Card global */
.card-p {
  background:#fff; border:1px solid #e5e7eb; border-radius:16px;
  padding:22px 24px; box-shadow:0 10px 28px rgba(0,0,0,.06);
}

/* Secciones en 2 columnas */
.grid-2 {
  display:grid; grid-template-columns: 1fr 360px; gap: 18px;
}
@media (max-width: 991.98px){ .grid-2{ grid-template-columns: 1fr; } }

/* Grupo */
.field { margin-bottom: 16px; }
.field label{ font-weight:800; color:#374151; margin-bottom:6px; display:block; }
.help{ color:#6b7280; font-size:.85rem; }
.small-note{ color:#94a3b8; font-size:.84rem; }

/* Logo preview box */
.logo-box {
  background:#f8fafc; border:1px dashed #d8dee6; border-radius:14px;
  display:flex; align-items:center; justify-content:center;
  height: 160px; margin-bottom: 10px; overflow:hidden;
}
.logo-box img{ max-height: 100%; max-width: 100%; object-fit: contain; }

/* Botonera */
.actions { display:flex; gap:10px; flex-wrap:wrap; margin-top: 8px; }
.btn {
  display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:10px;
  border:1px solid transparent; text-decoration:none; font-weight:800; cursor:pointer;
  transition:.18s ease; font-size:.92rem;
}
.btn-primary { background: var(--brand-accent, #0A84FF); border-color: var(--brand-accent, #0A84FF); color:#fff; }
.btn-primary:hover{ filter: brightness(.95); transform: translateY(-1px); }
.btn-secondary { background:#f8fafc; border:1px solid #dbe2ea; color:#334155; }
.btn-secondary:hover{ background:#eef2ff; border-color:#b6c6ff; color:#1e40af; transform: translateY(-1px); }

/* Inline inputs */
.inline-colors { display:grid; grid-template-columns: 1fr 1fr; gap:12px; }
.color-preview{
  display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:10px;
  background:#f8fafc; border:1px solid #e2e8f0; color:#334155; font-weight:700;
}
.color-dot{ width:18px; height:18px; border-radius:6px; border:1px solid #cbd5e1; }

/* Inputs bonitos */
.form-control, .form-select, input[type="file"] {
  border-radius: 10px !important;
  border: 1px solid #e2e8f0 !important;
  padding: .6rem .8rem !important;
}
input[type="color"]{
  width: 48px; height: 36px; padding:0; border:1px solid #e2e8f0; border-radius:8px;
}

/* Notas */
.callout{
  margin-top: 8px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px;
  padding: 10px 12px; color:#475569; font-size:.9rem;
}
</style>

<div class="settings-shell">

  <!-- Topbar -->
  <div class="topbar">
    <div class="topbar-left">
      <a class="btn-back" href="<?= base_path() ?>/admin">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7M3 12h18"/>
        </svg>
        Volver
      </a>
      <div>
        <h1 class="page-title">Ajustes del sitio</h1>
        <p class="page-sub">Nombre, logo y colores de identidad. Los cambios se aplican al instante.</p>
      </div>
    </div>
  </div>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= e($error) ?></div>
  <?php endif; ?>

  <div class="card-p">
    <form method="post" action="<?= base_path() ?>/admin/ajustes" enctype="multipart/form-data">

      <div class="grid-2">
        <!-- Columna izquierda (form principal) -->
        <div>

          <div class="field">
            <label for="site_name">Nombre del sitio</label>
            <input id="site_name" name="site_name" class="form-control" maxlength="80"
                   value="<?= $siteName ?>" placeholder="Ej.: JAMBO" />
            <div class="small-note mt-1">Se muestra en el título y en algunas zonas del sitio.</div>
          </div>

          <div class="field">
            <label for="logo_file">Subir nuevo logo <span class="small-note">(JPG/PNG/WebP/GIF · máx 4 MB)</span></label>
            <input id="logo_file" name="logo_file" type="file" class="form-control" accept="image/*" />
            <div class="small-note mt-1">Si subes archivo, se ignora el campo URL de abajo.</div>
          </div>

          <div class="field">
            <label for="logo_url">(Opcional) URL del logo</label>
            <input id="logo_url" name="logo_url" class="form-control" value="<?= e($logoUrl) ?>"
                   placeholder="https://... o public/uploads/mi-logo.png" />
            <div class="callout">Puedes pegar una URL absoluta o relativa al proyecto. Si subes archivo, esta URL no se usará.</div>
          </div>

          <div class="field">
            <label>Colores de marca</label>
            <div class="inline-colors">
              <div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <span class="fw-semibold">Color primario (textos/encabezados)</span>
                  <span class="color-preview">
                    <span class="color-dot" id="dotPrimary" style="background: <?= e($brandPrimary) ?>;"></span>
                    <span id="hexPrimary"><?= e($brandPrimary) ?></span>
                  </span>
                </div>
                <input type="color" id="inpPrimary" name="brand_primary" value="<?= e($brandPrimary) ?>" />
              </div>

              <div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <span class="fw-semibold">Color acento (botones/enlaces)</span>
                  <span class="color-preview">
                    <span class="color-dot" id="dotAccent" style="background: <?= e($brandAccent) ?>;"></span>
                    <span id="hexAccent"><?= e($brandAccent) ?></span>
                  </span>
                </div>
                <input type="color" id="inpAccent" name="brand_accent" value="<?= e($brandAccent) ?>" />
              </div>
            </div>
          </div>

          <div class="actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a class="btn btn-secondary" href="<?= base_path() ?>/admin">Volver</a>
          </div>
        </div>

        <!-- Columna derecha (preview) -->
        <div>
          <label class="mb-2 fw-semibold">Logo actual / Vista previa</label>
          <div class="logo-box" id="logoPreviewBox">
            <?php if ($previewLogo): ?>
              <img id="logoPreview" src="<?= e($previewLogo) ?>" alt="Logo del sitio" />
            <?php else: ?>
              <div class="text-muted">Aún no hay logo</div>
            <?php endif; ?>
          </div>

          <div class="field mb-0">
            <label class="mb-1">Tips</label>
            <ul class="small-note ms-3">
              <li>Usa imágenes transparentes (PNG/WebP) para mejor contraste.</li>
              <li>Tamaño recomendado del logo: alto entre 40–64 px.</li>
              <li>Procura colores con buen contraste para accesibilidad.</li>
            </ul>
          </div>
        </div>
      </div>

    </form>
  </div>
</div>

<script>
/* ====== Vista previa: logo y colores ====== */
(function(){
  const fileInput = document.getElementById('logo_file');
  const box = document.getElementById('logoPreviewBox');
  const prevImg = document.getElementById('logoPreview');

  if (fileInput) {
    fileInput.addEventListener('change', function(){
      const f = this.files && this.files[0];
      if (!f) return;
      if (!/^image\//.test(f.type)) return alert('Selecciona un archivo de imagen válido.');
      const reader = new FileReader();
      reader.onload = (e) => {
        if (prevImg) { prevImg.src = e.target.result; }
        else {
          const img = document.createElement('img');
          img.id = 'logoPreview';
          img.src = e.target.result;
          img.alt = 'Logo del sitio';
          box.innerHTML = '';
          box.appendChild(img);
        }
      };
      reader.readAsDataURL(f);
    });
  }

  const dotP = document.getElementById('dotPrimary');
  const hexP = document.getElementById('hexPrimary');
  const inpP = document.getElementById('inpPrimary');
  const dotA = document.getElementById('dotAccent');
  const hexA = document.getElementById('hexAccent');
  const inpA = document.getElementById('inpAccent');

  function upd(el, dot, hex){
    if (!el) return;
    el.addEventListener('input', () => {
      const val = el.value;
      if (dot) dot.style.background = val;
      if (hex) hex.textContent = val;
      // Actualiza variables CSS para que el botón primario del preview se adapte
      document.documentElement.style.setProperty('--brand-accent', val);
    });
  }
  upd(inpP, dotP, hexP);
  upd(inpA, dotA, hexA);
})();
</script>

<?php require __DIR__.'/../partials/footer.php'; ?>