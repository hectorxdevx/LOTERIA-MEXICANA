## Assistant (Plan · Muse Spark 1.3 Free · 14.9s)

_Thinking:_

Aquí tienes el plan para tu proyecto **Lotería Mexicana - Juego local simple + backend**:

Tu `index.html` está vacío, así que partimos de cero.

### 1. Arquitectura propuesta (Recomendada)

**Frontend puro + Backend ligero Node.js + Express:**
¿Por qué? Es lo más simple para tu caso: todo en JavaScript, sin base de datos complicada, cumple el requisito de "programación en redes" (cliente-servidor HTTP + API REST).

```
proyecto loteria mexicana/
├── index.html          # estructura tablas + carta cantada
├── style.css           # diseño mexicano, responsive
├── app.js              # lógica frontend
├── server.js           # backend Express
├── package.json
└── cartas/             # 54 imágenes (usa placeholder o API pública)
```

Si prefieres Python (Flask) porque lo ves en clase, dímelo y adapto el plan - la lógica es idéntica.

### 2. Funcionalidades mínimas (para aprobar)

1.  **Mazo de 54 cartas:** array en backend `/api/cartas`, frontend las pide al iniciar.
2.  **Tabla 4x4 aleatoria:** generada en frontend desde las 54 cartas.
3.  **Cantar cartas:** botón "Siguiente carta" -> pide a `/api/cantar` o aleatorio local con temporizador 3-5s + voz con `speechSynthesis`.
4.  **Marcar frijolito:** click en casilla para marcar/desmarcar.
5.  **Detectar ganada:** verificar filas, columnas, diagonal, llena, o "cuatro esquinas" -> mostrar "¡LOTERÍA!".
6.  **Reiniciar juego.**

Extra si quieres puntos: modo "tablas múltiples", historial de cartas cantadas, sonidos.

### 3. Pasos de ejecución

1.  Crear `server.js` con Express: sirve archivos estáticos + 2 endpoints (`/api/cartas`, `/api/verificar`).
2.  Crear `index.html`: tablero, carta actual, historial, botones.
3.  Crear `style.css`: estilo lotería tradicional.
4.  Crear `app.js`: fetch cartas, generar tabla, cantar, marcar, verificar ganada.
5.  Probar local: `npm install express` -> `node server.js` -> `http://localhost:3000`.

### Para empezar a construir necesito que me confirmes:

1.  **¿Node.js o Python para el backend?** Te recomiendo Node.js por simplicidad.
2.  **¿Tienes las 54 imágenes o uso marcadores de texto/emojis temporalmente?**

Cuando me digas, salimos de modo plan y lo construimos paso a paso.

---
