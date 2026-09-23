# MEMORY.md — Bitácora de cambios · Lotería Mexica (PHP)

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
  paleta mexica propia (azul noche `#0b2a4a`, amate `#f7f1de`, maíz `#e9b44c`, cochinilla `#a31621`, jade `#14705c`),
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
