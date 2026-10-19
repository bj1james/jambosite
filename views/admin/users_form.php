<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>

<?php
  $isEdit = $isEdit ?? false;
  $row = $row ?? [];
  function f($k,$d=''){ return e($row[$k] ?? $d); }
?>
<style>
  .shell{ max-width:820px; margin:0 auto; padding:32px 16px; }
  .title{ font-size:1.4rem; font-weight:900; color:#fff; margin-bottom:12px; }
  .card{ background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.16); border-radius:14px; padding:16px; backdrop-filter: blur(8px); }
  .grid{ display:grid; grid-template-columns:1fr 1fr; gap:12px; }
  .field label{ color:#cfe7ff; font-weight:800; display:block; margin-bottom:6px; }
  .input, .select{
    width:100%; padding:10px 12px; border-radius:10px; border:1px solid rgba(255,255,255,.18);
    background:#0a1224; color:#e6edf7;
  }
  .row{ display:grid; grid-template-columns:1fr 1fr; gap:12px; }
  .actions{ display:flex; gap:10px; margin-top:10px; }
  .btn{ padding:10px 14px; border-radius:10px; font-weight:800; text-decoration:none; border:1px solid rgba(255,255,255,.2); }
  .btn-primary{ background:#00A3FF; color:#fff; }
  .btn-back{ background:transparent; color:#cfe7ff; }
</style>

<div class="shell">
  <h1 class="title"><?= $isEdit ? 'Editar usuario' : 'Nuevo usuario' ?></h1>

  <form action="<?= base_path() ?>/admin/usuarios/guardar" method="post" class="card">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <?php if ($isEdit): ?><input type="hidden" name="id" value="<?= (int)($row['id'] ?? 0) ?>"><?php endif; ?>

    <div class="grid">
      <div class="field">
        <label>Usuario *</label>
        <input class="input" name="username" value="<?= f('username') ?>" required maxlength="60">
      </div>
      <div class="field">
        <label>Nombre *</label>
        <input class="input" name="display_name" value="<?= f('display_name') ?>" required maxlength="120">
      </div>
      <div class="field">
        <label>Email</label>
        <input class="input" type="email" name="email" value="<?= f('email') ?>" maxlength="160">
      </div>
      <div class="field">
        <label>Rol</label>
        <select class="select" name="role">
          <option value="editor" <?= f('role')==='editor'?'selected':'' ?>>Editor</option>
          <option value="admin"  <?= f('role')==='admin'?'selected':''  ?>>Admin</option>
        </select>
      </div>

      <div class="field">
        <label><?= $isEdit ? 'Nueva contraseña (opcional)' : 'Contraseña *' ?></label>
        <input class="input" type="password" name="password" <?= $isEdit?'':'required' ?> minlength="6" placeholder="<?= $isEdit ? 'Dejar vacío para no cambiar' : '' ?>">
      </div>
      <div class="field" style="display:flex;align-items:center;gap:10px;">
        <label style="margin:0;">Activo</label>
        <input type="checkbox" name="is_active" value="1" <?= (int)($row['is_active'] ?? 1)===1?'checked':'' ?>>
      </div>
    </div>

    <div class="actions">
      <button class="btn btn-primary" type="submit"><?= $isEdit ? 'Guardar cambios' : 'Crear usuario' ?></button>
      <a class="btn btn-back" href="<?= base_path() ?>/admin/usuarios">Volver</a>
    </div>
  </form>
</div>

<?php require __DIR__.'/../partials/footer.php'; ?>