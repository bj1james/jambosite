<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>

<?php
/* Espera recibir $rows (array de slides) con campos:
   id, image_url, title, caption, position (o el orden en que ya vienes listando).
   Si tu router usa otra clave para el orden, úsala más abajo en lugar de 'position'. */

function abs_img($url){
  if (!$url) return '';
  if (preg_match('#^(?:https?:)?//#i', $url)) return $url;
  return rtrim(base_path(), '/') . '/' . ltrim($url, '/');
}
?>

<style>
  /* ---------- marco general ---------- */
  .sx-shell{ max-width:1160px; margin:28px auto 48px; padding:0 16px; font-family:system-ui,-apple-system,"Segoe UI",Roboto,Arial; color:#0f172a; }
  .sx-head{ display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:14px; }
  .sx-title{ margin:0; font-weight:900; letter-spacing:-.2px; font-size:clamp(1.2rem,2.2vw,1.6rem); color:#0f172a; }
  .sx-sub{ margin:2px 0 0; color:#6b7280; font-size:.95rem; }

  /* ---------- botones ---------- */
  .sx-actions{ display:flex; align-items:center; gap:8px; }
  .btn-ghost, .btn-primary{
    display:inline-flex; align-items:center; gap:8px; text-decoration:none; cursor:pointer; user-select:none; white-space:nowrap;
    padding:10px 12px; border-radius:10px; font-weight:800; font-size:.95rem;
  }
  .btn-ghost{
    color:#0f172a; background:#fff; border:1px solid #e5e7eb;
  }
  .btn-ghost:hover{ background:#f8fafc; }
  .btn-primary{
    color:#fff; background:linear-gradient(180deg,#4ac7ff,#0A84FF); border:1px solid rgba(10,132,255,.6);
    box-shadow:0 10px 22px rgba(10,132,255,.18), inset 0 1px rgba(255,255,255,.5);
  }
  .btn-primary:hover{ filter:brightness(.98); }
  .btn-sm{ padding:8px 10px; font-size:.88rem; border-radius:9px; }
  .btn-edit{ color:#0b5; background:#e8fff3; border:1px solid #b9f1d1; }
  .btn-edit:hover{ background:#dcfeec; }
  .btn-danger{ color:#c62828; background:#fff1f1; border:1px solid #f5c6c6; }
  .btn-danger:hover{ background:#ffe9e9; }

  /* ---------- tarjeta contenedora ---------- */
  .sx-card{
    background:#ffffff; border:1px solid #eaeef4; border-radius:16px; box-shadow:0 12px 28px rgba(0,0,0,.06);
    overflow:hidden;
  }
  .sx-card-header{
    display:flex; align-items:center; justify-content:space-between; gap:12px; padding:14px 16px; background:#f8fafc;
    border-bottom:1px solid #edf2f7;
  }
  .sx-search{ display:flex; align-items:center; gap:8px; }
  .sx-input{
    width:260px; max-width:60vw; padding:10px 12px; border-radius:10px; border:1px solid #e5e7eb; outline:none;
    background:#fff; color:#0f172a;
  }
  .sx-input:focus{ border-color:#b9ddff; box-shadow:0 0 0 3px rgba(10,132,255,.15); }

  /* ---------- tabla ---------- */
  .sx-table-wrap{ width:100%; overflow:auto; }
  table.sx-table{ width:100%; border-collapse:separate; border-spacing:0; }
  .sx-th, .sx-td{ padding:12px 14px; border-bottom:1px solid #eef2f7; vertical-align:middle; }
  .sx-th{
    position:sticky; top:0; background:#ffffff; z-index:1; color:#334155; font-weight:900; font-size:.88rem; text-align:left;
    border-bottom:1px solid #e5eaf1;
  }
  .sx-row:hover{ background:#f9fbff; }
  .sx-pos{ width:58px; text-align:center; }
  .sx-thumb{ width:72px; }
  .sx-thumb .img{
    width:64px; height:44px; object-fit:cover; border-radius:10px; border:1px solid #e5e7eb; display:block;
    box-shadow:0 4px 12px rgba(0,0,0,.06);
  }
  .sx-title-c{
    font-weight:800; color:#0f172a; line-height:1.15;
  }
  .sx-caption{ color:#6b7280; font-size:.92rem; }
  .sx-actions-col{ width:180px; text-align:right; }

  /* ---------- estado vacío ---------- */
  .sx-empty{
    padding:46px 20px; text-align:center; color:#6b7280;
  }
  .sx-empty .icon{
    width:54px; height:54px; display:inline-flex; align-items:center; justify-content:center; border-radius:14px; margin-bottom:10px;
    background:#f1f5f9; border:1px solid #e2e8f0; color:#0A84FF;
  }

  /* ---------- toasts mínimos (feedback) ---------- */
  .sx-toast{ position:fixed; right:18px; bottom:18px; z-index:9999; display:none; }
  .sx-toast.show{ display:block; }
  .sx-toast .box{
    background:#0f172a; color:#e6edf7; border:1px solid rgba(255,255,255,.14); border-radius:12px; padding:10px 12px;
    box-shadow:0 12px 24px rgba(0,0,0,.35);
  }
</style>

<div class="sx-shell">

  <!-- Cabecera -->
  <div class="sx-head">
    <div>
      <h1 class="sx-title">Slides de Sobre Jambo</h1>
      <p class="sx-sub">Administra las imágenes y textos que se muestran en la sección “Nosotros”.</p>
    </div>
    <div class="sx-actions">
      <!-- 🔙 Volver SIEMPRE al Dashboard -->
      <a href="<?= base_path() ?>/admin" class="btn-ghost" title="Ir al dashboard">
        <!-- flecha -->
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0f172a"><path d="M15 6l-6 6 6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Volver
      </a>
      <a href="<?= base_path() ?>/admin/sobre/slides/nuevo" class="btn-primary">
        <!-- plus -->
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff"><path d="M12 5v14M5 12h14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Nuevo
      </a>
    </div>
  </div>

  <!-- Card -->
  <section class="sx-card">

    <div class="sx-card-header">
      <div class="sx-search">
        <!-- ícono buscar -->
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b"><circle cx="11" cy="11" r="7" stroke-width="2"/><path d="M21 21l-3.6-3.6" stroke-width="2" stroke-linecap="round"/></svg>
        <input class="sx-input" type="search" id="q" placeholder="Buscar por título o texto…"
               oninput="filterRows(this.value)">
      </div>
      <div style="color:#64748b;font-weight:700;">
        Total: <span id="sxCount"><?= isset($rows)? count($rows) : 0 ?></span>
      </div>
    </div>

    <div class="sx-table-wrap">
      <table class="sx-table" id="sxTable">
        <thead>
          <tr>
            <th class="sx-th sx-pos">Pos.</th>
            <th class="sx-th sx-thumb">Imagen</th>
            <th class="sx-th">Título</th>
            <th class="sx-th">Texto</th>
            <th class="sx-th sx-actions-col">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!empty($rows)): ?>
          <?php foreach ($rows as $i => $r): ?>
            <?php
              $pos = $r['position'] ?? ($i+1);
              $img = abs_img($r['image_url'] ?? '');
              $title = trim((string)($r['title'] ?? ''));
              $caption = trim((string)($r['caption'] ?? ($r['text'] ?? '')));
            ?>
            <tr class="sx-row">
              <td class="sx-td sx-pos">
                <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#f1f5f9;border:1px solid #e2e8f0;font-weight:900;color:#0f172a;">
                  <?= (int)$pos ?>
                </span>
              </td>
              <td class="sx-td sx-thumb">
                <?php if ($img): ?>
                  <img src="<?= e($img) ?>" alt="<?= e($title ?: 'Slide') ?>" class="img">
                <?php else: ?>
                  <div style="width:64px;height:44px;border-radius:10px;border:1px dashed #cbd5e1;background:#f8fafc;display:grid;place-items:center;color:#94a3b8;font-weight:800;">—</div>
                <?php endif; ?>
              </td>
              <td class="sx-td">
                <div class="sx-title-c"><?= e($title !== '' ? $title : '—') ?></div>
              </td>
              <td class="sx-td">
                <div class="sx-caption"><?= e($caption !== '' ? $caption : '—') ?></div>
              </td>
              <td class="sx-td sx-actions-col">
                <div style="display:flex; gap:8px; justify-content:flex-end;">
                  <a class="btn-sm btn-edit" href="<?= base_path() ?>/admin/sobre/slides/editar/<?= (int)$r['id'] ?>">Editar</a>
                  <a class="btn-sm btn-danger"
                     href="<?= base_path() ?>/admin/sobre/slides/eliminar/<?= (int)$r['id'] ?>"
                     onclick="return confirm('¿Eliminar este slide?')">Eliminar</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td class="sx-td" colspan="5">
            <div class="sx-empty">
              <div class="icon">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <rect x="3" y="4" width="18" height="14" rx="2" stroke-width="2"/>
                  <path d="M3 9h18M7 19h10" stroke-width="2" stroke-linecap="round"/>
                </svg>
              </div>
              Aún no hay slides. Haz clic en <strong>“Nuevo”</strong> para agregar el primero.
            </div>
          </td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>

<div class="sx-toast" id="sxToast"><div class="box" id="sxToastMsg">Hecho</div></div>

<script>
  // --- Búsqueda simple por título o caption (front-end) ---
  function filterRows(q){
    q = (q||'').toLowerCase().trim();
    const tb = document.querySelector('#sxTable tbody');
    const rows = tb ? Array.from(tb.querySelectorAll('tr.sx-row')) : [];
    let visible = 0;
    rows.forEach(tr=>{
      const t = (tr.querySelector('.sx-title-c')?.innerText || '').toLowerCase();
      const c = (tr.querySelector('.sx-caption')?.innerText || '').toLowerCase();
      const ok = !q || t.includes(q) || c.includes(q);
      tr.style.display = ok ? '' : 'none';
      if (ok) visible++;
    });
    const count = document.getElementById('sxCount'); if (count) count.textContent = String(visible);
  }

  // --- Toast simple (puedes llamarlo tras una acción POST si rediriges con ?ok=1) ---
  (function(){
    const url = new URL(window.location.href);
    if (url.searchParams.get('ok') === '1'){
      const t = document.getElementById('sxToast'); const m = document.getElementById('sxToastMsg');
      if (t && m){ m.textContent = 'Cambios guardados'; t.classList.add('show'); setTimeout(()=>t.classList.remove('show'), 2200); }
    }
  })();
</script>

<?php require __DIR__.'/../partials/footer.php'; ?>