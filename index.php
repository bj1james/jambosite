<?php
require __DIR__ . '/bootstrap.php';

/* Normalización subcarpeta e index.php */
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');   // p.ej. /jambosite
if ($scriptDir && strpos($uri, $scriptDir) === 0) { $uri = substr($uri, strlen($scriptDir)); }
if (strpos($uri, '/index.php') === 0) { $uri = substr($uri, strlen('/index.php')); }
$uri = rtrim($uri, '/') ?: '/';

/* ========================= RUTAS PÚBLICAS ========================= */

if ($uri === '/') {
  $home = [
    'title'    => 'Consultoría y servicios de TI',
    'subtitle' => 'Impulsamos tu negocio con soluciones tecnológicas confiables y a medida.'
  ];
  $rows = $pdo->query("SELECT `key`,`value` FROM settings WHERE `key` IN ('home_title','home_subtitle')")->fetchAll();
  foreach ($rows as $r) {
    if ($r['key'] === 'home_title')    $home['title']    = $r['value'];
    if ($r['key'] === 'home_subtitle') $home['subtitle'] = $r['value'];
  }
  $slides       = $pdo->query("SELECT * FROM home_slides ORDER BY position ASC, id ASC")->fetchAll();
  $servicesHome = $pdo->query("SELECT * FROM services ORDER BY created_at DESC LIMIT 6")->fetchAll();
  view('home', ['home' => $home, 'slides' => $slides, 'servicesHome' => $servicesHome]);
  exit;
}

if ($uri === '/sobre-jambo' || $uri === '/sobre') {
  $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = ?");
  $stmt->execute(['sobre']);
  $page = $stmt->fetch() ?: ['title' => 'Sobre Jambo', 'content' => ''];

  $ps = $pdo->prepare("SELECT * FROM page_slides WHERE page_slug = ? ORDER BY position ASC, id ASC");
  $ps->execute(['sobre']);
  $slides = $ps->fetchAll();

  view('sobre', ['page' => $page, 'slides' => $slides]);
  exit;
}

if ($uri === '/contacto') {
  $ok = false; $error = null;
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = trim($_POST['first_name'] ?? '');
    $last  = trim($_POST['last_name']  ?? '');
    $email = trim($_POST['email']      ?? '');
    $phone = trim($_POST['phone']      ?? '');
    $msg   = trim($_POST['message']    ?? '');

    if ($first === '' || $last === '' || $email === '') {
      $error = 'Nombre, Apellido y Email son obligatorios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = 'Email no válido.';
    } else {
      $ins = $pdo->prepare("INSERT INTO contact_messages(first_name,last_name,email,phone,message) VALUES (?,?,?,?,?)");
      $ins->execute([$first, $last, $email, $phone, $msg]);
      $ok = true;
    }
  }
  view('contacto', ['ok' => $ok, 'error' => $error ?? null]);
  exit;
}

if ($uri === '/servicios') {
  $services = $pdo->query("SELECT * FROM services ORDER BY created_at DESC")->fetchAll();
  view('servicios', ['services' => $services]);
  exit;
}

if (preg_match('#^/servicio/([a-z0-9\-]+)$#', $uri, $m)) {
  $stmt = $pdo->prepare("SELECT * FROM services WHERE slug = ?");
  $stmt->execute([$m[1]]);
  $s = $stmt->fetch();
  if (!$s) { http_response_code(404); echo 'Servicio no encontrado'; exit; }
  view('servicio_detalle', ['s' => $s]);
  exit;
}

/* ========================= RUTAS ADMIN ========================= */

/* LOGIN — GET */
if ($uri === '/admin/login' && $_SERVER['REQUEST_METHOD'] === 'GET') {
  view('admin/login', ['error' => null]); exit;
}

/* LOGIN — POST */
if ($uri === '/admin/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  require __DIR__ . '/views/admin/login_handler.php'; exit;
}

/* LOGOUT */
if ($uri === '/admin/logout') {
  if (session_status() !== PHP_SESSION_ACTIVE) session_start();
  $_SESSION = [];
  if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time()-42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
  }
  session_destroy();
  redirect('/admin/login');
}

/* Dashboard */
if ($uri === '/admin') {
  require_admin();
  view('admin/dashboard'); exit;
}

/* --- Ajustes --- */
if ($uri === '/admin/ajustes') {
  require_admin();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rows = $pdo->query("SELECT `key`,`value` FROM settings")->fetchAll();
    $set = []; foreach ($rows as $r) { $set[$r['key']] = $r['value']; }
    $currentLogo = $set['logo_url'] ?? '';
    $pairs = [
      'site_name'     => trim($_POST['site_name'] ?? 'JAMBO'),
      'brand_primary' => trim($_POST['brand_primary'] ?? '#111111'),
      'brand_accent'  => trim($_POST['brand_accent']  ?? '#0A84FF'),
    ];
    try {
      $logoUploaded = handle_upload('logo_file');
      if ($logoUploaded)        { $pairs['logo_url'] = $logoUploaded; }
      elseif (!empty($_POST['logo_url'])) { $pairs['logo_url'] = trim($_POST['logo_url']); }
      else                       { $pairs['logo_url'] = $currentLogo; }

      foreach ($pairs as $k => $v) {
        $stmt = $pdo->prepare("INSERT INTO settings(`key`,`value`) VALUES(?,?) ON DUPLICATE KEY UPDATE `value`=VALUES(`value`)");
        $stmt->execute([$k,$v]);
      }
      redirect('/admin/ajustes');
    } catch (Exception $ex) { $error = $ex->getMessage(); }
  }
  $rows = $pdo->query("SELECT `key`,`value` FROM settings")->fetchAll();
  $set  = []; foreach ($rows as $r) { $set[$r['key']] = $r['value']; }
  view('admin/ajustes', ['set'=>$set, 'error'=>$error ?? null]); exit;
}

/* --- Home: cabecera --- */
if ($uri === '/admin/home') {
  require_admin();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['home_title'] ?? '');
    $sub   = trim($_POST['home_subtitle'] ?? '');
    foreach ([['home_title',$title],['home_subtitle',$sub]] as $kv) {
      $stmt = $pdo->prepare("INSERT INTO settings(`key`,`value`) VALUES(?,?) ON DUPLICATE KEY UPDATE `value`=VALUES(`value`)");
      $stmt->execute($kv);
    }
    redirect('/admin/home');
  }
  $rows = $pdo->query("SELECT `key`,`value` FROM settings WHERE `key` IN ('home_title','home_subtitle')")->fetchAll();
  $home = ['title'=>'','subtitle'=>''];
  foreach ($rows as $r) { if ($r['key']==='home_title') $home['title']=$r['value']; else $home['subtitle']=$r['value']; }
  view('admin/home_form', ['home'=>$home]); exit;
}

/* --- Home: slides --- */
if ($uri === '/admin/home/slides') {
  require_admin();
  $rows = $pdo->query("SELECT * FROM home_slides ORDER BY position ASC, id ASC")->fetchAll();
  view('admin/home_slides_list', ['rows'=>$rows]); exit;
}

if ($uri === '/admin/home/slides/nuevo' || preg_match('#^/admin/home/slides/editar/(\d+)$#',$uri,$m)) {
  require_admin();
  $editing = isset($m[1]); $row=null;
  if ($editing) {
    $stmt=$pdo->prepare("SELECT * FROM home_slides WHERE id=?"); $stmt->execute([$m[1]]);
    $row=$stmt->fetch(); if(!$row){ echo "No encontrado"; exit; }
  }
  if ($_SERVER['REQUEST_METHOD']==='POST') {
    $title=trim($_POST['title']??''); $caption=trim($_POST['caption']??''); $pos=(int)($_POST['position']??0);
    try {
      $img = $row['image_url'] ?? '';
      $up  = handle_upload('image_file');
      if    ($up)                     { $img = $up; }
      elseif(!empty($_POST['image_url'])) { $img = trim($_POST['image_url']); }
      if ($editing) {
        $stmt=$pdo->prepare("UPDATE home_slides SET image_url=?, title=?, caption=?, position=? WHERE id=?");
        $stmt->execute([$img,$title,$caption,$pos,$row['id']]);
      } else {
        $stmt=$pdo->prepare("INSERT INTO home_slides(image_url,title,caption,position) VALUES (?,?,?,?)");
        $stmt->execute([$img,$title,$caption,$pos]);
      }
      redirect('/admin/home/slides');
    } catch (Exception $ex) { $error=$ex->getMessage(); }
  }
  view('admin/home_slides_form', ['row'=>$row,'error'=>$error??null]); exit;
}

if (preg_match('#^/admin/home/slides/eliminar/(\d+)$#',$uri,$m)) {
  require_admin();
  $pdo->prepare("DELETE FROM home_slides WHERE id=?")->execute([$m[1]]);
  redirect('/admin/home/slides');
}

/* --- Sobre: contenido/slides/bullets --- */
if ($uri === '/admin/sobre') {
  require_admin();
  $stmt=$pdo->prepare("SELECT * FROM pages WHERE slug=?"); $stmt->execute(['sobre']); $page=$stmt->fetch();
  $bullets=['','',''];
  $rows=$pdo->query("SELECT `key`,`value` FROM settings WHERE `key` IN ('sobre_bullet1','sobre_bullet2','sobre_bullet3')")->fetchAll();
  foreach ($rows as $r){ if($r['key']==='sobre_bullet1')$bullets[0]=$r['value']; if($r['key']==='sobre_bullet2')$bullets[1]=$r['value']; if($r['key']==='sobre_bullet3')$bullets[2]=$r['value']; }
  if ($_SERVER['REQUEST_METHOD']==='POST') {
    $title=trim($_POST['title']??''); $content=trim($_POST['content']??'');
    $b1=trim($_POST['sobre_bullet1']??''); $b2=trim($_POST['sobre_bullet2']??''); $b3=trim($_POST['sobre_bullet3']??'');
    if ($page) { $pdo->prepare("UPDATE pages SET title=?, content=? WHERE id=?")->execute([$title,$content,$page['id']]); }
    else { $pdo->prepare("INSERT INTO pages(slug,title,content) VALUES (?,?,?)")->execute(['sobre',$title,$content]); }
    foreach ([['sobre_bullet1',$b1],['sobre_bullet2',$b2],['sobre_bullet3',$b3]] as $kv){
      $stmt=$pdo->prepare("INSERT INTO settings(`key`,`value`) VALUES(?,?) ON DUPLICATE KEY UPDATE `value`=VALUES(`value`)"); $stmt->execute($kv);
    }
    redirect('/admin/sobre');
  }
  if (!$page) $page=['title'=>'Sobre Jambo','content'=>''];
  view('admin/sobre_form', ['page'=>$page,'bullets'=>$bullets]); exit;
}

if ($uri === '/admin/sobre/slides') {
  require_admin();
  $stmt=$pdo->prepare("SELECT * FROM page_slides WHERE page_slug=? ORDER BY position ASC, id ASC");
  $stmt->execute(['sobre']); $list=$stmt->fetchAll();
  view('admin/sobre_slides_list', ['rows'=>$list]); exit;
}

if ($uri === '/admin/sobre/slides/nuevo' || preg_match('#^/admin/sobre/slides/editar/(\d+)$#',$uri,$m)) {
  require_admin();
  $editing=isset($m[1]); $row=null;
  if ($editing){ $stmt=$pdo->prepare("SELECT * FROM page_slides WHERE id=?"); $stmt->execute([$m[1]]); $row=$stmt->fetch(); if(!$row){echo"No encontrado";exit;} }
  if ($_SERVER['REQUEST_METHOD']==='POST'){
    $title=trim($_POST['title']??''); $caption=trim($_POST['caption']??''); $pos=(int)($_POST['position']??0);
    try{
      $img=$row['image_url']??''; $up=handle_upload('image_file');
      if($up){$img=$up;} elseif(!empty($_POST['image_url'])){$img=trim($_POST['image_url']);}
      if($editing){
        $pdo->prepare("UPDATE page_slides SET image_url=?, title=?, caption=?, position=? WHERE id=?")->execute([$img,$title,$caption,$pos,$row['id']]);
      } else {
        $pdo->prepare("INSERT INTO page_slides(page_slug,image_url,title,caption,position) VALUES (?,?,?,?,?)")->execute(['sobre',$img,$title,$caption,$pos]);
      }
      redirect('/admin/sobre/slides');
    }catch(Exception $ex){ $error=$ex->getMessage(); }
  }
  view('admin/sobre_slides_form',['row'=>$row,'error'=>$error??null]); exit;
}

if (preg_match('#^/admin/sobre/slides/eliminar/(\d+)$#',$uri,$m)) {
  require_admin(); $pdo->prepare("DELETE FROM page_slides WHERE id=?")->execute([$m[1]]); redirect('/admin/sobre/slides');
}

if ($uri === '/admin/sobre/bullets') {
  require_admin(); $stmt=$pdo->query("SELECT * FROM about_bullets ORDER BY position ASC, id ASC"); $rows=$stmt->fetchAll();
  view('admin/sobre_bullets_list',['rows'=>$rows]); exit;
}

if ($uri === '/admin/sobre/bullets/nuevo' || preg_match('#^/admin/sobre/bullets/editar/(\d+)$#',$uri,$m)) {
  require_admin(); $editing=isset($m[1]); $row=null;
  if($editing){ $stmt=$pdo->prepare("SELECT * FROM about_bullets WHERE id=?"); $stmt->execute([$m[1]]); $row=$stmt->fetch(); if(!$row){echo"No encontrado";exit;} }
  if($_SERVER['REQUEST_METHOD']==='POST'){
    $text=trim($_POST['text']??''); $pos=(int)($_POST['position']??0);
    if($text===''){ $error='El texto del bullet no puede estar vacío.'; }
    else{
      if($editing){ $stmt=$pdo->prepare("UPDATE about_bullets SET text=?, position=? WHERE id=?"); $stmt->execute([$text,$pos,$row['id']]); }
      else{ $stmt=$pdo->prepare("INSERT INTO about_bullets(text, position) VALUES(?, ?)"); $stmt->execute([$text,$pos]); }
      redirect('/admin/sobre/bullets');
    }
  }
  view('admin/sobre_bullets_form',['row'=>$row,'error'=>$error??null]); exit;
}

if (preg_match('#^/admin/sobre/bullets/eliminar/(\d+)$#',$uri,$m)) {
  require_admin(); $pdo->prepare("DELETE FROM about_bullets WHERE id=?")->execute([(int)$m[1]]); redirect('/admin/sobre/bullets');
}

/* --- Servicios (admin) --- */
if ($uri === '/admin/servicios') {
  require_admin(); $rows=$pdo->query("SELECT * FROM services ORDER BY updated_at DESC")->fetchAll();
  view('admin/servicios_list',['rows'=>$rows]); exit;
}

if ($uri === '/admin/servicios/nuevo' || preg_match('#^/admin/servicios/editar/(\d+)$#',$uri,$m)) {
  require_admin(); $editing=isset($m[1]); $row=null;
  if($editing){ $stmt=$pdo->prepare("SELECT * FROM services WHERE id=?"); $stmt->execute([$m[1]]); $row=$stmt->fetch(); if(!$row){echo"No encontrado";exit;} }
  if($_SERVER['REQUEST_METHOD']==='POST'){
    $title=trim($_POST['title']??''); $slug=trim($_POST['slug']??slugify($title)); $excerpt=trim($_POST['excerpt']??''); $content=trim($_POST['content']??'');
    $current=$row['image_url']??''; try{
      $up=handle_upload('image_file');
      if($up){$image_url=$up;} elseif(!empty($_POST['image_url'])){$image_url=trim($_POST['image_url']);} else {$image_url=$current;}
      if($editing){
        $pdo->prepare("UPDATE services SET title=?, slug=?, excerpt=?, content=?, image_url=? WHERE id=?")->execute([$title,$slug,$excerpt,$content,$image_url,$row['id']]);
      } else {
        $pdo->prepare("INSERT INTO services(title,slug,excerpt,content,image_url) VALUES (?,?,?,?,?)")->execute([$title,$slug,$excerpt,$content,$image_url]);
      }
      redirect('/admin/servicios');
    }catch(Exception $ex){ $error=$ex->getMessage(); }
  }
  view('admin/servicios_form',['row'=>$row,'error'=>$error??null]); exit;
}

if (preg_match('#^/admin/servicios/eliminar/(\d+)$#',$uri,$m)) {
  require_admin(); $pdo->prepare("DELETE FROM services WHERE id=?")->execute([$m[1]]); redirect('/admin/servicios');
}

/* --- Mensajes (admin) --- */
if ($uri === '/admin/mensajes') {
  require_admin();

  $solo = $_GET['solo'] ?? 'nuevos';
  $q    = trim($_GET['q'] ?? '');
  $per  = (int)($_GET['per'] ?? 10); if (!in_array($per,[10,20],true)) $per=10;
  $page = max(1,(int)($_GET['page'] ?? 1));

  $whereSearch=[]; $paramsSearch=[];
  if($q!==''){ $whereSearch[]="(CONCAT_WS(' ', COALESCE(first_name,''), COALESCE(last_name,'')) LIKE ? OR email LIKE ? OR phone LIKE ? OR message LIKE ?)"; $like="%{$q}%"; array_push($paramsSearch,$like,$like,$like,$like); }
  $whereSearchSql=$whereSearch?implode(' AND ',$whereSearch):'1=1';
  $whereListParts=[$whereSearchSql];
  if($solo==='guardados'){$whereListParts[]='COALESCE(is_saved,0)=1';}
  elseif($solo==='nuevos'){$whereListParts[]='COALESCE(is_saved,0)=0';}
  $whereListSql=implode(' AND ',$whereListParts);

  $stmt=$pdo->prepare("SELECT COUNT(*) AS c FROM contact_messages WHERE {$whereListSql}"); $stmt->execute($paramsSearch);
  $totalRows=(int)$stmt->fetchColumn(); $totalPages=max(1,(int)ceil($totalRows/$per)); if($page>$totalPages)$page=$totalPages; $offset=($page-1)*$per;

  $sqlList="SELECT id, first_name, last_name, email, phone, message, created_at, COALESCE(is_read,0) AS is_read, COALESCE(is_saved,0) AS is_saved, read_at
            FROM contact_messages WHERE {$whereListSql} ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
  $stmt=$pdo->prepare($sqlList);
  foreach($paramsSearch as $i=>$val){ $stmt->bindValue($i+1,$val,PDO::PARAM_STR); }
  $stmt->bindValue(':limit',$per,PDO::PARAM_INT); $stmt->bindValue(':offset',$offset,PDO::PARAM_INT); $stmt->execute();
  $rows=$stmt->fetchAll();

  $counts=['nuevos'=>0,'guardados'=>0,'todos'=>0];
  $stmt=$pdo->prepare("SELECT COUNT(*) FROM contact_messages WHERE {$whereSearchSql}"); $stmt->execute($paramsSearch); $counts['todos']=(int)$stmt->fetchColumn();
  $stmt=$pdo->prepare("SELECT COUNT(*) FROM contact_messages WHERE {$whereSearchSql} AND COALESCE(is_saved,0)=1"); $stmt->execute($paramsSearch); $counts['guardados']=(int)$stmt->fetchColumn();
  $stmt=$pdo->prepare("SELECT COUNT(*) FROM contact_messages WHERE {$whereSearchSql} AND COALESCE(is_saved,0)=0"); $stmt->execute($paramsSearch); $counts['nuevos']=(int)$stmt->fetchColumn();

  view('admin/mensajes_list', ['rows'=>$rows,'solo'=>$solo,'q'=>$q,'per'=>$per,'page'=>$page,'totalRows'=>$totalRows,'totalPages'=>$totalPages,'counts'=>$counts]);
  exit;
}

if (preg_match('#^/admin/mensajes/ver/(\d+)$#',$uri,$m)) {
  require_admin(); $id=(int)$m[1];
  $stmt=$pdo->prepare("SELECT id, first_name, last_name, email, phone, message, created_at, COALESCE(is_read,0) AS is_read, COALESCE(is_saved,0) AS is_saved, read_at FROM contact_messages WHERE id=?");
  $stmt->execute([$id]); $msg=$stmt->fetch(); if(!$msg){ echo "No encontrado"; exit; }
  if((int)$msg['is_read']===0){ $pdo->prepare("UPDATE contact_messages SET is_read=1, read_at=NOW() WHERE id=?")->execute([$id]); $msg['is_read']=1; }
  view('admin/mensaje_ver',['msg'=>$msg]); exit;
}

if (preg_match('#^/admin/mensajes/marcar/(\d+)/(leido|no-leido)$#',$uri,$m)) {
  require_admin(); $id=(int)$m[1]; $estado=$m[2];
  if($estado==='leido'){ $pdo->prepare("UPDATE contact_messages SET is_read=1, read_at=NOW() WHERE id=?")->execute([$id]); }
  else{ $pdo->prepare("UPDATE contact_messages SET is_read=0, read_at=NULL WHERE id=?")->execute([$id]); }
  redirect('/admin/mensajes');
}

if (preg_match('#^/admin/mensajes/guardar/(\d+)$#',$uri,$m)) {
  require_admin(); $pdo->prepare("UPDATE contact_messages SET is_saved=1 WHERE id=?")->execute([(int)$m[1]]); redirect('/admin/mensajes?solo=guardados');
}

if (preg_match('#^/admin/mensajes/desguardar/(\d+)$#',$uri,$m)) {
  require_admin(); $pdo->prepare("UPDATE contact_messages SET is_saved=0 WHERE id=?")->execute([(int)$m[1]]); redirect('/admin/mensajes');
}

if (preg_match('#^/admin/mensajes/eliminar/(\d+)$#',$uri,$m)) {
  require_admin(); $pdo->prepare("DELETE FROM contact_messages WHERE id=?")->execute([(int)$m[1]]); redirect('/admin/mensajes');
}

/* 404 */
http_response_code(404); echo 'Página no encontrada';