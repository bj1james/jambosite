<?php require __DIR__.'/partials/head.php'; ?>
<?php require __DIR__.'/partials/header.php'; ?>

<section class="py-5">
  <div class="container" style="max-width:900px;">
    <h1 style="color:var(--brand-primary);">Contáctanos</h1>

    <?php if (!empty($ok)): ?>
      <div class="alert alert-success mt-3">¡Gracias! Hemos recibido tu mensaje. Nos pondremos en contacto.</div>
    <?php elseif (!empty($error)): ?>
      <div class="alert alert-danger mt-3"><?= e($error) ?></div>
    <?php endif; ?>

    <form action="<?= base_path() ?>/contacto" method="post" class="row g-3 mt-1">
      <div class="col-md-6">
        <label class="form-label">Nombre *</label>
        <input class="form-control" name="first_name" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Apellido *</label>
        <input class="form-control" name="last_name" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Email *</label>
        <input type="email" class="form-control" name="email" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Celular</label>
        <input class="form-control" name="phone" placeholder="+51 9XX XXX XXX">
      </div>
      <div class="col-12">
        <label class="form-label">Mensaje</label>
        <textarea class="form-control" name="message" rows="5"></textarea>
      </div>
      <div class="col-12">
        <button class="btn btn-primary">Enviar</button>
      </div>
    </form>
  </div>
</section>

<?php require __DIR__.'/partials/footer.php'; ?>