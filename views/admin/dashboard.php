<?php require __DIR__.'/../partials/head.php'; ?>
<?php require __DIR__.'/../partials/header.php'; ?>

<style>
  :root{
    --accent: var(--brand-accent, #00A3FF);
    --bg-0: #070b14;
    --bg-1: #0b1220;
    --fg-0: #e6edf7;
    --fg-1: #98a6bd;
    --card: #0e1526;
    --line: rgba(255,255,255,.08);
    --line-2: rgba(255,255,255,.16);
    --ok-0: #7ecb4c;
  }

  /* ======= Lienzo (fondo tipo login) ======= */
  body{
    background:
      radial-gradient(1200px 600px at 10% -10%, rgba(0,163,255,.10) 0, transparent 60%),
      radial-gradient(1000px 520px at 90% -20%, rgba(0,163,255,.08) 0, transparent 55%),
      linear-gradient(180deg, var(--bg-0), var(--bg-1));
    color: var(--fg-0);
  }
  .grid-bg{
    position: fixed; inset: 0; pointer-events: none; z-index: 0;
    background-image:
      linear-gradient(var(--line) 1px, transparent 1px),
      linear-gradient(90deg, var(--line) 1px, transparent 1px);
    background-size: 32px 32px, 32px 32px;
    mask-image: radial-gradient(900px 600px at 50% 50%, #000 0, #000 60%, transparent 100%);
    opacity: .9;
  }

  /* ======= Contenedor ======= */
  .dash-shell{
    position: relative; z-index: 1;
    max-width: 1200px; margin: 28px auto 56px; padding: 0 16px;
  }

  /* Encabezado de la página */
  .dash-head{
    display: flex; align-items: start; justify-content: space-between; gap: 12px;
    margin-bottom: 18px;
  }
  .dash-title{
    font-size: clamp(1.6rem, 3vw, 2rem);
    font-weight: 900; letter-spacing: -.3px; color:#fff; margin:0 0 4px;
    text-shadow: 0 2px 4px rgba(0,0,0,.18);
  }
  .dash-sub{ color:#9fb3cf; margin:0; }

  .btn-logout{
    display:inline-flex; align-items:center; gap:8px;
    padding:10px 12px; border-radius:10px; text-decoration:none;
    border:1px solid rgba(255,87,87,.45);
    background: linear-gradient(180deg, rgba(255,87,87,.9), rgba(236,68,68,.9));
    color:#fff; font-weight:900;
    box-shadow: 0 8px 22px rgba(255,87,87,.25), inset 0 1px rgba(255,255,255,.35);
    transition: transform .12s ease, filter .12s ease;
  }
  .btn-logout:hover{ filter:brightness(.98); transform: translateY(-1px); }

  /* ======= Cards contenedoras ======= */
  .card-box{
    background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.03));
    border: 1px solid var(--line-2);
    border-radius: 16px;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    box-shadow:
      0 10px 30px rgba(0,0,0,.40),
      inset 0 1px rgba(255,255,255,.12);
    padding: 18px;
    margin-bottom: 14px;
  }
  .card-title{
    display:flex; align-items:center; gap:10px;
    color:#cfe7ff; font-weight:900; letter-spacing:.1px; margin:0 0 12px;
  }
  .chip{
    display:inline-flex; align-items:center; gap:6px;
    padding:6px 10px; border-radius:999px; font-size:.72rem; font-weight:800;
    border:1px solid var(--line-2); color:#a9b6cd; background: rgba(255,255,255,.04);
  }
  .chip::before{
    content:""; width:8px; height:8px; border-radius:50%;
    background: radial-gradient(circle, rgba(0,163,255,1) 0, rgba(0,163,255,.0) 70%);
    box-shadow: 0 0 10px rgba(0,163,255,.8);
  }

  /* ======= Grid de accesos ======= */
  .grid{
    display:grid; gap: 12px;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  }

  .nav-card{
    position:relative;
    display:flex; align-items:center; gap:12px;
    padding:14px; border-radius:14px;
    border:1px solid var(--line-2);
    background: rgba(255,255,255,.02);
    text-decoration:none; color:#d9e6ff; font-weight:800;
    transition: transform .12s ease, box-shadow .2s ease, border-color .12s ease, background .2s ease;
  }
  .nav-card:hover{
    transform: translateY(-2px);
    border-color: rgba(0,163,255,.55);
    background: rgba(0,163,255,.04);
    box-shadow: 0 10px 24px rgba(0,163,255,.20);
  }

  .icon{
    flex: 0 0 38px; width:38px; height:38px; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    border:1px solid rgba(255,255,255,.18);
    background: linear-gradient(180deg, rgba(255,255,255,.12), rgba(255,255,255,.04));
    box-shadow: inset 0 1px rgba(255,255,255,.45);
    color: var(--accent);
  }
  .icon svg{ width:18px; height:18px; }

  .nav-meta{ color:#9fb3cf; font-weight:600; font-size:.9rem; }

  /* ===== Pie mínimo dentro del panel ===== */
  .dash-foot{
    margin-top:18px; color:#7f92b1; font-size:.85rem; text-align:center;
  }

  /* ===== Mini “estatus” con progress bar Win7 (opcional) ===== */
  .status{
    display:flex; align-items:center; gap:10px; margin-top: 6px; color:#cfe7ff; font-weight:800;
  }
  .win7-shell{ flex:1 1 auto; padding:4px; border-radius:8px; background: linear-gradient(#d6d6d6,#c4c4c4); border:1px solid #9aa0a6; box-shadow: inset 0 1px #fff, 0 2px 8px rgba(0,0,0,.25); }
  .win7-bar{ position:relative; height:14px; border-radius:5px; overflow:hidden; background: linear-gradient(#7ecb4c, #5aa436); box-shadow: inset 0 -1px 0 rgba(0,0,0,.25), inset 0 1px 0 rgba(255,255,255,.35); }
  .win7-bar::before{ content:""; position:absolute; inset:0; background: linear-gradient(to bottom, rgba(255,255,255,.55), rgba(255,255,255,0) 60%); pointer-events:none; }
  .win7-bar .marquee{ position:absolute; top:0; bottom:0; width:35%; background: linear-gradient(90deg, rgba(255,255,255,.15), rgba(255,255,255,.55), rgba(255,255,255,.15)); animation: win7 1.2s linear infinite; filter: blur(.2px); }
  @keyframes win7{ from{ transform: translateX(-100%);} to{ transform: translateX(300%);} }
</style>

<div class="grid-bg"></div>

<div class="dash-shell">

  <!-- Encabezado + cerrar sesión -->
  <div class="dash-head">
    <div>
      <h1 class="dash-title">Panel de Administración</h1>
      <p class="dash-sub">Gestiona el contenido del sitio con una interfaz clara y con acentos cyber.</p>
    </div>

    <a class="btn-logout" href="<?= base_path() ?>/admin/logout">
      <!-- icono logout -->
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#fff" width="16" height="16"><path d="M13 3a1 1 0 1 0-2 0v8a1 1 0 0 0 2 0V3Zm2.293 3.293a1 1 0 0 0 0 1.414L17.586 9H9a1 1 0 1 0 0 2h8.586l-2.293 2.293a1 1 0 1 0 1.414 1.414l4-4a1 1 0 0 0 0-1.414l-4-4a1 1 0 0 0-1.414 0Z"/><path d="M11 19a1 1 0 1 0-2 0v2a1 1 0 1 0 2 0v-2Z"/></svg>
      Cerrar sesión
    </a>
  </div>

  <!-- Acciones principales -->
  <section class="card-box">
    <div class="card-title"><span class="chip">Acciones principales</span></div>
    <div class="grid">

      <a class="nav-card" href="<?= base_path() ?>/admin/servicios">
        <span class="icon" aria-hidden="true">
          <!-- services -->
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M6 2h6a2 2 0 0 1 2 2v6H4V4a2 2 0 0 1 2-2Zm0 12h6a2 2 0 0 1 2 2v6H4v-6a2 2 0 0 1 2-2Zm10-4h2a2 2 0 0 1 2 2v2h-4V10Zm0 6h4v2a2 2 0 0 1-2 2h-2v-4Z"/></svg>
        </span>
        <div>
          Gestionar servicios
          <div class="nav-meta">Crear, editar y administrar servicios.</div>
        </div>
      </a>

      <a class="nav-card" href="<?= base_path() ?>/admin/mensajes">
        <span class="icon" aria-hidden="true">
          <!-- inbox -->
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M20 4H4a2 2 0 0 0-2 2v9a3 3 0 0 0 3 3h4.382a2 2 0 0 0 1.447-.618L12 16l1.171 1.382A2 2 0 0 0 14.618 18H19a3 3 0 0 0 3-3V6a2 2 0 0 0-2-2Zm0 2v5.586l-2.707-2.707a1 1 0 0 0-1.414 0L12 13.758 8.121 9.879a1 1 0 0 0-1.414 0L4 12.586V6h16Z"/></svg>
        </span>
        <div>
          Bandeja de mensajes
          <div class="nav-meta">Leer, clasificar y responder contactos.</div>
        </div>
      </a>

      <a class="nav-card" href="<?= base_path() ?>/admin/ajustes">
        <span class="icon" aria-hidden="true">
          <!-- settings -->
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M19.14 12.936a7.968 7.968 0 0 0 .06-.936 7.968 7.968 0 0 0-.06-.936l2.036-1.58a.5.5 0 0 0 .12-.64l-1.93-3.342a.5.5 0 0 0-.6-.22l-2.4.96a8.067 8.067 0 0 0-1.62-.936l-.36-2.52A.5.5 0 0 0 12.9 1h-3.8a.5.5 0 0 0-.5.42l-.36 2.52a8.067 8.067 0 0 0-1.62.936l-2.4-.96a.5.5 0 0 0-.6.22L.69 7.42a.5.5 0 0 0 .12.64l2.036 1.58c-.04.308-.06.62-.06.936s.02.628.06.936L.81 13.92a.5.5 0 0 0-.12.64l1.93 3.342a.5.5 0 0 0 .6.22l2.4-.96c.5.374 1.04.69 1.62.936l.36 2.52a.5.5 0 0 0 .5.42h3.8a.5.5 0 0 0 .5-.42l.36-2.52c.58-.246 1.12-.562 1.62-.936l2.4.96a.5.5 0 0 0 .6-.22l1.93-3.342a.5.5 0 0 0-.12-.64l-2.036-1.58ZM11 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z"/></svg>
        </span>
        <div>
          Ajustes del sitio
          <div class="nav-meta">Nombre, logo y colores de identidad.</div>
        </div>
      </a>
    </div>

    <!-- Estatus (opcional) -->
    <div class="status" title="Procesos de mantenimiento">
      <div class="win7-shell">
        <div class="win7-bar"><span class="marquee"></span></div>
      </div>
      <div>Servicios OK</div>
    </div>
  </section>

  <!-- Páginas del sitio -->
  <section class="card-box">
    <div class="card-title"><span class="chip">Páginas del sitio</span></div>
    <div class="grid">

      <a class="nav-card" href="<?= base_path() ?>/admin/home">
        <span class="icon" aria-hidden="true">
          <!-- home -->
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 3 2 12h3v8h6v-5h2v5h6v-8h3L12 3Z"/></svg>
        </span>
        <div>
          Editar Home
          <div class="nav-meta">Título y subtítulo (hero).</div>
        </div>
      </a>

      <a class="nav-card" href="<?= base_path() ?>/admin/home/slides">
        <span class="icon" aria-hidden="true">
          <!-- images -->
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M21 5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5Zm-2 0v10H5V5h14ZM8 7a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm11 6-3.5-4.5L12 13l-2-2-4 4h13Z"/></svg>
        </span>
        <div>
          Slides de Home
          <div class="nav-meta">Carrusel del hero.</div>
        </div>
      </a>

      <a class="nav-card" href="<?= base_path() ?>/admin/sobre">
        <span class="icon" aria-hidden="true">
          <!-- info -->
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2a10 10 0 1 0 10 10A10.012 10.012 0 0 0 12 2Zm1 15h-2v-6h2Zm0-8h-2V7h2Z"/></svg>
        </span>
        <div>
          Editar “Sobre Jambo”
          <div class="nav-meta">Contenido de la página.</div>
        </div>
      </a>

      <a class="nav-card" href="<?= base_path() ?>/admin/sobre/slides">
        <span class="icon" aria-hidden="true">
          <!-- image -->
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M21 5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5Zm-2 0v10H5V5h14ZM8 7a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm11 6-3.5-4.5L12 13l-2-2-4 4h13Z"/></svg>
        </span>
        <div>
          Slides de “Sobre Jambo”
          <div class="nav-meta">Carrusel de la sección Nosotros.</div>
        </div>
      </a>

      <a class="nav-card" href="<?= base_path() ?>/admin/sobre/bullets">
        <span class="icon" aria-hidden="true">
          <!-- list -->
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M4 5h2v2H4V5Zm0 6h2v2H4v-2Zm0 6h2v2H4v-2Zm4-12h12v2H8V5Zm0 6h12v2H8v-2Zm0 6h12v2H8v-2Z"/></svg>
        </span>
        <div>
          Bullets de “Sobre Jambo”
          <div class="nav-meta">Agregar, editar, ordenar, eliminar.</div>
        </div>
      </a>

    </div>
  </section>

  <div class="dash-foot">Interfaz cyber segura • Sesión activa</div>
</div>

<?php require __DIR__.'/../partials/footer.php'; ?>