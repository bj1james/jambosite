<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>

<?php
  $isEdit  = !empty($row);
  $title   = e($row['title']   ?? '');
  $slug    = e($row['slug']    ?? '');
  $excerpt = e($row['excerpt'] ?? '');
  $content = $row['content']   ?? '';
  $imgUrl  = $row['image_url'] ?? '';

  $preview = $imgUrl;
  if ($preview) {
    if (function_exists('is_absolute_url')) {
      if (!is_absolute_url($preview)) $preview = base_path() . '/' . ltrim($preview, '/');
    } else if (!preg_match('#^https?://#i', $preview)) {
      $preview = base_path() . '/' . ltrim($preview, '/');
    }
  }
?>

<style>
  .shell { max-width: 980px; margin: 0 auto; padding: 36px 20px 60px; }
  .topbar { display:flex; align-items:center; gap:12px; margin: 14px 0 12px; }
  .btn-back{
    display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:10px;
    background:#f8fafc; border:1px solid #e2e8f0; color:#334155; font-weight:700; text-decoration:none; transition:.16s ease;
  }
  .btn-back:hover{ background:#ecf2ff; border-color:#bcd0ff; color:#1e40af; transform: translateY(-1px); }
  .btn-back svg{ width:16px; height:16px; }
  .page-title { font-size:1.8rem; font-weight:900; color:#0f172a; margin:0; }
  .page-sub   { color:#64748b; margin:2px 0 0; font-size:.95rem; }

  .card-p { background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:22px 24px; box-shadow:0 10px 28px rgba(0,0,0,.06); }
  .grid-2 { display:grid; grid-template-columns: 1fr 320px; gap: 18px; }
  @media (max-width: 991.98px){ .grid-2{ grid-template-columns: 1fr; } }

  .field { margin-bottom:16px; }
  .field label { font-weight:800; color:#374151; margin-bottom:6px; display:block; }
  .form-control, textarea, input[type="file"] { border-radius:10px !important; border:1px solid #e2e8f0 !important; padding:.6rem .8rem !important; }
  textarea { min-height:220px; }

  .row-inline { display:grid; grid-template-columns: 1.2fr .8fr; gap:12px; }
  @media (max-width: 767.98px){ .row-inline { grid-template-columns: 1fr; } }

  .preview { background:#f8fafc; border:1px dashed #d8dee6; border-radius:14px; min-height:200px;
             display:flex; align-items:center; justify-content:center; overflow:hidden; }
  .preview img { max-width:100%; max-height:260px; object-fit:contain; }
  .small-note{ color:#94a3b8; font-size:.84rem; }

  .actions { display:flex; gap:10px; flex-wrap:wrap; margin-top:10px; }
  .btn { display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:10px;
         border:1px solid transparent; text-decoration:none; font-weight:800; cursor:pointer; transition:.18s ease; font-size:.92rem; }
  .btn-primary  { background:#0A84FF; border-color:#0A84FF; color:#fff; }
  .btn-primary:hover { filter:brightness(.95); transform: translateY(-1px); }
  .btn-secondary{ background:#f8fafc; border:1px solid #dbe2ea; color:#334155; }
  .btn-secondary:hover { background:#eef2ff; border-color:#b6c6ff; color:#1e40af; transform: translateY(-1px); }

  .callout{ margin-top: 8px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding: 10px 12px; color:#475569; font-size:.9rem; }
</style>

<div class="shell">

  <div class="topbar">
    <a href="<?= base_path() ?>/admin/servicios" class="btn-back">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M10 19l-7-7 7-7m-7 7h18"/>
      </svg>
      Volver
    </a>
    <div>
      <h1 class="page-title"><?= $isEdit ? 'Editar servicio' : 'Nuevo servicio' ?></h1>
      <p class="page-sub">Título, slug, resumen, contenido e imagen del servicio.</p>
    </div>
  </div>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= e($error) ?></div>
  <?php endif; ?>

  <div class="card-p">
    <form action="" method="post" enctype="multipart/form-data">
      <div class="grid-2">

        <div>
          <div class="row-inline">
            <div class="field">
              <label for="title">Título</label>
              <input id="title" name="title" class="form-control" maxlength="140" value="<?= $title ?>" placeholder="Ej.: Instalación de cámaras de seguridad">
            </div>
            <div class="field">
              <label for="slug">Slug (URL)</label>
              <input id="slug" name="slug" class="form-control" maxlength="160" value="<?= $slug ?>" placeholder="instalacion-de-camaras-de-seguridad">
              <div class="small-note mt-1">Se usará como <code>/servicio/tu-slug</code></div>
            </div>
          </div>

          <div class="field">
            <label for="excerpt">Resumen (excerpt)</label>
            <input id="excerpt" name="excerpt" class="form-control" maxlength="240" value="<?= $excerpt ?>" placeholder="Resumen corto que se ve en la tarjeta de servicios">
          </div>

          <div class="field">
            <label for="content">Contenido</label>
            <textarea id="content" name="content" class="form-control" placeholder="Describe el servicio, beneficios, alcance, etc."><?= e($content) ?></textarea>
          </div>

          <div class="field">
            <label for="image_file">Subir nueva imagen (JPG/PNG/WebP/GIF · máx 4MB)</label>
            <input id="image_file" name="image_file" type="file" class="form-control" accept="image/*">
            <div class="small-note mt-1">Si subes archivo, se ignora la URL de abajo.</div>
          </div>

          <div class="field">
            <label for="image_url">(Opcional) URL de la imagen</label>
            <input id="image_url" name="image_url" class="form-control" value="<?= e($imgUrl) ?>" placeholder="https://... o public/uploads/servicio.jpg">
          </div>

          <div class="actions">
            <button class="btn btn-primary"><?= $isEdit ? 'Guardar cambios' : 'Crear servicio' ?></button>
            <a href="<?= base_path() ?>/admin/servicios" class="btn btn-secondary">Volver</a>
          </div>

          <div class="callout">
            Sugerencia: usa imágenes horizontales **1200×675** (16:9) para que se vean nítidas.
          </div>
        </div>

        <div>
          <label class="mb-2 fw-semibold">Imagen actual / Vista previa</label>
          <div class="preview" id="previewBox">
            <?php if ($preview): ?>
              <img src="<?= e($preview) ?>" id="previewImg" alt="Preview">
            <?php else: ?>
              <span class="text-muted">Sin imagen</span>
            <?php endif; ?>
          </div>
        </div>

      </div>
    </form>
  </div>
</div>

<script>
(function(){
  const file = document.getElementById('image_file');
  const box  = document.getElementById('previewBox');
  let img    = document.getElementById('previewImg');
  if (file) {
    file.addEventListener('change', function(){
      const f = this.files && this.files[0];
      if (!f) return;
      if (!/^image\//.test(f.type)) return alert('Selecciona un archivo de imagen válido.');
      const reader = new FileReader();
      reader.onload = e => {
        if (img) { img.src = e.target.result; }
        else {
          img = document.createElement('img');
          img.id = 'previewImg';
          img.src = e.target.result;
          img.alt = 'Preview';
          box.innerHTML = '';
          box.appendChild(img);
        }
      };
      reader.readAsDataURL(f);
    });
  }
})();
</script>

<?php require __DIR__.'/../partials/footer.php'; ?>