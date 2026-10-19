<?php
// views/admin/login.php — Reemplaza COMPLETO por este archivo.
// Supone que ya tienes base_path() y que tu ruta POST /admin/login existe.
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Acceso | Admin</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    :root{
      --bg-0:#0b1220;        /* fondo base */
      --bg-1:#0e1422;        /* gradiente */
      --grid:#1a2636;        /* líneas del grid */
      --card:#121a2a;        /* base card */
      --line:rgba(255,255,255,.14);
      --line2:rgba(255,255,255,.22);
      --text:#e6edf7;
      --muted:#9fb3cf;
      --accent:#0A84FF;      /* acento JAMBO */
      --accent-2:#4ac7ff;    /* brillo */
      --danger:#ff8b8b;
      --ok:#66d18f;
    }

    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0; font-family:system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif; color:var(--text);
      background:
        radial-gradient(1200px 520px at 8% -10%, rgba(10,132,255,.12) 0, transparent 60%),
        radial-gradient(1000px 520px at 100% -20%, rgba(10,132,255,.10) 0, transparent 55%),
        linear-gradient(180deg, var(--bg-0), var(--bg-1));
      overflow:hidden;
    }

    /* Grid de fondo */
    .grid-bg{
      position:fixed; inset:0; pointer-events:none; z-index:0;
      background-image:
        linear-gradient(var(--grid) 1px, transparent 1px),
        linear-gradient(90deg, var(--grid) 1px, transparent 1px);
      background-size:32px 32px, 32px 32px;
      opacity:.35;
      mask-image: radial-gradient(900px 600px at 50% 40%, #000 0, #000 60%, transparent 100%);
    }

    /* Contenedor */
    .shell{
      position:relative; z-index:1;
      min-height:100%; display:grid; place-items:center; padding:32px 16px;
    }

    /* Tarjeta */
    .card{
      width:100%; max-width:420px;
      background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.03));
      border:1px solid var(--line);
      border-radius:16px;
      box-shadow: 0 16px 40px rgba(0,0,0,.40), inset 0 1px rgba(255,255,255,.10);
      backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
      padding:22px 20px 18px;
    }

    .brand{
      display:flex; align-items:center; justify-content:center; gap:10px; margin-bottom:8px;
    }
    .chip{
      display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:999px;
      border:1px solid var(--line); background:rgba(255,255,255,.05); color:#cfe7ff; font-weight:800; font-size:.78rem;
    }
    .chip::before{
      content:""; width:8px; height:8px; border-radius:50%;
      background: radial-gradient(circle, var(--accent) 0, rgba(10,132,255,0) 70%);
      box-shadow: 0 0 10px var(--accent);
    }
    .title{ text-align:center; margin:6px 0 14px; font-weight:900; letter-spacing:.2px; }

    /* Error */
    .error{
      background:#2a1930; border:1px solid rgba(255,87,87,.45); color:#ffd9d9;
      padding:10px 12px; border-radius:10px; margin-bottom:10px; font-weight:700; text-align:center;
    }

    label{ display:block; margin:10px 0 6px; color:#cfe7ff; font-weight:800; font-size:.92rem; }
    .ctrl{
      width:100%; display:flex; align-items:center; gap:8px;
      background:#0a1224; border:1px solid var(--line); border-radius:12px; padding:10px 12px; color:var(--text);
      transition: border-color .2s ease, box-shadow .2s ease;
    }
    .ctrl:focus-within{
      border-color: rgba(10,132,255,.7);
      box-shadow: 0 0 0 3px rgba(10,132,255,.18), 0 0 16px rgba(10,132,255,.28);
    }
    .ctrl input{
      width:100%; border:0; outline:0; background:transparent; color:inherit; font-size:1rem;
    }

    .row-inline{ display:grid; grid-template-columns: 1fr auto; gap:8px; align-items:center; }
    .toggle{ user-select:none; cursor:pointer; color:#8ea6c8; font-weight:800; font-size:.86rem; }
    .toggle:hover{ color:#cfe7ff; }

    .actions{ margin-top:14px; }
    .btn{
      width:100%; padding:12px 16px; border-radius:12px; border:1px solid rgba(10,132,255,.65); cursor:pointer;
      background: linear-gradient(180deg, rgba(74,199,255,1), rgba(10,132,255,1));
      color:#ffffff; font-weight:900; letter-spacing:.2px;
      box-shadow: 0 12px 30px rgba(10,132,255,.25), inset 0 1px rgba(255,255,255,.55);
      transition: transform .14s ease, filter .14s ease;
    }
    .btn:hover{ filter:brightness(.98); transform: translateY(-1px); }
    .btn:disabled{ opacity:.6; cursor:not-allowed; }

    /* Barra de progreso estilo macOS (indeterminada) */
    .progress-wrap{ display:none; gap:10px; align-items:center; margin-top:12px; color:#cfe7ff; font-weight:800; }
    .progress-wrap.active{ display:flex; }
    .mac-track{
      position:relative; flex:1 1 auto; height:12px; border-radius:999px; overflow:hidden;
      background: linear-gradient(180deg, #d6d6d6, #c4c4c4); border:1px solid #9aa0a6;
      box-shadow: inset 0 1px #ffffff, 0 2px 8px rgba(0,0,0,.25);
    }
    .mac-bar{
      position:absolute; inset:2px; border-radius:999px;
      background: linear-gradient(180deg, #67b3ff 0%, #4396ff 100%);
      box-shadow: inset 0 1px rgba(255,255,255,.6), inset 0 -1px rgba(0,0,0,.18);
      overflow:hidden;
    }
    .mac-sheen{
      position:absolute; inset:0;
      background: linear-gradient(90deg, rgba(255,255,255,.0) 0%, rgba(255,255,255,.55) 50%, rgba(255,255,255,0) 100%);
      width:30%; animation: sheen 1.2s linear infinite;
      filter: blur(.2px);
    }
    @keyframes sheen{
      from{ transform: translateX(-100%); }
      to  { transform: translateX(400%); }
    }
    .progress-text{ min-width:140px; text-align:right; font-variant-numeric: tabular-nums; color:#dbe9ff; }

    /* Meta inferior */
    .foot{ margin-top:14px; padding-top:10px; border-top:1px dashed var(--line); color:var(--muted); font-size:.85rem; text-align:center; }

    /* Responsive fino */
    @media (max-width: 480px){
      .card{ padding:18px 14px; }
    }
  </style>
</head>
<body>
  <div class="grid-bg"></div>

  <main class="shell">
    <section class="card" role="form" aria-labelledby="titleLogin">
      <div class="brand">
        <span class="chip" title="Zona segura">Secure</span>
      </div>
      <h1 id="titleLogin" class="title">Acceso</h1>

      <!-- Mensaje de error del backend (opcional) -->
      <?php if (!empty($error ?? null)): ?>
        <div class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
      <?php endif; ?>

      <!-- FORM -->
      <form action="<?= base_path() ?>/admin/login" method="post" id="loginForm" novalidate>
        <label for="user">Usuario</label>
        <div class="ctrl">
          <!-- ícono user -->
          <svg width="18" height="18" viewBox="0 0 24 24" fill="#8ea6c8" aria-hidden="true">
            <path d="M12 2a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm-7 18a7 7 0 1 1 14 0H5Z"/>
          </svg>
          <input id="user" name="username" autocomplete="username" required placeholder="tu.usuario">
        </div>

        <label for="pass">Contraseña</label>
        <div class="ctrl row-inline">
          <div style="display:flex;align-items:center;gap:8px;flex:1 1 auto;">
            <!-- ícono lock -->
            <svg width="18" height="18" viewBox="0 0 24 24" fill="#8ea6c8" aria-hidden="true">
              <path d="M12 1a5 5 0 0 0-5 5v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5Zm-3 8V6a3 3 0 1 1 6 0v3H9Z"/>
            </svg>
            <input id="pass" type="password" name="password" autocomplete="current-password" required placeholder="••••••••">
          </div>
          <span class="toggle" id="togglePass" role="button" aria-controls="pass">Mostrar</span>
        </div>

        <div class="actions">
          <button type="submit" class="btn" id="btnLogin">Ingresar</button>
       
        <div class="progress-wrap" id="progressBox" aria-live="polite">
          <div class="mac-track" aria-hidden="true">
            <div class="mac-bar">
              <div class="mac-sheen"></div>
            </div>
          </div>
          <div class="progress-text" id="pText">Iniciando sesión…</div>
        </div>

        <div class="foot">Zona segura • Conexión cifrada</div>
      </form>
    </section>
  </main>

  <script>
    (function(){
      const pass   = document.getElementById('pass');
      const toggle = document.getElementById('togglePass');
      const form   = document.getElementById('loginForm');
      const btn    = document.getElementById('btnLogin');
      const box    = document.getElementById('progressBox');
      const pText  = document.getElementById('pText');

      // Mostrar / ocultar contraseña
      toggle?.addEventListener('click', () => {
        const is = pass.type === 'password';
        pass.type = is ? 'text' : 'password';
        toggle.textContent = is ? 'Ocultar' : 'Mostrar';
      });

      // Progreso macOS al enviar
      form?.addEventListener('submit', (e) => {
        // Valida HTML5
        if (!form.checkValidity()) { form.reportValidity?.(); return; }

        // Muestra barra macOS y retrasa un instante para dejar ver la animación
        e.preventDefault();
        btn.disabled = true;
        box.classList.add('active');

        // Mensaje animable (si quisieras, podrías rotarlo)
        pText.textContent = 'Iniciando sesión…';

        // da ~1000ms de feedback y envía al backend real
        setTimeout(() => {
          form.submit();
        }, 1000);
      });
    })();
  </script>
</body>
</html>