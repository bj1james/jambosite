<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>

<style>
  .shell{ max-width:1100px; margin:0 auto; padding:32px 16px; }
  .topbar{ display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; }
  .title{ font-size:1.6rem; font-weight:900; color:#fff; }
  .btn{ display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border-radius:10px; font-weight:800; text-decoration:none; cursor:pointer; }
  .btn-primary{ background:#00A3FF; color:#fff; border:1px solid rgba(255,255,255,.20); }
  .card{ background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.16); border-radius:14px; padding:12px; backdrop-filter: blur(8px); }
  table{ width:100%; border-collapse: collapse; color:#e6edf7; }
  th,td{ padding:10px; border-bottom:1px solid rgba(255,255,255,.08); }
  th{ color:#cfe7ff; text-align:left; }
  .pill{ padding:2px 8px; border-radius:999px; font-size:.78rem; font-weight:800; }
  .pill-ok{ background:rgba(126,203,76,.18); color:#a9f08c; border:1px solid rgba(126,203,76,.35); }
  .pill-off{ background:rgba(255,87,87,.16); color:#ffb5b5; border:1px solid rgba(255,87,87,.35); }
  .act a{ margin-right:8px; }
</style>

<div class="shell">
  <div class="topbar">
    <h1 class="title">Usuarios</h1>
    <a class="btn btn-primary" href="<?= base_path() ?>/admin/usuarios/nuevo">+ Nuevo usuario</a>
  </div>

  <?php if (!empty($_SESSION['flash'])): ?>
    <div class="card" style="margin-bottom:10px; color:#fff;"><?= e($_SESSION['flash']); unset($_SESSION['flash']); ?></div>
  <?php endif; ?>

  <div class="card">
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>ID</th><th>Usuario</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Estado</th><th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($rows as $r): ?>
          <tr>
            <td><?= (int)$r['id'] ?></td>
            <td><?= e($r['username']) ?></td>
            <td><?= e($r['display_name']) ?></td>
            <td><?= e($r['email'] ?? '') ?></td>
            <td><?= e($r['role']) ?></td>
            <td>
              <?php if ((int)$r['is_active']===1): ?>
                <span class="pill pill-ok">Activo</span>
              <?php else: ?>
                <span class="pill pill-off">Inactivo</span>
              <?php endif; ?>
            </td>
            <td class="act">
              <a href="<?= base_path() ?>/admin/usuarios/editar/<?= (int)$r['id'] ?>">Editar</a>
              <?php if ((int)$r['is_active']===1): ?>
                <a href="<?= base_path() ?>/admin/usuarios/eliminar/<?= (int)$r['id'] ?>" onclick="return confirm('¿Desactivar usuario?')">Desactivar</a>
              <?php else: ?>
                <a href="<?= base_path() ?>/admin/usuarios/activar/<?= (int)$r['id'] ?>">Activar</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($rows)): ?>
          <tr><td colspan="7" style="color:#9fb3cf;">No hay usuarios aún.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require __DIR__.'/../partials/footer.php'; ?>