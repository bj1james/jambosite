<style>
/* =====================================================
   TARJETAS DE SERVICIOS — ESTILO PREMIUM / MODERNO
   ===================================================== */

.services-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 26px;
}

.service-card {
  position: relative;
  background: #ffffff;
  border-radius: 16px;
  overflow: hidden;
  border: 1px solid rgba(0,0,0,.06);
  box-shadow: 0 6px 18px rgba(0,0,0,.06);
  transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
  cursor: pointer;
}

.service-card:hover {
  transform: translateY(-4px);
  border-color: rgba(0,0,0,.12);
  box-shadow: 0 18px 38px rgba(0,0,0,.10);
}

/* Imagen superior */
.service-img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  object-position: center;
  background: #f5f7fa;
}

/* Contenido */
.service-body {
  padding: 18px 20px 24px;
}

.service-title {
  font-size: 1.12rem;
  font-weight: 800;
  color: #0f172a;
  margin-bottom: 6px;
}

.service-excerpt {
  font-size: .92rem;
  color: #4b5563;
  line-height: 1.45rem;
  height: 44px;
  overflow: hidden;
}

.service-link {
  margin-top: 14px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-weight: 700;
  text-decoration: none;
  color: var(--brand-accent, #0A84FF);
  transition: .15s;
}

.service-link svg {
  width: 16px;
  height: 16px;
}

.service-card:hover .service-link {
  gap: 10px;
}
</style>

<div class="services-grid">

<?php foreach ($services as $s):

  $img = $s['image_url'] ?? '';
  if ($img && !preg_match('#^https?://#i', $img)) {
    $img = base_path() . '/' . ltrim($img, '/');
  }
  $img = e($img);

  $slug = e($s['slug']);
  $title = e($s['title']);
  $excerpt = e($s['excerpt']);
?>

  <div class="service-card" onclick="window.location='<?= base_path() ?>/servicio/<?= $slug ?>'">
    <?php if ($img): ?>
      <img src="<?= $img ?>" class="service-img" alt="<?= $title ?>">
    <?php else: ?>
      <div class="service-img"></div>
    <?php endif; ?>

    <div class="service-body">
      <div class="service-title"><?= $title ?></div>
      <div class="service-excerpt"><?= $excerpt ?></div>

      <a href="<?= base_path() ?>/servicio/<?= $slug ?>" class="service-link">
        Ver más
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
      </a>
    </div>
  </div>

<?php endforeach; ?>

</div>