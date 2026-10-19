<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>
<div class="container py-5" style="max-width:720px;">
  <h1 class="h4 mb-3">Home (cabecera)</h1>

  <form action="<?= base_path() ?>/admin/home" method="post">
    <div class="mb-3">
      <label class="form-label">Título</label>
      <input name="home_title" class="form-control" value="<?= e($home['title'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Subtítulo</label>
      <textarea name="home_subtitle" class="form-control" rows="3"><?= e($home['subtitle'] ?? '') ?></textarea>
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-primary">Guardar</button>
      <a href="<?= base_path() ?>/admin" class="btn btn-secondary">Volver</a>
      <a href="<?= base_path() ?>/admin/home/slides" class="btn btn-outline-primary">Gestionar slides</a>
    </div>
  </form>
</div>
<?php require __DIR__.'/../partials/footer.php'; ?>