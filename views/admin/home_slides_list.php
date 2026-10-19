<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>

<style>
/* ===========================================
   Slides de Home - Lista (UI PRO consistente)
=========================================== */

.shell { max-width: 1100px; margin: 0 auto; padding: 36px 20px 60px; }

/* Topbar */
.topbar {
  display: flex; justify-content: space-between; align-items: end; gap: 12px;
  margin-bottom: 18px;
}
.topbar-left { display:flex; align-items:center; gap:12px; }
.btn-back {
  display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:10px;
  background:#f8fafc; border:1px solid #e2e8f0; color:#334155; font-weight:700; text-decoration:none; transition:.16s ease;
}
.btn-back:hover { background:#ecf2ff; border-color:#bcd0ff; color:#1e40af; transform: translateY(-1px); }
.btn-back svg { width:16px; height:16px; }
.page-title { font-size:1.8rem; font-weight:900; color:#0f172a; margin:0; }
.page-sub   { color:#64748b; margin: 2px 0 0; font-size:.95rem; }

/* Botón +Nuevo */
.btn-new {
  display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border-radius:10px;
  background:#e8f0ff; color:#1144dd; border:1px solid #b6c6ff; text-decoration:none; font-weight:800; transition:.18s ease;
}
.btn-new:hover { filter:brightness(.98); transform: translateY(-1px); }

/* Card tabla */
.card-table {
  background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:10px;
  box-shadow:0 10px 28px rgba(0,0,0,.06);
}
.table { margin-bottom: 0; }
.table thead th { color:#334155; font-weight:800; border-bottom-color:#eef2f7; }
.table tbody tr:hover { background:#fbfdff; }

/* Mini thumb */
.thumb-wrap {
  display:flex; align-items:center; gap:10px;
}
.thumb {
  width: 68px; height: 44px; object-fit: cover; border-radius:8px; border:1px solid #e5e7eb;
  box-shadow:0 2px 6px rgba(0,0,0,.06);
}

/* Acciones */
.btn-sm-outline {
  display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:8px;
  border:1px solid #cfd6e4; background:#fff; color:#334155; text-decoration:none; font-weight:700; font-size:.85rem; transition:.15s ease;
}
.btn-sm-outline:hover { background:#eef2ff; border-color:#b6c6ff; color:#1e40af; }
.btn-sm-danger { border-color:#f3c2c2; color:#b91c1c; }
.btn-sm-danger:hover { background:#ffebeb; border-color:#ff9d9d; color:#991b1b; }

/* Posición como pill suave */
.pos-pill {
  display:inline-flex; align-items:center; justify-content:center; min-width: 34px; height: 26px;
  padding:0 8px; border-radius:999px; border:1px solid #e2e8f0; background:#f8fafc; font-weight:800; color:#334155;
}
</style>

<div class="shell">

  <!-- Topbar -->
  <div class="topbar">
    <div class="topbar-left">
      <a class="btn-back" href="<?= base_path() ?>/admin" title="Volver al panel">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 19l-7-7 7-7m-7 7h18"/>
        </svg>
        Volver
      </a>
      <div>
        <h1 class="page-title">Slides de Home</h1>
        <p class="page-sub">Administra las imágenes y textos del carrusel principal.</p>
      </div>
    </div>

    <a class="btn-new" href="<?= base_path() ?>/admin/home/slides/nuevo">+ Nuevo</a>
  </div>

  <!-- Tabla -->
  <div class="card-table">
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th style="width:80px;">Pos.</th>
            <th style="width:120px;">Imagen</th>
            <th style="min-width:220px;">Título</th>
            <th>Texto</th>
            <th class="text-end" style="width:210px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
          <?php
            $pos   = (int)($r['position'] ?? 0);
            $title = trim((string)($r['title'] ?? ''));
            $cap   = trim((string)($r['caption'] ?? ''));
            $img   = trim((string)($r['image_url'] ?? ''));

            // URL absoluta/relativa
            if ($img !== '') {
              if (function_exists('is_absolute_url')) {
                if (!is_absolute_url($img)) $img = base_path() . '/' . ltrim($img, '/');
              } else {
                if (!preg_match('#^https?://#i', $img)) $img = base_path() . '/' . ltrim($img, '/');
              }
            }
          ?>
          <tr>
            <td><span class="pos-pill"><?= $pos ?></span></td>

            <td>
              <div class="thumb-wrap">
                <?php if ($img): ?>
                  <img src="<?= e($img) ?>" alt="<?= e($title ?: 'Slide') ?>" class="thumb">
                <?php else: ?>
                  <span class="text-muted small">Sin imagen</span>
                <?php endif; ?>
              </div>
            </td>

            <td class="fw-semibold"><?= e($title ?: '—') ?></td>
            <td class="text-muted"><?= e($cap ?: '—') ?></td>

            <td class="text-end d-flex gap-2 justify-content-end">
              <a class="btn-sm-outline" href="<?= base_path() ?>/admin/home/slides/editar/<?= (int)$r['id'] ?>">Editar</a>
              <a class="btn-sm-outline btn-sm-danger"
                 href="<?= base_path() ?>/admin/home/slides/eliminar/<?= (int)$r['id'] ?>"
                 onclick="return confirm('¿Eliminar este slide?')">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>

        <?php if (empty($rows)): ?>
          <tr><td colspan="5" class="text-center text-muted py-4">Aún no hay slides</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
<?php require __DIR__.'/../partials/footer.php'; ?>
``