# AGENTS.md — Lotería Mexicana (PHP + Bootstrap)

Página web en PHP de la Lotería Mexicana. Proyecto escolar (Programación en Redes, UTM), equipo de 2 personas. Entrega: código + capturas + PDF.

## Stack

- PHP vanilla + HTML + Bootstrap 5 (vía CDN) + JavaScript vanilla. Sin frameworks PHP/JS, sin Composer, sin base de datos, sin npm, sin Node.
- Servidor local: `php -S localhost:8000` desde la raíz. Verificar en `http://localhost:8000/index.php`.
- `PLAN.md` sugiere Node/Express, pero la rúbrica exige PHP ("Usar PHP", "arreglo bidimensional en PHP"). **PHP manda; Node rompe las reglas.**

## Estructura

- `index.php` — punto de entrada: tabla de cartas + formulario de consulta. (El `index.html` actual está vacío: reemplazarlo o eliminarlo, no mantener dos entradas.)
- `css/estilos.css` — ÚNICO CSS propio: solo paleta Mexicana y ajustes sobre Bootstrap. No reinventar grid, tablas ni formularios: usar `container`, `table` + `table-responsive`, `row`/`col`, `btn`, `form-control`, `navbar`.
- `js/` — solo eventos que PHP no pueda resolver en servidor (tooltip, mezcla en cliente si aplica).
- `img/cartas/` — las 54 imágenes (`1.jpg`…`54.jpg` o `.png`). Si falta alguna, usar placeholder; nunca un `<img>` roto.
- Bootstrap 5.3 vía CDN en `index.php` (sin Sass, sin build):
```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
```

## Regla de oro: arreglo bidimensional en PHP (9x6)

Las 54 cartas VIVEN en un arreglo PHP de 9 filas x 6 columnas. Cada celda es `['nombre' => ..., 'img' => ...]`. Nunca un arreglo plano, nunca los datos solo en JS.

```php
$cartas = [
  [ ['nombre' => 'ÁGUILA', 'img' => 'img/cartas/1.jpg'], /* ... 6 columnas */ ],
  /* ... 9 filas */
];
// Mezclar: shuffle sobre copia plana y reagrupar en 9x6, o shuffle por filas.
// Consulta: $cartas[$fila - 1][$col - 1] (índices 0-based, entrada 1-based, validada).
```

## Las 54 cartas (nombres oficiales, por fila)

1. EL GALLO, EL DIABLITO, LA DAMA, EL CATRÍN, EL PARAGUAS, LA SIRENA
2. LA ESCALERA, LA BOTELLA, EL BARRIL, EL ÁRBOL, EL MELÓN, EL VALIENTE
3. EL GORRITO, LA MUERTE, LA PERA, LA BANDERA, EL BANDOLÓN, EL VIOLONCELLO
4. LA GARZA, EL PÁJARO, LA MANO, LA BOTA, LA LUNA, EL COTORRO
5. EL BORRACHO, EL NEGRITO, EL CORAZÓN, LA SANDÍA, EL TAMBOR, EL CAMARÓN
6. LAS JARAS, EL MÚSICO, LA ARAÑA, EL SOLDADO, LA ESTRELLA, EL CAZO
7. EL MUNDO, EL APACHE, EL NOPAL, EL ALACRÁN, LA ROSA, LA CALAVERA
8. LA CAMPANA, EL CANTARITO, EL VENADO, EL SOL, LA CORONA, LA CHALUPA
9. EL PINO, EL PESCADO, LA PALMA, LA MACETA, EL ARPA, LA RANA

## Funcionalidades obligatorias (rúbrica)

- Mezclar cartas conservando la estructura 9x6.
- Tooltip con el nombre al pasar el mouse: usar tooltips de Bootstrap (`data-bs-toggle="tooltip"`) o `onmouseover`/JS.
- Consultar carta por fila (1-9) y columna (1-6), con validación **en servidor**, mostrando nombre e imagen.
- Diseño responsive con encabezado, menú, pie de página y paleta coherente.
- Escapar toda salida con `htmlspecialchars()` (los nombres llevan acentos y `Ñ`).

```php
// Validación en SERVIDOR (no solo en JS):
$fila = filter_input(INPUT_POST, 'fila', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 9]]);
$col  = filter_input(INPUT_POST, 'columna', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 6]]);
if ($fila === false || $col === false) { /* mostrar error, no acceder al arreglo */ }
```

## Límites

- DO NOT: Node, Express, frameworks PHP/JS, Composer/npm, bases de datos. Bootstrap 5 (CDN) es el ÚNICO framework permitido.
- DO NOT: poner los datos de las cartas solo en JS; la fuente de verdad es el arreglo PHP.
- DO NOT: commitear credenciales si se agregan después (usar `.env.example` como plantilla).

## Git (repo propio en GitHub)

- Commits convencionales: `feat:`, `fix:`, `docs:` (ej. `feat: tabla 9x6 con tooltip`).
- Ramas `feat/...`, `fix/...`; PRs pequeños y verificados antes de merge a `main`.

## Gotchas

- La ruta del proyecto contiene espacios (`.../programacion en redes/proyecto loteria mexicana`): entrecomillar rutas en comandos.
- Definition of Done: `php -S` renderiza `index.php` con las 54 cartas, la mezcla funciona, el hover muestra el nombre, fila/columna inválida muestra error (sin warnings PHP), y el layout se adapta a móvil.
