<?php
$host = getenv('DB_HOST') ?: 'db';
$db   = getenv('DB_NAME') ?: 'tasques';
$user = getenv('DB_USER') ?: 'user';
$pass = getenv('DB_PASS') ?: 'password';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['text'])) {
    $stmt = $pdo->prepare("INSERT INTO tasques (text, done) VALUES (?, 0)");
    $stmt->execute([trim($_POST['text'])]);
  }
  
  if (isset($_GET['done'])) {
    $stmt = $pdo->prepare("UPDATE tasques SET done = NOT done WHERE id = ?");
    $stmt->execute([$_GET['done']]);
  }

  $stmt = $pdo->query("SELECT * FROM tasques");
  $tasques = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  $error = $e->getMessage()Part 3 – Pipeline CI/CD amb GitHub Actions (3 punts)
GitHub Actions és l'eina de CI/CD integrada a GitHub. Permet definir workflows (fluxos de treball automatitzats) en fitxers YAML que s'executen en resposta a esdeveniments del repositori, com ara un push.
Cada vegada que s'activa un workflow, GitHub arrenca una màquina virtual nova (el runner), que executa els passos definits, i s’apaga en finalitzar.
En aquest apartat, acabarem construint un pipeline que construirà les imatge Docker dels nostres servidors, les publicarà al registre de contenidors de GitHub (GHCR), i les desplegarà automàticament a la instància EC2 d'AWS de la pràctica anterior.
El mateix docker-compose.yml que feu servir  en local, serveix per a producció: en local, Docker construeix la imatge localment (build) i exposa el port 8080, degut a l’override.  En producció, el workflow injectarà les variables IMAGE (la imatge del GHCR) i PORT=80 perquè es faci servir la imatge ja construïda.
Desplegament a Github Pages amb Actions (estàtic)
El primer que farem serà configurar el  desplegament a GitHub Pages del projecte estàtic mitjançant GitHub Actions i analitzarem el workflow que es genera.
Per fer això has de eliminar la configuració de desplegament que has fet prèviament a Settings → Pages. 
A continuació, ves a la pestanya Actions → New workflow i cerca ‘pages’ al catàleg. Selecciona Deploy static content to Pages (l'action oficial de GitHub). GitHub et mostrarà el fitxer YAML que generarà. Abans de desar-lo al repositori, cal modificar-lo: la plantilla usa per defecte path: '.' (l'arrel del repositori), però recordeu que els fitxers de la web estàtica del projecte es troben a la carpeta ./docs.  
Un cop feta aquesta modificació, feu clic a Commit changes. 
Atenció: aquesta acció crearà automàticament la carpeta .github/workflows/ al repositori (si no existia) i hi afegirà el fitxer deploy.yml.  Un cop desat, el workflow s'executarà automàticament. 
Fes git pull al Codespace per sincronitzar els canvis, i respon les següents preguntes:

11
Obre l’arxiu .github/workflows/deploy.yml i explica cadascun dels elements següents: 
El camp name
El bloc on (per quins esdeveniments s'activa?)
El bloc permissions (per què cal pages: write i id-token: write?)
El bloc concurrency, què fa, i cóm està configurat?
El bloc jobs, i el job deploy.  Quin dels dos noms és una paraula clau, i quin pot ser la paraula que nosaltres vulguem?
Què indica el camp environment?
d’on surt steps.deployment.outputs.page_url
Què indica el camp runs-on?


Indiqueu aquí la vostra resposta.

;
  $tasques = [];
}
?>
<!DOCTYPE html>
<html>
<head><title>Task Manager</title></head>
<body>
  <h1>Tasques</h1>
  <form method="POST">
    <input type="text" name="text" placeholder="Nova tasca..." required />
    <button type="submit">Afegir</button>
  </form>
  <ul>
    <?php foreach ($tasques as $t): ?>
      <li>
        <a href="?done=<?= $t['id'] ?>">
          <?= $t['done'] ? '✅' : '⭕' ?>
        </a>
        <?= htmlspecialchars($t['text']) ?>
      </li>
    <?php endforeach; ?>
  </ul>
</body>
</html>
