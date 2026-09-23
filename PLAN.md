# PLAN.md — Página Web en PHP · Lotería Mexica

> Fuente de verdad: `AGENTS.md` (stack PHP + Bootstrap) + imagen de instrucciones de la tarea.
> El plan anterior con Node/Express queda descartado: la rúbrica exige PHP explícitamente.

## 1. Objetivo (de la hoja de tarea)

Desarrollar una página web en PHP que muestre la lotería mexica, utilizando
arreglos bidimensionales para almacenar y manipular la información de las cartas.
La página permitirá mezclar las cartas, mostrar el nombre de la carta al pasar
el mouse y consultar una carta específica mediante su fila y columna.

Título del mockup: `Lotería Mexica — Nuestras raíces, en cada carta`.
Subtítulo de la tarea: `Uso de arreglos bidimensionales, eventos y diseño web`.

## 2. Stack (según AGENTS.md)

- PHP vanilla + HTML + Bootstrap 5.3 vía CDN + JavaScript vanilla.
- Sin frameworks PHP/JS, sin Composer, sin npm/Node, sin base de datos.
- Servidor local desde la raíz (ruta con espacios: entrecomillar):
  `php -S localhost:8000` → verificar en `http://localhost:8000/index.php`.
- CDN Bootstrap (sin Sass, sin build):
```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
```

## 3. Estructura de archivos

```
proyecto loteria mexicana/
├── index.php        # punto de entrada: tabla 9x6 + formulario consulta
├── index.html       # ACTUAL está vacío/base: reemplazar o eliminar, no mantener dos entradas
├── css/estilos.css  # ÚNICO CSS propio: paleta mexica + ajustes sobre Bootstrap
├── js/              # solo eventos que PHP no resuelva en servidor (tooltip, mezcla cliente si aplica)
├── img/cartas/      # 54 imágenes (1.jpg…54.jpg o .png). Si falta alguna: placeholder, nunca <img> roto
├── PLAN.md          # este archivo
├── MEMORY.md        # bitácora de cambios con fecha y hora
├── AGENTS.md        # reglas del proyecto (PHP manda)
└── README.md        # descripción corta
```

Reglas CSS: no reinventar grid/tablas/formularios. Usar `container`,
`table` + `table-responsive`, `row`/`col`, `btn`, `form-control`, `navbar`.

## 4. Regla de oro: arreglo bidimensional en PHP (9x6)

Las 54 cartas VIVEN en un arreglo PHP de 9 filas x 6 columnas.
Cada celda es `['nombre' => ..., 'img' => ...]`.
Nunca arreglo plano, nunca datos solo en JS.

```php
$cartas = [
  [ ['nombre' => 'ÁGUILA', 'img' => 'img/cartas/1.jpg'], /* ... 6 columnas */ ],
  /* ... 9 filas */
];
// Mezclar: shuffle sobre copia plana y reagrupar en 9x6, o shuffle por filas.
// Consulta: $cartas[$fila - 1][$col - 1] (índices 0-based, entrada 1-based, validada).
// Salida: siempre htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8').
```

Validación en SERVIDOR (no solo JS):

```php
$fila = filter_input(INPUT_POST, 'fila', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 9]]);
$col  = filter_input(INPUT_POST, 'columna', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 6]]);
if ($fila === false || $fila === null || $col === false || $col === null) {
  /* mostrar error, no acceder al arreglo */
}
```

## 5. Las 54 cartas (nombres oficiales del mockup, por fila)

Fila 1 (1-6): ÁGUILA, JAGUAR, SERPIENTE, SOL, LUNA, ESTRELLA
Fila 2 (7-12): CALENDARIO, MÁSCARA, MAÍZ, FUEGO, AGUA, TIERRA
Fila 3 (13-18): PLANTA, FLOR, CASA, CIERVO, CONEJO, TORTUGA
Fila 4 (19-24): ÁRBOL, CUEVA, ESCUDO, HACHA, LANZA, CAYADO
Fila 5 (25-30): VASO, XÓLOTL, TEPETL, TLAHUICA*, GUERRERO, DÍA
Fila 6 (31-36): NOCHE, LLUVIA, RAYO, FLORES, ORO, PLUMA
Fila 7 (37-42): PESCADO, VENADO, ÁRBOL DE LA VIDA, CACAO, MÚSICA, DANZA
Fila 8 (43-48): CUATLAHTLI*, HUITZIL, CÓDICE, TETL, MÉXICO, INFINITO
Fila 9 (49-54): LIBERTAD, UNIÓN, PAZ, AMOR, SABIDURÍA, VIDA

\* Nombres truncados en la hoja (`28. TLAHU…`, `43. CUAT…`): verificar contra
la hoja original antes de entregar. NO inventar otros nombres.

Numeración del mockup para `img/cartas/`: `1.jpg` = ÁGUILA … `54.jpg` = VIDA.

## 6. Las 7 instrucciones de la tarea (checklist)

1. Arreglo bidimensional PHP con 54 cartas (nombre + ruta imagen). ✅ planificado §4
2. Interfaz web atractiva y profesional con CSS (Bootstrap + `css/estilos.css`).
3. Mostrar cartas en tabla 6 columnas x 9 filas (54 cartas). Alternativa permitida
   solo si sigue sumando 54; aquí usamos 9x6 como pide AGENTS.md.
4. `onmouseover`/tooltip/JS: al pasar el mouse mostrar nombre
   (`title` + `data-bs-toggle="tooltip"` + activación Bootstrap).
5. Apartado consulta: formulario fila (1-9) + columna (1-6), validación en PHP,
   muestra nombre + imagen + posición. Error visible sin warnings.
6. Responsive + UX: encabezado, menú, pie de página, colores, menús.
7. Equipo de 2 personas.

## 7. Requisitos técnicos (de la hoja)

- Usar PHP (pueden usar HTML, CSS y JavaScript).
- Utilizar un arreglo bidimensional para las cartas.
- Implementar eventos (como onmouseover o JavaScript).
- Validar los datos de entrada (fila y columna).
- Incluir imágenes de las 54 cartas.

## 8. Layout según mockup de la imagen

- Header: logo águila + `Lotería Mexica` + `Nuestras raíces, en cada carta` +
  nav `Inicio | Lotería | Consulta` (navbar Bootstrap, botón activo amarillo).
- Main (`container` + `row`):
  - Col izquierda (tabla): `Cartas de la Lotería Mexica`, `table table-responsive`,
    9 filas x 6 celdas, cada celda imagen + número + nombre corto.
  - Aside derecha: card `Consultar carta` (texto ayuda + inputs
    `Fila (1-9)` placeholder `Ej. 3`, `Columna (1-6)` placeholder `Ej. 2` +
    botón `Consultar`), card `Carta encontrada:` (imagen grande + nombre +
    `Fila: X Columna: Y`), card `Ejemplo de interacción`
    (pasa el mouse / ingresa fila y columna / descubre todas las cartas).
- Footer: `Lotería Mexica • Cultura • Tradición • México` + grecas.
- Paleta: azul marino `#0a2e5c`, azul claro fondo cards, amarillo acento botón
  activo, verde claro fondo `Carta encontrada`.

## 9. Funcionalidades obligatorias (rúbrica + AGENTS.md)

- Mezclar cartas conservando 9x6 (botón `Mezclar`, `shuffle` + reagrupar).
- Tooltip con nombre al hover (Bootstrap tooltips o `onmouseover`).
- Consulta fila/columna con validación en servidor + muestra nombre e imagen.
- Responsive + header + menú + footer + paleta coherente.
- `htmlspecialchars()` en toda salida (acentos y Ñ).
- Sin `<img>` roto: `file_exists()` o `onerror` → placeholder.

## 10. Entrega (de la hoja)

- Código fuente (carpeta del proyecto).
- Capturas de pantalla del funcionamiento.
- Documento breve PDF con descripción del proyecto y cómo se implementó.

## 11. Criterios de evaluación (de la hoja)

- Funcionamiento correcto (mezclar, mostrar nombre al pasar mouse, consultar por fila/columna).
- Uso adecuado de arreglos bidimensionales en PHP.
- Diseño y presentación visual.
- Código limpio y bien estructurado.
- Trabajo en equipo y cumplimiento de la entrega.

## 12. Pasos de ejecución

1. Crear `index.php`: `$cartas[9][6]`, mezcla por `?mezclar=1`, tabla con tooltip,
   formulario POST fila/columna, bloque resultado/error, header/nav/footer Bootstrap.
2. Crear `css/estilos.css`: solo paleta mexica + tweaks (no reescribir Bootstrap).
3. Crear `js/` mínimo solo si hace falta (activar tooltips).
4. Poblar `img/cartas/1.jpg…54.jpg` o placeholders.
5. Eliminar o reemplazar `index.html` para no tener dos entradas.
6. Probar DoD: `php -S localhost:8000` renderiza 54 cartas, mezcla funciona,
   hover muestra nombre, fila/columna inválida muestra error sin warnings,
   layout móvil OK.
7. Capturas + PDF + commit final.

## 13. Estado actual (2026-09-22)

- Repo `LOTERIA-MEXICANA`, rama `main`, commits `cb79df0`, `5cc2d77`.
- `PLAN.md` anterior era Node/Express: descartado por este archivo.
- `AGENTS.md` ya migrado a PHP: manda sobre cualquier plan viejo.
- Pendiente: implementar `index.php` + CSS + imágenes.
- Bitácora: ver `MEMORY.md`.
