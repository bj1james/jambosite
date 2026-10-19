<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>

<?php
// Helper de resaltado seguro (escapa y luego resalta coincidencias)
$hl = function(string $text, string $q): string {
  $safe = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
  if ($q === '') return $safe;
  $pattern = '/' . preg_quote($q, '/') . '/i';
  return preg_replace($pattern, '<mark>$0</mark>', $safe);
};

// Helper para armar URLs de navegación manteniendo parámetros
$base = base_path() . '/admin/mensajes';
$buildUrl = function(array $overrides = []) use ($base, $solo, $q, $per, $page) {
  $query = array_merge([
    'solo' => $solo,
    'q'    => $q,
    'per'  => $per,
    'page' => $page,
  ], $overrides);
  return $base . '?' . http_build_query($query);
};
?>

<style>
  /* ===== Shell general ===== */
  .admin-shell { max-width: 1200px; margin: 0 auto; }

  /* ===== Topbar ===== */
  .admin-topbar {
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: end;
    gap: 16px;
    margin-bottom: 20px;
  }
  .admin-left {
    display: grid;
    grid-template-columns: auto 1fr;
    gap: 12px;
    align-items: center;
  }
  .btn-back {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 8px 12px; border-radius: 10px;
    background: #f8fafc; border: 1px solid #e2e8f0; color: #334155;
    font-weight: 700; text-decoration: none; transition: .16s ease;
  }
  .btn-back:hover { background:#ecf2ff; border-color:#bcd0ff; color:#1e40af; transform: translateY(-1px); }
  .btn-back svg { width: 16px; height: 16px; }

  .title-xl { font-weight: 900; font-size: 1.8rem; color:#0f172a; margin: 0; letter-spacing:-.2px; }
  .subtitle { color:#64748b; margin: 4px 0 0; font-size: .95rem; }

  /* Filtros (pills) con contadores */
  .filters { display: inline-flex; gap: 8px; }
  .pill {
    display:inline-flex; align-items:center; gap:8px;
    padding: 8px 14px; border-radius: 999px; border:1px solid #e2e8f0; background:#fff;
    color:#334155; font-weight:800; text-decoration:none; transition:.15s ease; font-size:.9rem;
    box-shadow: 0 1px 0 rgba(0,0,0,.02);
  }
  .pill:hover{ background:#eef4ff; border-color:#b6c6ff; color:#1e40af; }
  .pill.active{ background:#e6edff; border-color:#b6c6ff; color:#1e40af; box-shadow:0 6px 18px rgba(27,73,224,.12); }
  .pill .count {
    background:#f1f5f9; border:1px solid #e2e8f0; color:#334155;
    font-weight:900; font-size:.78rem; border-radius:999px; padding:2px 8px;
  }

  /* Buscador */
  .searchbar {
    display: grid; grid-template-columns: 1fr auto auto; gap: 8px;
    margin: 10px 0 18px; align-items: center;
  }
  .searchbar input[type="text"] { height: 40px; }
  .searchbar select { height: 40px; }
  .btn { display:inline-flex; align-items:center; gap:6px; }

  /* ===== Card/tabla ===== */
  .card-table{
    border-radius:14px; border:1px solid #e5e7eb; background:#fff;
    box-shadow:0 10px 28px rgba(0,0,0,.06); overflow:hidden;
  }
  .table-wrap{ max-height: 64vh; overflow:auto; }
  .table{ margin-bottom:0; }
  thead th{
    position: sticky; top:0; z-index:2;
    background:#f8fafc; border-bottom-color:#e8edf4;
    color:#334155; font-weight:800;
  }
  tbody tr:nth-child(odd){ background:#fff; }
  tbody tr:nth-child(even){ background:#fbfdff; }
  tbody tr:hover{ background:#f6faff; }

  /* Estados (chips) */
  .chip{
    display:inline-flex; align-items:center; gap:6px;
    padding:5px 10px; border-radius:999px; font-size:.72rem; font-weight:800; letter-spacing:.2px;
    border:1px solid transparent; white-space:nowrap;
  }
  .chip-read{ background:#e7f7ec; color:#137d3e; border-color:#bfe7c8; }
  .chip-unread{ background:#f1f5f9; color:#475569; border-color:#d9e0e7; }
  .chip-saved{ background:#e7f0ff; color:#1e40af; border-color:#c7d7ff; }

  /* Acciones */
  .btn-sm-outline{
    display:inline-flex; align-items:center; gap:6px;
    padding:6px 10px; border-radius:10px; background:#fff; border:1px solid #cfd6e4;
    color:#334155; text-decoration:none; font-weight:800; font-size:.85rem; transition:.15s ease;
  }
  .btn-sm-outline:hover{ background:#eef2ff; border-color:#b6c6ff; color:#1e40af; }
  .btn-sm-danger{ border-color:#f3c2c2; color:#b91c1c; }
  .btn-sm-danger:hover{ background:#ffebeb; border-color:#ff9d9d; color:#991b1b; }

  /* Links */
  .link-mail, .link-wa{ color:#1e40af; text-decoration:none; font-weight:700; }
  .link-mail:hover, .link-wa:hover{ text-decoration:underline; }

  /* Mensaje truncado con tooltip */
  .cell-message{ max-width: 560px; }
  .ellipsis-2{
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden; text-overflow: ellipsis;
  }

  /* Paginación */
  .pagination {
    display:flex; gap:6px; justify-content:center; align-items:center;
    margin-top: 16px;
  }
  .page-link {
    display:inline-flex; align-items:center; justify-content:center;
    width:36px; height:36px; border-radius:10px; border:1px solid #e2e8f0; background:#fff;
    color:#334155; text-decoration:none; font-weight:700; transition:.15s ease;
  }
  .page-link:hover { background:#eef2ff; border-color:#b6c6ff; color:#1e40af; }
  .page-link.active { background:#1e40af; color:#fff; border-color:#1e40af; }
  .page-link.disabled { pointer-events:none; opacity:.45; }

  @media (max-width: 991.98px){
    .cell-message{ max-width:420px; }
    .title-xl{ font-size:1.6rem; }
    .searchbar { grid-template-columns: 1fr auto; grid-auto-rows: 40px; }
  }
</style>

<div class="container admin-shell py-5">

  <!-- Topbar -->
  <div class="admin-topbar">
    <div class="admin-left">
      <a href="<?= base_path() ?>/admin" class="btn-back" title="Volver al panel">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7M3 12h18"/>
        </svg>
        Volver
      </a>
      <div>
        <h1 class="title-xl mb-1">Mensajes de contacto</h1>
        <p class="subtitle">Consulta, gestiona y clasifica los mensajes recibidos.</p>
      </div>
    </div>

    <div class="filters">
      <a class="pill <?= ($solo ?? '')==='nuevos' ? 'active' : '' ?>" href="<?= $buildUrl(['solo'=>'nuevos','page'=>1]) ?>">
        Nuevos <span class="count"><?= (int)($counts['nuevos'] ?? 0) ?></span>
      </a>
      <a class="pill <?= ($solo ?? '')==='guardados' ? 'active' : '' ?>" href="<?= $buildUrl(['solo'=>'guardados','page'=>1]) ?>">
        Guardados <span class="count"><?= (int)($counts['guardados'] ?? 0) ?></span>
      </a>
      <a class="pill <?= ($solo ?? '')==='todos' ? 'active' : '' ?>" href="<?= $buildUrl(['solo'=>'todos','page'=>1]) ?>">
        Todos <span class="count"><?= (int)($counts['todos'] ?? 0) ?></span>
      </a>
    </div>
  </div>

  <!-- Buscador + per-page -->
  <form class="searchbar" method="get" action="<?= $base ?>">
    <input type="hidden" name="solo" value="<?= htmlspecialchars($solo, ENT_QUOTES, 'UTF-8') ?>">
    <input type="text" name="q" value="<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>" class="form-control" placeholder="Buscar por nombre, email, celular o mensaje…">
    <select name="per" class="form-select" onchange="this.form.submit()">
      <option value="10" <?= $per==10?'selected':'' ?>>10 por página</option>
      <option value="20" <?= $per==20?'selected':'' ?>>20 por página</option>
    </select>
    <div class="d-flex gap-2">
      <button class="btn btn-primary">Buscar</button>
      <a class="btn btn-outline-secondary" href="<?= $base ?>?solo=<?= urlencode($solo) ?>">Limpiar</a>
    </div>
  </form>

  <!-- Card / Tabla -->
  <div class="card-table">
    <div class="table-wrap">
      <table class="table align-middle">
        <thead>
          <tr>
            <th style="white-space:nowrap;">Fecha</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Celular</th>
            <th>Mensaje</th>
            <th class="text-end" style="min-width:300px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
          <?php
            $isRead  = (int)($r['is_read']  ?? 0);
            $isSaved = (int)($r['is_saved'] ?? 0);

            $fullName = trim(($r['first_name'] ?? '').' '.($r['last_name'] ?? ''));
            $mail     = trim((string)($r['email'] ?? ''));

            // Normaliza teléfono para wa.me
            $rawPhone = trim((string)($r['phone'] ?? ''));
            $digits   = preg_replace('/\D+/', '', $rawPhone);
            if ($digits !== '' && preg_match('/^9\d{8}$/', $digits)) { $digits = '51'.$digits; }
            $wa = $digits !== '' ? ('https://wa.me/'.$digits) : null;

            $msgFull = (string)($r['message'] ?? '');
          ?>
          <tr class="<?= $isRead ? '' : 'table-warning' ?>">
            <td style="white-space:nowrap;">
              <?= htmlspecialchars($r['created_at'], ENT_QUOTES, 'UTF-8') ?><br>
              <?php if ($isRead): ?>
                <span class="chip chip-read">Leído</span>
              <?php else: ?>
                <span class="chip chip-unread">No leído</span>
              <?php endif; ?>
              <?php if ($isSaved): ?>
                <span class="chip chip-saved">Guardado</span>
              <?php endif; ?>
            </td>

            <td><?= $hl($fullName ?: '—', $q) ?></td>

            <td>
              <?php if ($mail !== ''): ?>
                <a class="link-mail" href="mailto:<?= htmlspecialchars($mail, ENT_QUOTES, 'UTF-8') ?>">
                  <?= $hl($mail, $q) ?>
                </a>
              <?php else: ?>
                —
              <?php endif; ?>
            </td>

            <td>
              <?php if ($wa): ?>
                <a class="link-wa" href="<?= htmlspecialchars($wa, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener">
                  <?= $hl($rawPhone ?: $digits, $q) ?>
                </a>
              <?php else: ?>
                <?= $hl($rawPhone ?: '—', $q) ?>
              <?php endif; ?>
            </td>

            <td class="cell-message">
              <div class="ellipsis-2" title="<?= htmlspecialchars($msgFull, ENT_QUOTES, 'UTF-8') ?>">
                <?= nl2br($hl($msgFull, $q)) ?>
              </div>
            </td>

            <td class="text-end d-flex gap-2 justify-content-end">
              <a class="btn-sm-outline" href="<?= base_path() ?>/admin/mensajes/ver/<?= (int)$r['id'] ?>">Abrir</a>

              <?php if ($isRead): ?>
                <a class="btn-sm-outline" href="<?= base_path() ?>/admin/mensajes/marcar/<?= (int)$r['id'] ?>/no-leido">No leído</a>
              <?php else: ?>
                <a class="btn-sm-outline" href="<?= base_path() ?>/admin/mensajes/marcar/<?= (int)$r['id'] ?>/leido">Leído</a>
              <?php endif; ?>

              <?php if ($isSaved): ?>
                <a class="btn-sm-outline" href="<?= base_path() ?>/admin/mensajes/desguardar/<?= (int)$r['id'] ?>">Quitar</a>
              <?php else: ?>
                <a class="btn-sm-outline" href="<?= base_path() ?>/admin/mensajes/guardar/<?= (int)$r['id'] ?>">Guardar</a>
              <?php endif; ?>

              <a class="btn-sm-outline btn-sm-danger"
                 href="<?= base_path() ?>/admin/mensajes/eliminar/<?= (int)$r['id'] ?>"
                 onclick="return confirm('¿Eliminar este mensaje?')">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>

        <?php if (empty($rows)): ?>
          <tr><td colspan="6" class="text-center text-muted py-4">No hay mensajes para mostrar</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Paginación -->
  <?php if (($totalPages ?? 1) > 1): ?>
    <nav class="pagination" aria-label="Paginación">
      <?php
        $prevPage = max(1, $page-1);
        $nextPage = min($totalPages, $page+1);
      ?>
      <a class="page-link <?= $page<=1?'disabled':'' ?>" href="<?= $buildUrl(['page'=>$prevPage]) ?>" aria-label="Anterior">‹</a>

      <?php
        // Ventana de páginas (máx 7 botones)
        $start = max(1, $page - 3);
        $end   = min($totalPages, $page + 3);
        if ($start > 1) {
          echo '<a class="page-link" href="'.$buildUrl(['page'=>1]).'">1</a>';
          if ($start > 2) echo '<span class="page-link disabled">…</span>';
        }
        for ($p=$start; $p<=$end; $p++) {
          $cls = 'page-link'.($p==$page?' active':'');
          echo '<a class="'.$cls.'" href="'.$buildUrl(['page'=>$p]).'">'.$p.'</a>';
        }
        if ($end < $totalPages) {
          if ($end < $totalPages-1) echo '<span class="page-link disabled">…</span>';
          echo '<a class="page-link" href="'.$buildUrl(['page'=>$totalPages]).'">'.$totalPages.'</a>';
        }
      ?>

      <a class="page-link <?= $page>=$totalPages?'disabled':'' ?>" href="<?= $buildUrl(['page'=>$nextPage]) ?>" aria-label="Siguiente">›</a>
    </nav>
  <?php endif; ?>

</div>

<script>
  // Atajo: Alt + Flecha izquierda => Volver al panel
  document.addEventListener('keydown', (e) => {
    if (e.altKey && e.key === 'ArrowLeft') {
      window.location.href = '<?= base_path() ?>/admin';
    }
  });
</script>

<?php require __DIR__.'/../partials/footer.php'; ?>