<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>

<?php
  $isEdit  = !empty($row);
  $title   = e($row['title']   ?? '');
  $caption = e($row['caption'] ?? '');
  $pos     = (int)($row['position'] ?? 0);
  $imgUrl  = $row['image_url'] ?? '';

  // preview absoluto
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
/* ===========================================
   Slides de Sobre Jambo - Form (UI PRO)
=========================================== */

.shell { max-width: 900px; margin: 0 auto; padding: 36px 20px 60px; }

/* Topbar */
.topbar { display:flex; align-items:center; gap:12px; margin-bottom:18px; }
.btn-back {
  display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:10px;
  background:#f8fafc; border:1px solid #e2e8f0; color:#334155; font-weight:700; text-decoration:none; transition:.16s ease;
}
.btn-back:hover { background:#ecf2ff; border-color:#bcd0ff; color:#1e40af; transform: translateY(-1px); }
.btn-back svg { width:16px; height:16px; }
.page-title { font-size:1.6rem; font-weight:900; color:#0f172a; margin:0; }

/* Card */
.card-p {
  background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:22px 24px;
  box-shadow:0 10px 28px rgba(0,0,0,.06);
}

/* Grid */
.grid-2 { display:grid; grid-template-columns: 1fr 300px; gap: 18px; }
@media (max-width: 991.98px){ .grid-2{ grid-template-columns: 1fr; } }

/* Inputs */
.field { margin-bottom: 14px; }
.field label { font-weight:800; color:#374151; margin-bottom:6px; display:block; }
.form-control, input[type="file"] {
  border-radius: 10px !important; border:1px solid #e2e8f0 !important; padding:.6rem .8rem !important;
}

/* Preview */
.preview {
  background:#f8fafc; border:1px dashed #d8dee6; border-radius:14px; min-height: 160px;
  display:flex; align-items:center; justify-content:center; overflow:hidden;
}
.preview img { max-width:100%; max-height:220px; object-fit:contain; }

/* Acciones */
.actions { display:flex; gap:10px; flex-wrap:wrap; margin-top: 10px; }
.btn {
  display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:10px;
  border:1px solid transparent; text-decoration:none; font-weight:800; cursor:pointer;
  transition:.18s ease; font-size:.92rem;
}
.btn-primary { background:#0A84FF; border-color:#0A84FF; color:#fff; }
.btn-primary:hover { filter:brightness(.95); transform: translateY(-1px); }
.btn-secondary { background:#f8fafc; border:1px solid #dbe2ea; color:#334155; }
.btn-secondary:hover { background:#eef2ff; border-color:#b6c6ff; color:#1e40af; transform: translateY(-1px); }
.small-note{ color:#94a3b8; font-size:.84rem; }
</style>

<div class="shell">

  <div class="topbar">
    <a href="<?= base_path() ?>/admin/sobre/slides" class="btn-back">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M10 19l-7-7 7-7m-7 7h18"/>
      </svg>
      Volver
    </a>
    <h1 class="page-title"><?= $isEdit ? 'Editar slide' : 'Nuevo slide' ?></h1>
  </div>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= e($error) ?></div>
  <?php endif; ?>

  <div class="card-p">
    <form action="" method="post" enctype="multipart/form-data">

      <div class="grid-2">
        <div>
          <div class="field">
            <label for="title">Título</label>
            <input id="title" name="title" class="form-control" maxlength="120" value="<?= $title ?>" placeholder="Ej.: Nuestro equipo">
          </div>

          <div class="field">
            <label for="caption">Texto (caption)</label>
            <input id="caption" name="caption" class="form-control" maxlength="220" value="<?= $caption ?>" placeholder="Texto breve que aparece sobre la imagen">
          </div>

          <div class="field">
            <label for="position">Posición</label>
            <input id="position" name="position" type="number" class="form-control" value="<?= $pos ?>" min="0">
            <div class="small-note mt-1">Se ordenan ascendente (0, 1, 2...)</div>
          </div>

          <div class="field">
            <label for="image_file">Subir imagen (JPG/PNG/WebP/GIF)</label>
            <input id="image_file" name="image_file" type="file" class="form-control" accept="image/*">
            <div class="small-note mt-1">Si subes archivo, se ignorará la URL de abajo.</div>
          </div>

          <div class="field">
            <label for="image_url">(Opcional) URL de la imagen</label>
            <input id="image_url" name="image_url" class="form-control" value="<?= e($imgUrl) ?>" placeholder="https://... o public/uploads/mi-slide.jpg">
          </div>

          <div class="actions">
            <button class="btn btn-primary"><?= $isEdit ? 'Guardar cambios' : 'Crear slide' ?></button>
            <a href="<?= base_path() ?>/admin/sobre/slides" class="btn btn-secondary">Volver</a>
          </div>
        </div>

        <div>
          <label class="mb-2 fw-semibold">Vista previa</label>
          <div class="preview" id="previewBox">
            <?php if ($preview): ?>
              <img id="previewImg" src="<?= e($preview) ?>" alt="Preview">
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