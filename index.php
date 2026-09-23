<?php
// Lotería Mexicana — index.php
// Regla de oro: las 54 cartas VIVEN en un arreglo PHP 9x6.
$nombres = [
  ['EL GALLO', 'EL DIABLITO', 'LA DAMA', 'EL CATRÍN', 'EL PARAGUAS', 'LA SIRENA'],
  ['LA ESCALERA', 'LA BOTELLA', 'EL BARRIL', 'EL ÁRBOL', 'EL MELÓN', 'EL VALIENTE'],
  ['EL GORRITO', 'LA MUERTE', 'LA PERA', 'LA BANDERA', 'EL BANDOLÓN', 'EL VIOLONCELLO'],
  ['LA GARZA', 'EL PÁJARO', 'LA MANO', 'LA BOTA', 'LA LUNA', 'EL COTORRO'],
  ['EL BORRACHO', 'EL NEGRITO', 'EL CORAZÓN', 'LA SANDÍA', 'EL TAMBOR', 'EL CAMARÓN'],
  ['LAS JARAS', 'EL MÚSICO', 'LA ARAÑA', 'EL SOLDADO', 'LA ESTRELLA', 'EL CAZO'],
  ['EL MUNDO', 'EL APACHE', 'EL NOPAL', 'EL ALACRÁN', 'LA ROSA', 'LA CALAVERA'],
  ['LA CAMPANA', 'EL CANTARITO', 'EL VENADO', 'EL SOL', 'LA CORONA', 'LA CHALUPA'],
  ['EL PINO', 'EL PESCADO', 'LA PALMA', 'LA MACETA', 'EL ARPA', 'LA RANA'],
];

$cartas = [];
$n = 1;
foreach ($nombres as $f => $fila) {
  $r = [];
  foreach ($fila as $c => $nombre) {
    $r[] = ['nombre' => $nombre, 'num' => $n, 'img' => "img/cartas/$n.jpg"];
    $n++;
  }
  $cartas[] = $r;
}

// Mezclar conservando 9x6: shuffle plano y reagrupar.
$mezclado = isset($_GET['mezclar']) && $_GET['mezclar'] === '1';
if ($mezclado) {
  $plano = [];
  foreach ($cartas as $fila) { foreach ($fila as $c) { $plano[] = $c; } }
  shuffle($plano);
  $cartas = array_chunk($plano, 6);
}

// Consulta con validación en SERVIDOR.
$filaIn = filter_input(INPUT_POST, 'fila', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 9]]);
$colIn  = filter_input(INPUT_POST, 'columna', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 6]]);
$consulto = ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
$resultado = null;
$error = null;
if ($consulto) {
  if ($filaIn === false || $filaIn === null || $colIn === false || $colIn === null) {
    $error = 'Ingresa fila (1-9) y columna (1-6) con números válidos.';
  } else {
    $resultado = $cartas[$filaIn - 1][$colIn - 1];
    $resultado['fila'] = $filaIn;
    $resultado['columna'] = $colIn;
  }
}

function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lotería Mexicana — Nuestras raíces, en cada carta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="assets/css/estilos.css" rel="stylesheet">
</head>
<body id="inicio">

<header class="hero">
  <nav class="navbar navbar-expand-lg navbar-dark hero-nav">
    <div class="container">
      <a class="navbar-brand brand" href="#inicio">
        <span class="brand-glyph" aria-hidden="true">◆</span>
        <span class="brand-text">
          <strong>Lotería Mexicana</strong>
          <small>Nuestras raíces, en cada carta</small>
        </span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Menú">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="menu">
        <ul class="navbar-nav gap-2">
          <li class="nav-item"><a class="nav-link active" href="#inicio">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="#loteria">Lotería</a></li>
          <li class="nav-item"><a class="nav-link" href="#consulta">Consulta</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container hero-body">
    <div class="row align-items-end g-3">
      <div class="col-lg-8">
        <p class="hero-kicker">Proyecto · PHP · Arreglos bidimensionales</p>
        <h1 class="hero-title">La baraja completa, <em>en una sola tabla viva</em></h1>
        <p class="hero-sub">54 cartas en un arreglo 9 × 6. Mezcla, pasa el mouse para revelar el nombre y consulta por fila y columna con validación en servidor.</p>
      </div>
      <div class="col-lg-4 hero-actions">
        <a class="btn btn-maiz" id="btn-mezclar" href="?mezclar=1#loteria">Mezclar cartas</a>
        <a class="btn btn-ghost" href="index.php#loteria">Ordenar</a>
      </div>
    </div>
  </div>
</header>

<main class="container py-4">
  <div class="row g-4">
    <section id="loteria" class="col-lg-8">
      <!-- Panel de Control: Cantador de Lotería con Audio -->
      <div class="card panel panel-cantador mb-3">
        <div class="card-body">
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
              <h3 class="h5 mb-1 panel-title">
                <span class="dot" aria-hidden="true">🔊</span> Cantador de Lotería
              </h3>
              <p class="small text-muted mb-0">Canta cada una de las 54 cartas con audio y las resalta en vivo en el tablero.</p>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2">
              <select id="cantador-velocidad" class="form-select form-select-sm w-auto" title="Tiempo entre cartas">
                <option value="2500">Rápido (2.5s)</option>
                <option value="3800" selected>Normal (3.8s)</option>
                <option value="5500">Pausado (5.5s)</option>
              </select>
              <button id="btn-iniciar-partida" class="btn btn-maiz btn-sm fw-bold px-3">
                <span id="icono-play">▶</span> Comenzar partida
              </button>
              <button id="btn-remezclar-cantador" class="btn btn-outline-dark btn-sm fw-semibold" title="Barajar cartas del mazo">
                🔀 Remezclar
              </button>
              <button id="btn-pausar-partida" class="btn btn-outline-secondary btn-sm fw-bold px-2 d-none">
                ⏸ Pausar
              </button>
              <button id="btn-detener-partida" class="btn btn-outline-danger btn-sm fw-bold px-2 d-none">
                ⏹ Detener
              </button>
            </div>
          </div>

          <!-- Carta cantada en tiempo real -->
          <div id="cantador-display" class="cantador-display mt-3 pt-3 border-top d-none">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
              <span class="badge badge-cantador" id="cantador-progreso">Carta 1 de 54</span>
              <span class="text-muted small fw-semibold" id="cantador-estado">¡Cantando...!</span>
            </div>
            <div class="cantador-card-hero d-flex align-items-center gap-3 p-2 rounded">
              <div class="cantador-img-wrap text-center">
                <img id="cantador-img" src="img/cartas/1.jpg" alt="Carta cantada" class="img-fluid rounded shadow-sm" style="max-height: 85px;">
              </div>
              <div>
                <span class="badge badge-orden mb-1" id="cantador-num">#1</span>
                <h4 class="mb-0 text-uppercase fw-bold text-cochinilla" id="cantador-nombre">EL GALLO</h4>
                <small class="text-muted" id="cantador-sub">¡Buena suerte a todos los jugadores!</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="d-flex align-items-baseline justify-content-between flex-wrap gap-2 mb-2">
        <h2 class="h4 mb-0">Cartas de la Lotería Mexicana</h2>
        <span class="badge badge-orden"><?php echo $mezclado ? 'Orden: mezclado' : 'Orden: original 1–54'; ?></span>
      </div>
      <div class="table-responsive tabla-marco" id="tabla-marco">
        <table class="table table-sm align-middle text-center mb-0" id="tabla-cartas">
          <tbody>
          <?php foreach ($cartas as $fi => $fila): ?>
            <tr>
            <?php foreach ($fila as $ci => $c): ?>
              <td class="celda">
                <div class="carta" data-num="<?php echo (int)$c['num']; ?>" data-fila="<?php echo $fi + 1; ?>" data-col="<?php echo $ci + 1; ?>" data-bs-toggle="tooltip" data-bs-title="<?php echo e($c['num'] . '. ' . $c['nombre']); ?>" title="<?php echo e($c['num'] . '. ' . $c['nombre']); ?>" style="--d:<?php echo (($fi * 6 + $ci) * 25); ?>ms">
                  <span class="carta-num"><?php echo (int)$c['num']; ?></span>
                  <img src="<?php echo e($c['img']); ?>" alt="<?php echo e($c['nombre']); ?>" class="img-fluid mt-1 mb-1" style="max-height: 50px; object-fit: contain;">
                  <span class="carta-nombre"><?php echo e($c['nombre']); ?></span>
                </div>
              </td>
            <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-2">
        <p class="hint mb-0">Haz clic en cualquier carta para seleccionarla, o pasa el cursor para escuchar al narrador.</p>
        <div class="form-check form-switch mb-0">
          <input class="form-check-input" type="checkbox" id="chk-audio-hover" checked>
          <label class="form-check-label small fw-semibold" for="chk-audio-hover">🔊 Narrar al pasar el mouse</label>
        </div>
      </div>
    </section>

    <aside class="col-lg-4" id="consulta">
      <div class="card panel mb-3">
        <div class="card-body">
          <h3 class="h6 panel-title"><span class="dot" aria-hidden="true">⌕</span> Consultar carta</h3>
          <p class="small text-muted">Ingresa la fila y columna para consultar una carta.</p>
          <form method="post" action="index.php#consulta" novalidate>
            <label class="form-label" for="fila">Fila (1 - 9):</label>
            <input class="form-control mb-2" id="fila" name="fila" type="number" min="1" max="9" placeholder="Ej. 3" required
                   value="<?php echo $filaIn !== false && $filaIn !== null ? (int)$filaIn : ''; ?>">
            <label class="form-label" for="columna">Columna (1 - 6):</label>
            <input class="form-control mb-3" id="columna" name="columna" type="number" min="1" max="6" placeholder="Ej. 2" required
                   value="<?php echo $colIn !== false && $colIn !== null ? (int)$colIn : ''; ?>">
            <button class="btn btn-consultar w-100" type="submit">⌕ Consultar</button>
          </form>
          <?php if ($error): ?>
            <div class="alert alert-danger mt-3 mb-0" role="alert"><?php echo e($error); ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="card panel encontrada mb-3" id="panel-encontrada">
        <div class="card-body text-center">
          <h3 class="h6 mb-2">Carta seleccionada:</h3>
          <div id="encontrada-contenido">
          <?php if ($resultado): ?>
            <div class="encontrada-tile">
              <span class="carta-num grande"><?php echo (int)$resultado['num']; ?></span>
              <img src="<?php echo e($resultado['img']); ?>" alt="<?php echo e($resultado['nombre']); ?>" class="img-fluid mt-2 mb-1" style="max-height: 120px;">
              <span class="encontrada-nombre"><?php echo e($resultado['nombre']); ?></span>
            </div>
            <p class="small text-muted mb-0">Fila: <?php echo (int)$resultado['fila']; ?> &nbsp; Columna: <?php echo (int)$resultado['columna']; ?></p>
          <?php else: ?>
            <div class="py-3 text-muted">
              <div class="fs-1 mb-2" aria-hidden="true">🎴</div>
              <p class="small mb-0">Ingresa fila y columna o toca una carta en el tablero para visualizarla.</p>
            </div>
          <?php endif; ?>
          </div>
        </div>
      </div>
    </aside>
  </div>
</main>

<footer class="footer">
  <div class="greca" aria-hidden="true"></div>
  <div class="container d-flex flex-wrap gap-2 justify-content-center py-3">
    <span>Lotería Mexicana</span><span aria-hidden="true">•</span><span>Cultura</span><span aria-hidden="true">•</span><span>Tradición</span><span aria-hidden="true">•</span><span>México</span>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/tooltips.js"></script>
<script src="assets/js/cantador.js"></script>
</body>
</html>
