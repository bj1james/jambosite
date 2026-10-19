<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>

<style>
  /* Barra superior de la página */
  .admin-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 18px;
  }
  .admin-left {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    background: #f7f7f9;
    color: #374151;
    text-decoration: none;
    font-weight: 600;
    transition: all .18s ease;
  }
  .btn-back:hover {
    background: #eef2ff;
    border-color: #b6c6ff;
    color: #1e40af;
    transform: translateY(-1px);
  }
  .btn-back svg { width: 16px; height: 16px; }

  /* Botón + Nuevo */
  .btn-new {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    border-radius: 10px;
    background: #e8f0ff;
    color: #1144dd;
    border: 1px solid #b6c6ff;
    text-decoration: none;
    font-weight: 600;
    transition: all .18s ease;
  }
  .btn-new:hover { filter: brightness(.98); transform: translateY(-1px); }
  .btn-new svg { width: 16px; height: 16px; }

  /* Contenedor tabla */
  .table-wrapper {
    border-radius: 12px;
    background: #fff;
    padding: 10px;
    box-shadow: 0 8px 22px rgba(0,0,0,.05);
    border: 1px solid #eaecef;
  }

  /* Acciones de la tabla */
  .btn-sm-outline {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 8px;
    border: 1px solid #cfd6e4;
    background: #fff;
    text-decoration: none;
    font-size: .875rem;
    color: #334155;
    transition: all .15s ease;
  }
  .btn-sm-outline:hover { background:#eef2ff; border-color:#b6c6ff; color:#1e40af; }
  .btn-sm-danger { border-color:#f3c2c2; color:#b91c1c; }
  .btn-sm-danger:hover { background:#ffebeb; border-color:#ff9d9d; color:#991b1b; }

  /* Enlace slug */
  .slug-link { color:#e11d48; text-decoration:none; }
  .slug-link:hover { text-decoration:underline; }
</style>

<div class="container py-5">

  <!-- Topbar con Volver y + Nuevo -->
  <div class="admin-topbar">
    <div class="admin-left">
      <a class="btn-back" href="<?= base_path() ?>/admin">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7M3 12h18"/>
        </svg>
        Volver
      </a>
      <h1 class="h4 mb-0">Servicios</h1>
    </div>

    <a class="btn-new" href="<?= base_path() ?>/admin/servicios/nuevo">
      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 4a.5.5 0 0 1 .5.5V7.5H11.5a.5.5 0 0 1 0 1H8.5V11.5a.5.5 0 0 1-1 0V8.5H4.5a.5.5 0 0 1 0-1H7.5V4.5A.5.5 0 0 1 8 4Z"/>
      </svg>
      Nuevo
    </a>
  </div>

  <!-- Tabla -->
  <div class="table-wrapper">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th style="min-width:280px;">Título</th>
            <th>Slug</th>
            <th>Actualizado</th>
            <th class="text-end" style="min-width:240px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
          <?php $slug = e($r['slug']); ?>
          <tr>
            <td><?= e($r['title']) ?></td>
            <td>
              <a class="slug-link" href="<?= base_path() ?>/servicio/<?= $slug ?>" target="_blank" rel="noopener">
                <?= $slug ?>
              </a>
            </td>
            <td><?= e($r['updated_at']) ?></td>
            <td class="text-end d-flex gap-2 justify-content-end">
              <a class="btn-sm-outline" href="<?= base_path() ?>/admin/servicios/editar/<?= (int)$r['id'] ?>">Editar</a>
              <a class="btn-sm-outline btn-sm-danger" href="<?= base_path() ?>/admin/servicios/eliminar/<?= (int)$r['id'] ?>"
                 onclick="return confirm('¿Eliminar este servicio?')">Eliminar</a>
              <a class="btn-sm-outline" href="<?= base_path() ?>/servicio/<?= $slug ?>" target="_blank" rel="noopener">Ver</a>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($rows)): ?>
          <tr><td colspan="4" class="text-center text-muted">No hay servicios aún</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
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