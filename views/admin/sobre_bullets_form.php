<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>

<div class="container py-5" style="max-width:720px;">
  <h1 class="h4 mb-3"><?= $row ? 'Editar' : 'Nuevo' ?> bullet</h1>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= e($error) ?></div>
  <?php endif; ?>

  <form method="post" action="">
    <div class="mb-3">
      <label class="form-label">Texto del bullet</label>
      <input name="text" class="form-control" value="<?= e($row['text'] ?? '') ?>" maxlength="255" required>
      <small class="text-muted">Máximo 255 caracteres.</small>
    </div>

    <div class="mb-3">
      <label class="form-label">Posición (orden)</label>
      <input name="position" type="number" class="form-control" value="<?= e($row['position'] ?? 0) ?>">
      <small class="text-muted">Se ordenan ascendente (0, 1, 2...)</small>
    </div>

    <div class="d-flex gap-2">
      <button class="btn btn-primary"><?= $row ? 'Guardar cambios' : 'Crear' ?></button>
      <a href="<?= base_path() ?>/admin/sobre/bullets" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>
</div>

<?php require __DIR__.'/../partials/footer.php'; ?>