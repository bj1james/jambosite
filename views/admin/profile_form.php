<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>
<?php function f($k,$d=''){ global $row; return e($row[$k] ?? $d); } ?>
<style>
  .shell{ max-width:720px; margin:0 auto; padding:32px 16px; }
  .title{ font-size:1.4rem; font-weight:900; color:#fff; margin-bottom:12px; }
  .card{ background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.16); border-radius:14px; padding:16px; backdrop-filter: blur(8px); }
  .field label{ color:#cfe7ff; font-weight:800; display:block; margin-bottom:6px; }
  .input{ width:100%; padding:10px 12px; border-radius:10px; border:1px solid rgba(255,255,255,.18); background:#0a1224; color:#e6edf7; }
  .row{ display:grid; grid-template-columns:1fr 1fr; gap:12px; }
  .actions{ display:flex; gap:10px; margin-top:10px; }
  .btn{ padding:10px 14px; border-radius:10px; font-weight:800; text-decoration:none; border:1px solid rgba(255,255,255,.2); }
  .btn-primary{ background:#00A3FF; color:#fff; }
</style>

<div class="shell">
  <?php if (!empty($_SESSION['flash'])): ?>
    <div class="card" style="margin-bottom:10px; color:#fff;"><?= e($_SESSION['flash']); unset($_SESSION['flash']); ?></div>
  <?php endif; ?>

  <h1 class="title">Mi perfil</h1>
  <form action="<?= base_path() ?>/admin/perfil/guardar" method="post" class="card" style="margin-bottom:12px;">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="row">
      <div class="field">
        <label>Usuario</label>
        <input class="input" value="<?= f('username') ?>" disabled>
      </div>
      <div class="field">
        <label>Nombre</label>
        <input class="input" name="display_name" value="<?= f('display_name') ?>" required>
      </div>
      <div class="field">
        <label>Email</label>
        <input class="input" type="email" name="email" value="<?= f('email') ?>">
      </div>
    </div>
    <div class="actions"><button class="btn btn-primary">Guardar</button></div>
  </form>

  <h2 class="title" style="font-size:1.1rem;">Cambiar contraseña</h2>
  <form action="<?= base_path() ?>/admin/perfil/password" method="post" class="card">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="row">
      <div class="field">
        <label>Contraseña actual</label>
        <input class="input" type="password" name="current" required>
      </div>
      <div class="field">
        <label>Nueva contraseña</label>
        <input class="input" type="password" name="password" minlength="6" required>
      </div>
      <div class="field">
        <label>Confirmar contraseña</label>
        <input class="input" type="password" name="confirm" minlength="6" required>
      </div>
    </div>
    <div class="actions"><button class="btn btn-primary">Actualizar contraseña</button></div>
  </form>
</div>

<?php require __DIR__.'/../partials/footer.php'; ?>