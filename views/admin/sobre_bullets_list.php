<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>

<?php
// $rows = [ ['id'=>..., 'position'=>..., 'text'=>...], ... ]
$base = rtrim(base_path(), '/');
?>

<div class="container py-5" style="max-width: 1160px;">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h1 class="h4 mb-1 fw-bold">Bullets de “Sobre Jambo”</h1>
      <div class="text-muted">Agrega, edita y ordena los bullets que se muestran en la Home.</div>
    </div>

    <div class="d-flex gap-2">
      <!-- 🔙 Atrás (historial) -->
      <button type="button" id="btnBack" class="btn btn-outline-secondary">
        ← Atrás
      </button>

      <!-- ✅ Volver (Dashboard) SIEMPRE -->
      <a href="<?= $base ?>/admin" class="btn btn-secondary">
        Volver
      </a>

      <!-- + Nuevo -->
      <a href="<?= $base ?>/admin/sobre/bullets/nuevo" class="btn btn-primary">+ Nuevo</a>
    </div>
  </div>

  <div class="alert alert-info">
    Administra, edita y <strong>ordena</strong> (campo <em>Posición</em>) los bullets que se muestran en la Home.
    <br>Se ordenan ascendente (0, 1, 2…).
  </div>

  <div class="table-responsive shadow-sm rounded-3 border">
    <table class="table align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th style="width:110px;">Posición</th>
          <th>Texto</th>
          <th class="text-end" style="width:230px;">Acciones</th>
        </tr>
      </thead>
      <tbody>
      <?php if (!empty($rows)): ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td class="fw-bold"><?= (int)$r['position'] ?></td>
            <td><?= e($r['text']) ?></td>
            <td class="text-end d-flex gap-2 justify-content-end">
              <a class="btn btn-sm btn-outline-primary"
                 href="<?= $base ?>/admin/sobre/bullets/editar/<?= (int)$r['id'] ?>">Editar</a>

              <a class="btn btn-sm btn-outline-danger"
                 href="<?= $base ?>/admin/sobre/bullets/eliminar/<?= (int)$r['id'] ?>"
                 onclick="return confirm('¿Eliminar este bullet?')">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="3" class="text-center text-muted py-4">Aún no hay bullets</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>

  <div class="mt-3 d-flex flex-wrap gap-2">
    <!-- 🔙 Atrás (historial) duplicado abajo por comodidad -->
    <button type="button" id="btnBack2" class="btn btn-outline-secondary">← Atrás</button>

    <!-- ✅ Volver (Dashboard) -->
    <a href="<?= $base ?>/admin" class="btn btn-secondary">Volver</a>

    <a href="<?= $base ?>/admin/sobre/slides" class="btn btn-outline-primary">Slides de “Sobre Jambo”</a>
  </div>
</div>

<script>
  // Atrás por historial (si existe). No afecta al botón "Volver" que va directo al dashboard.
  (function () {
    function goBack() {
      if (document.referrer && document.referrer.indexOf(location.host) !== -1 && history.length > 1) {
        history.back();
      } else {
        // Si no hay historial útil, NO hacemos nada aquí (para eso está el botón Volver)
        // Podrías descomentar lo de abajo si también quieres fallback automático:
        // window.location.href = '<?= $base ?>/admin';
      }
    }
    const b1 = document.getElementById('btnBack');
    const b2 = document.getElementById('btnBack2');
    b1 && b1.addEventListener('click', goBack);
    b2 && b2.addEventListener('click', goBack);
  })();
</script>

<?php require __DIR__.'/../partials/footer.php'; ?>