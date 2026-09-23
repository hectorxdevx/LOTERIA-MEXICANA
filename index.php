<?php
// Lotería Mexica — index.php
// Regla de oro: las 54 cartas VIVEN en un arreglo PHP 9x6.
$nombres = [
  ['ÁGUILA','JAGUAR','SERPIENTE','SOL','LUNA','ESTRELLA'],
  ['CALENDARIO','MÁSCARA','MAÍZ','FUEGO','AGUA','TIERRA'],
  ['PLANTA','FLOR','CASA','CIERVO','CONEJO','TORTUGA'],
  ['ÁRBOL','CUEVA','ESCUDO','HACHA','LANZA','CAYADO'],
  ['VASO','XÓLOTL','TEPETL','TLAHUICA','GUERRERO','DÍA'],
  ['NOCHE','LLUVIA','RAYO','FLORES','ORO','PLUMA'],
  ['PESCADO','VENADO','ÁRBOL DE LA VIDA','CACAO','MÚSICA','DANZA'],
  ['CUATLAHTLI','HUITZIL','CÓDICE','TETL','MÉXICO','INFINITO'],
  ['LIBERTAD','UNIÓN','PAZ','AMOR','SABIDURÍA','VIDA'],
];

$cartas = [];
$n = 1;
foreach ($nombres as $f => $fila) {
  $r = [];
  foreach ($fila as $c => $nombre) {
    $r[] = ['nombre' => $nombre, 'num' => $n];
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
$consulto = $_SERVER['REQUEST_METHOD'] === 'POST';
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
  <title>Lotería Mexica — Nuestras raíces, en cada carta</title>
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
          <strong>Lotería Mexica</strong>
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
      <div class="d-flex align-items-baseline justify-content-between flex-wrap gap-2 mb-2">
        <h2 class="h4 mb-0">Cartas de la Lotería Mexica</h2>
        <span class="badge badge-orden"><?php echo $mezclado ? 'Orden: mezclado' : 'Orden: original 1–54'; ?></span>
      </div>
      <div class="table-responsive tabla-marco" id="tabla-marco">
        <table class="table table-sm align-middle text-center mb-0" id="tabla-cartas">
          <tbody>
          <?php foreach ($cartas as $fi => $fila): ?>
            <tr>
            <?php foreach ($fila as $ci => $c): ?>
              <td class="celda">
                <div class="carta" data-bs-toggle="tooltip" data-bs-title="<?php echo e($c['num'] . '. ' . $c['nombre']); ?>" title="<?php echo e($c['num'] . '. ' . $c['nombre']); ?>" style="--d:<?php echo (($fi * 6 + $ci) * 25); ?>ms">
                  <span class="carta-num"><?php echo (int)$c['num']; ?></span>
                  <span class="carta-nombre"><?php echo e($c['nombre']); ?></span>
                </div>
              </td>
            <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="hint mt-2">Pasa el mouse sobre una carta para ver su nombre. Posición real: fila 1–9, columna 1–6.</p>
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

      <div class="card panel encontrada mb-3">
        <div class="card-body text-center">
          <h3 class="h6">Carta encontrada:</h3>
          <?php if ($resultado): ?>
            <div class="encontrada-tile">
              <span class="carta-num grande"><?php echo (int)$resultado['num']; ?></span>
              <span class="encontrada-nombre"><?php echo e($resultado['nombre']); ?></span>
            </div>
            <p class="small text-muted mb-0">Fila: <?php echo (int)$resultado['fila']; ?> &nbsp; Columna: <?php echo (int)$resultado['columna']; ?></p>
          <?php else: ?>
            <p class="placeholder-nombre">2. JAGUAR</p>
            <p class="small text-muted mb-0">Ejemplo — consulta una carta para verla aquí.</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="card panel">
        <div class="card-body">
          <h3 class="h6 panel-title"><span class="dot" aria-hidden="true">i</span> Ejemplo de interacción</h3>
          <ul class="small mb-0">
            <li>Pasa el mouse sobre una carta para ver su nombre.</li>
            <li>Ingresa la fila y columna para consultar una carta.</li>
            <li>¡Descubre todas las cartas de la lotería mexica!</li>
          </ul>
        </div>
      </div>
    </aside>
  </div>
</main>

<footer class="footer">
  <div class="greca" aria-hidden="true"></div>
  <div class="container d-flex flex-wrap gap-2 justify-content-center py-3">
    <span>Lotería Mexica</span><span aria-hidden="true">•</span><span>Cultura</span><span aria-hidden="true">•</span><span>Tradición</span><span aria-hidden="true">•</span><span>México</span>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/tooltips.js"></script>
</body>
</html>
