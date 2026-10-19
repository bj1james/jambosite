<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>

<style>
/* ============================
   DISEÑO PREMIUM - DETALLE MSG
============================ */

.wrapper {
  max-width: 900px;
  margin: 0 auto;
  padding: 40px 20px 60px;
}

/* BACK BUTTON + TITLE */
.header-block {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 25px;
}

.btn-back {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 12px;
  background: #f1f5f9;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  font-weight: 600;
  color: #475569;
  text-decoration: none;
  transition: .18s ease;
}

.btn-back svg {
  width: 16px;
  height: 16px;
}

.btn-back:hover {
  background: #e2e8ff;
  border-color: #b6c3ff;
  color: #1d4ed8;
  transform: translateY(-1px);
}

.page-title {
  font-size: 1.9rem;
  font-weight: 800;
  margin: 0;
  color: #0f172a;
}

.page-subtitle {
  margin-top: 4px;
  margin-left: 45px;
  font-size: .95rem;
  color: #6b7280;
}

/* CARD */
.card {
  background: #ffffff;
  border-radius: 18px;
  padding: 28px 32px;
  border: 1px solid #e5e7eb;
  box-shadow: 0 10px 28px rgba(0,0,0,.06);
  margin-top: 18px;
}

/* GRID */
.info-grid {
  display: grid;
  grid-template-columns: 160px 1fr;
  row-gap: 14px;
  column-gap: 12px;
}

.label {
  font-weight: 700;
  color: #475569;
}

.value {
  font-weight: 600;
  color: #0f172a;
}

/* MENSAJE */
.message-box {
  margin-top: 20px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  padding: 20px 18px;
  border-radius: 14px;
  font-size: .95rem;
  color: #475569;
  line-height: 1.52rem;
  white-space: pre-line;
}

/* BOTONERA */
.actions {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  margin-top: 25px;
}

.action-btn {
  padding: 10px 18px;
  border-radius: 10px;
  font-weight: 700;
  font-size: .9rem;
  border: 1px solid transparent;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  transition: .18s ease;
}

.action-neutral {
  background: #f8fafc;
  border-color: #d8dee6;
  color: #334155;
}
.action-neutral:hover {
  background: #eef2ff;
  border-color: #b6c6ff;
  color: #1e40af;
}

.action-green {
  background: #e7f7ec;
  border-color: #c6eeda;
  color: #0f7a36;
}
.action-green:hover { background: #dbf2e4; }

.action-yellow {
  background: #fff5da;
  border-color: #ffe2a8;
  color: #845a00;
}
.action-yellow:hover { background: #ffeec3; }

.action-danger {
  background: #ffe8e8;
  border-color: #ffc2c2;
  color: #c32424;
}
.action-danger:hover { background: #ffdada; }

.action-dark {
  background: #1e293b;
  color: #fff;
}
.action-dark:hover { background: #273448; }

</style>

<div class="wrapper">

  <!-- HEADER -->
  <div class="header-block">

    <a href="<?= base_path() ?>/admin" class="btn-back">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M10 19l-7-7 7-7m-7 7h18"/>
      </svg>
      Volver
    </a>

    <div>
      <h1 class="page-title">Mensaje recibido</h1>
      <div class="page-subtitle">Vista detallada del mensaje enviado desde el formulario de contacto.</div>
    </div>

  </div>

  <!-- CARD -->
  <div class="card">

    <div class="info-grid">
      <div class="label">Fecha:</div>
      <div class="value"><?= e($msg['created_at']) ?></div>

      <div class="label">Nombre:</div>
      <div class="value"><?= e($msg['first_name'].' '.$msg['last_name']) ?></div>

      <div class="label">Email:</div>
      <div class="value">
        <?php if ($msg['email']): ?>
          <a href="mailto:<?= e($msg['email']) ?>" style="color:#1d4ed8; font-weight:700;">
            <?= e($msg['email']) ?>
          </a>
        <?php else: ?> — <?php endif; ?>
      </div>

      <div class="label">Celular:</div>
      <div class="value">
        <?php
          $raw = trim((string)$msg['phone']);
          $digits = preg_replace('/\D+/', '', $raw);
          if ($digits && preg_match('/^9\d{8}$/', $digits)) $digits = '51'.$digits;
        ?>
        <?php if ($digits): ?>
          <a href="https://wa.me/<?= $digits ?>" style="color:#1d4ed8; font-weight:700;">
            <?= e($raw) ?>
          </a>
        <?php else: ?> — <?php endif; ?>
      </div>
    </div>

    <div class="label" style="margin-top:20px;">Mensaje:</div>

    <div class="message-box">
      <?= nl2br(e($msg['message'])) ?>
    </div>

    <!-- BOTONERA -->
    <div class="actions">

      <?php if ((int)$msg['is_read'] === 0): ?>
        <a href="<?= base_path() ?>/admin/mensajes/marcar/<?= $msg['id'] ?>/leido"
           class="action-btn action-green">Marcar como leído</a>
      <?php else: ?>
        <a href="<?= base_path() ?>/admin/mensajes/marcar/<?= $msg['id'] ?>/no-leido"
           class="action-btn action-neutral">Marcar como NO leído</a>
      <?php endif; ?>

      <?php if ((int)$msg['is_saved'] === 0): ?>
        <a href="<?= base_path() ?>/admin/mensajes/guardar/<?= $msg['id'] ?>"
           class="action-btn action-yellow">Guardar</a>
      <?php else: ?>
        <a href="<?= base_path() ?>/admin/mensajes/desguardar/<?= $msg['id'] ?>"
           class="action-btn action-yellow">Quitar guardado</a>
      <?php endif; ?>

      <a href="<?= base_path() ?>/admin/mensajes/eliminar/<?= $msg['id'] ?>"
         onclick="return confirm('¿Eliminar este mensaje?')"
         class="action-btn action-danger">Eliminar</a>

      <a href="<?= base_path() ?>/admin"
         class="action-btn action-dark">Volver</a>

    </div>
  </div>

</div>

<script>
  // ALT + ← para volver rápido
  document.addEventListener('keydown', e => {
    if (e.altKey && e.key === 'ArrowLeft') {
      window.location.href = '<?= base_path() ?>/admin';
    }
  });
</script>

<?php require __DIR__.'/../partials/footer.php'; ?>