# MEMORY.md — Bitácora de cambios · Lotería Mexicana (PHP)

> Cada cambio del proyecto se registra aquí con día y hora de implementación.
> No borrar entradas anteriores: solo anexar al final.
> Formato de fecha: `YYYY-MM-DD`. Hora local del equipo (UTC-6, América/México).
> Fuente de reglas: `AGENTS.md`. Plan vigente: `PLAN.md`.

## Análisis AGENTS.md (PHP) — 2026-09-22

- `AGENTS.md` ya no usa Node/Express: ahora exige PHP vanilla + HTML + Bootstrap 5 CDN + JS vanilla.
- Sin Composer, sin npm, sin frameworks PHP/JS, sin base de datos.
- Entrada única: `index.php` (el `index.html` actual está vacío: reemplazar o eliminar).
- Regla de oro: arreglo PHP 9x6 `$cartas[$fila-1][$col-1]`, cada celda `['nombre','img']`.
- Validación en servidor con `filter_input` fila 1-9, columna 1-6 + `htmlspecialchars()`.
- `img/cartas/1.jpg…54.jpg`, placeholder si falta, nunca `<img>` roto.
- DoD: `php -S localhost:8000` renderiza 54 cartas, mezcla OK, hover muestra nombre,
  error sin warnings, responsive.
- Este análisis obliga a descartar el `PLAN.md` viejo (Node) y reescribirlo a PHP.

## Registro

### 1. Commit inicial del repo — 2026-09-21 09:52
- Cambio: `first commit` (`cb79df0`).
- Archivos: `README.md` (`# LOTERIA-MEXICANA`).
- Detalle: creación del repositorio `LOTERIA-MEXICANA` en `main` + push a `origin/main`.
- Estado: base vacía, sin código funcional.

### 2. Implementación de plan e inicio del proyecto — 2026-09-21 09:55
- Cambio: commit `5cc2d77` con mensaje `implementacion de plan e inicio del proyecto`.
- Archivos: `PLAN.md` (versión Node.js + Express), `index.html` (plantilla base vacía 9 líneas).
- Detalle: plan inicial proponía `server.js` + `/api/cartas` + frontend `app.js`/`style.css`.
  Sirvió como arranque pero violaba la rúbrica (exige PHP). Se conserva en historial
  como referencia, ya no como plan vigente.
- Push: `cb79df0..5cc2d77 main -> main` a `origin/main`.

### 3. Migración de AGENTS.md a PHP para cumplir rúbrica — 2026-09-22 08:39
- Cambio: `AGENTS.md` reescrito de Node a PHP (archivo untracked, pendiente de commit).
- Archivos: `AGENTS.md` (79 líneas).
- Detalle: stack PHP + Bootstrap 5.3 CDN, estructura `index.php`/`css/estilos.css`/`js/`/`img/cartas/`,
  regla 9x6 en PHP, lista oficial 54 cartas (con aviso `28. TLAHU…`, `43. CUAT…` truncados),
  validación servidor, límites `DO NOT Node/Express/Composer/npm/DB`, DoD con `php -S localhost:8000`.
  Corrige el conflicto plan-vs-rúbrica: PHP manda.
- Hora obtenida de `LastWriteTime` del archivo.

### 4. Actualización de PLAN.md con instrucciones de la imagen — 2026-09-22 08:40
- Cambio: reescritura total de `PLAN.md` (52 → ~150 líneas) alineada a `AGENTS.md` + imagen.
- Archivos: `PLAN.md`.
- Detalle: se eliminó propuesta Node/Express. Nuevo contenido:
  objetivo de la hoja, stack PHP, estructura, regla 9x6 con snippet,
  lista 54 cartas por fila, checklist 7 instrucciones, requisitos técnicos,
  layout del mockup (header/nav/tabla/aside `Consultar carta`/`Carta encontrada`/
  `Ejemplo de interacción`/footer), funcionalidades, entrega (código+capturas+PDF),
  criterios de evaluación, pasos de ejecución, estado actual.
  Transcripción fiel de nombres del mockup 1-54 (ÁGUILA…VIDA).
- Implementado: 2026-09-22 08:40.

### 5. Creación de MEMORY.md (este archivo) — 2026-09-22 08:40
- Cambio: creación de `MEMORY.md` para bitácora obligatoria.
- Archivos: `MEMORY.md`.
- Detalle: incluye análisis de `AGENTS.md`, registro retroactivo 1-4 con día/hora,
  y regla de anexar cada cambio futuro al final sin reescribir historial.
- Implementado: 2026-09-22 08:40.

---
<!-- ANEXAR NUEVOS CAMBIOS DEBAJO, CONSECUTIVO 6, 7, ... CON FECHA Y HORA -->

### 6. Estructura visual clave con skill frontend-design + migración a index.php — 2026-09-22 08:57
- Cambio: creación de `index.php` + `css/estilos.css` + `js/tooltips.js` + `img/cartas/.gitkeep`, eliminación de `index.html`.
- Archivos: `index.php` (nuevo, entrada única), `css/estilos.css`, `js/tooltips.js`, `img/cartas/.gitkeep`, `index.html` (eliminado).
- Detalle: skill `frontend-design` (ruta `agent/skills/frontend-design`, `skills-lock.json`) aplicado con criterio:
  paleta Mexicana propia (azul noche `#0b2a4a`, amate `#f7f1de`, maíz `#e9b44c`, cochinilla `#a31621`, jade `#14705c`),
  tipografías Marcellus + Inter, hero memorable + tabla-marco estilo códice (no SaaS genérico).
  `index.php` implementa `$cartas[9][6]` con 54 nombres oficiales, mezcla `?mezclar=1` (shuffle + `array_chunk`),
  tooltip `data-bs-toggle="tooltip"` x54, consulta POST fila 1-9/columna 1-6 validada con `filter_input`,
  `htmlspecialchars()` en salidas, placeholder `placehold.co` + `onerror` (nunca `<img>` roto),
  header/nav `#inicio #loteria #consulta`, aside `Consultar carta`/`Carta encontrada`/`Ejemplo de interacción`,
  footer `Cultura • Tradición • México`. Verificado: `php -S` 200, 54 tooltips/captions, POST 1,2→JAGUAR,
  POST 99,0→error, `?mezclar=1`→badge mezclado, `php -l` sin errores.
- Implementado: 2026-09-22 08:57.

### 7. Reorganización de recursos a carpeta assets/ — 2026-09-22 10:46
- Cambio: `css/` → `assets/css/`, `js/` → `assets/js/`, `img/` → `assets/img/`; rutas actualizadas en `index.php`.
- Archivos: `assets/css/estilos.css`, `assets/js/tooltips.js`, `assets/img/cartas/.gitkeep` (movidos); `index.php` (3 rutas: línea 21 `assets/img/cartas/`, línea 68 `assets/css/estilos.css`, línea 194 `assets/js/tooltips.js`).
- Detalle: pedido explícito del usuario; difiere de `AGENTS.md` §Estructura (`css/`, `js/`, `img/` en raíz).
  Verificado: `php -l` limpio, `php -S` 200, HTML referencia `assets/css` + `assets/js`, `assets/css` 200 (3909 B),
  `assets/js` 200 (254 B). Imágenes aún placeholder (`placehold.co`) porque no hay JPG locales; al agregar
  `assets/img/cartas/1.jpg…54.jpg` se servirán automáticamente vía `is_file()`.
- Implementado: 2026-09-22 10:46.

### 8. Imágenes por API opción A (Pollinations) con switch fácil — 2026-09-22 11:05
- Cambio: `index.php` ahora genera imágenes por API según el nombre, sin archivos locales.
- Archivos: `index.php` (`$IMG_MODE`, `$IMG_KEYWORDS[1-54]`, `img_src()` multi-modo).
- Detalle: `$IMG_MODE='pollinations'` dibuja estilo códice (`mexican codex illustration of {keyword}...`,
  `?width=300&height=420&nologo=true&seed={num}`). Keywords 1-54 en inglés (eagle, jaguar... sunrise).
  Si agregas JPG en `assets/img/cartas/` se usan primero (`is_file`). `onerror` sigue a `placehold.co`.
  Verificado: `php -l` limpio, `php -S` 200, 54 URLs `image.pollinations.ai` + 54 fallbacks.
- Implementado: 2026-09-22 11:05.

### 9. Limpieza total de imágenes + cartas de texto + animación de mezcla — 2026-09-22 11:17
- Cambio: eliminado todo el sistema de imágenes; cartas reorganizadas sin imagen; animación al cargar/mezclar.
- Archivos: `index.php` (sin `$IMG_MODE`/`$IMG_KEYWORDS`/`img_src()`/`<img>`/`onerror`; `$cartas` solo `nombre+num`;
  celdas `div.carta` con `--d` escalonado, `id="tabla-cartas"`/`"tabla-marco"`/`"btn-mezclar"`, encontrada como tile),
  `assets/css/estilos.css` (tiles `min-height:86px`, `@keyframes reparto`, clases `.reparto`/`.mezclando`,
  `prefers-reduced-motion`, sin reglas `img`), `assets/js/tooltips.js` (tooltips + reparto al cargar +
  sacudida 550ms antes de navegar a `?mezclar=1`), `assets/img/` eliminada (solo quedan `assets/css`+`assets/js`).
- Detalle: revierte entradas 7 (parcial) y 8 (total) por pedido del usuario: empezar de cero sin imágenes.
  Verificado: `php -l` limpio, `php -S` 200, 54 tooltips, POST 1,2→JAGUAR, POST inválido→error, sin refs a
  `img_src/pollinations/<img>/assets/img`.
- Implementado: 2026-09-22 11:17.

### 10. Corrección de Lotería Mexica a Lotería Mexicana tradicional — 2026-09-22 19:07
- Cambio: corrección general del proyecto para enfocarse en la "Lotería Mexicana" tradicional en lugar de la versión "Mexica".
- Archivos: `AGENTS.md`, `PLAN.md`, `index.php`, `assets/css/estilos.css`, `MEMORY.md`.
- Detalle: se reemplazaron las referencias de "Lotería Mexica" por "Lotería Mexicana". Además, se actualizó el arreglo de las 54 cartas en `index.php` y la lista de `AGENTS.md` para incluir los nombres tradicionales (El Gallo, El Diablito, etc.) en lugar de los nombres prehispánicos.
- Implementado: 2026-09-22 19:07.

### 11. Implementación de Cantador de Lotería con Audio y Partida Interactiva — 2026-09-22 19:24
- Cambio: generación de 54 audios para cantar las cartas, creación de script CLI para Fish Audio, panel de control de partida en vivo con reproducción de audio y resaltado sincronizado en el tablero 9x6.
- Archivos: `audios/1.wav…54.wav`, `generar_audios.php`, `assets/js/cantador.js`, `index.php`, `assets/css/estilos.css`, `MEMORY.md`.
- Detalle:
  1. Se generaron los 54 audios (.wav) de las cartas con voz mexicana (`Microsoft Sabina Desktop (es-MX)`) almacenados en `audios/` listos para uso inmediato sin dependencias ni costes.
  2. Se creó `generar_audios.php` que permite descargar automáticamente los 54 audios en formato MP3 usando la API de Fish Audio pasando la clave por parámetro CLI (`php generar_audios.php <API_KEY>`).
  3. Se diseñó el panel "Cantador de Lotería" en `index.php` con botones de Iniciar/Pausar/Detener partida y selector de velocidad (2.5s, 3.8s, 5.5s).
  4. En `assets/js/cantador.js` se implementó la lógica de barajado aleatorio, reproducción secuencial de audios (`.wav` o `.mp3`), fallback automático con `speechSynthesis` del navegador, display dinámico de la carta cantada y resaltado visual con animación en la cuadrícula 9x6.
  5. Se eliminó advertencia PHP en CLI (`REQUEST_METHOD`).
- Implementado: 2026-09-22 19:24.

### 12. Intro con voz de Goku, botón de remezcla y refinamiento UI/UX con frontend-design — 2026-09-22 19:43
- Cambio: integración de audio intro con voz de Goku Mario Castañeda, botón para remezclar mazo en caliente, selector interactivo táctil de cartas y limpieza de elementos de ejemplo.
- Archivos: `audios/intro.wav`, `generar_audios.php`, `index.php`, `assets/js/cantador.js`, `assets/css/estilos.css`, `MEMORY.md`.
- Detalle:
  1. Se consultó la API de Fish Audio con la API key provista, identificando el modelo oficial `Goku (Mario Castañeda)` (`9f850ee9ada24b20a6866825eaefd3f8`).
  2. Se configuró `generar_audios.php` con el modelo de Goku y la generación de `intro.mp3` y los 54 audios MP3. Se documentó el estado de créditos de la API (HTTP 402 / recarga en developers).
  3. Se generó localmente `audios/intro.wav` con la frase exacta solicitada («¡Vamos a comenzar chicos, hagan silencio o los agarro a madrazos, comenzamos en 3, 2, 1...!») para funcionamiento offline inmediato.
  4. Se integró el flujo en `assets/js/cantador.js`: al pulsar "Comenzar partida", suena primero la frase de Goku con display de llamado y conteo regresivo; al finalizar la frase, arranca el canto secuencial de cartas barajadas.
  5. Se agregó botón "🔀 Remezclar" con animación de baraja en el marco y reordenamiento del mazo en vivo.
  6. Se eliminó el panel "Ejemplo de interacción" y el texto de ejemplo en "Carta encontrada", sustituyéndolo por un estado vacío elegante.
  7. Se mejoró el selector de cartas: al hacer clic en cualquier carta de la tabla 9x6, se seleccionan automáticamente sus coordenadas (fila/columna) y se muestra su miniatura e información al instante.
  8. Se aplicaron pautas del skill `frontend-design`: ratios de contraste AAA, estilos de foco accesible `:focus-visible`, soporte de `prefers-reduced-motion` y touch targets móviles.
- Implementado: 2026-09-22 19:43.

### 13. Narración de cartas en voz alta al pasar el cursor (Hover) — 2026-09-22 19:48
- Cambio: implementación de narración por audio al pasar el cursor sobre las cartas utilizando JavaScript (`mouseenter`/`mouseleave`) con debounce y switch de activación.
- Archivos: `index.php`, `assets/js/cantador.js`, `MEMORY.md`.
- Detalle:
  1. Se implementó la opción más eficiente y limpia vía JavaScript vanilla (en lugar de 54 atributos inline `onmouseover` en PHP):
     - Cancela instantáneamente el audio anterior si el usuario desplaza el cursor a otra carta, evitando colisiones y acumulación de sonido.
     - Aplica un debounce de 70ms para garantizar fluidez sin saturar el hilo de audio en recorridos rápidos.
     - Reproduce el archivo `.wav` o `.mp3` de la carta con fallback a `speechSynthesis`.
     - Si una partida automática está en curso, no interrumpe la narración de la partida.
  2. Se agregó un control de activación en la interfaz (`#chk-audio-hover`: "🔊 Narrar al pasar el mouse") para que el usuario pueda encenderlo o silenciarlo a voluntad según las mejores prácticas de accesibilidad web.
- Implementado: 2026-09-22 19:48.
