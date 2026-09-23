/**
 * cantador.js — Lógica de partida y audio cantado para Lotería Mexicana
 * Incluye intro especial con voz de Goku (Mario Castañeda) y soporte para Fish Audio / WAV local.
 */
document.addEventListener('DOMContentLoaded', () => {
  const CARTAS = [
    { num: 1, nombre: 'EL GALLO', frase: '¡El que le cantó a San Pedro!' },
    { num: 2, nombre: 'EL DIABLITO', frase: '¡Pórtate bien o te lleva el diablo!' },
    { num: 3, nombre: 'LA DAMA', frase: '¡Puliendo el paso en la alameda!' },
    { num: 4, nombre: 'EL CATRÍN', frase: '¡Don Ferruco bien elegante!' },
    { num: 5, nombre: 'EL PARAGUAS', frase: '¡Para el sol y para el agua!' },
    { num: 6, nombre: 'LA SIRENA', frase: '¡Medio pez y medio mujer!' },
    { num: 7, nombre: 'LA ESCALERA', frase: '¡Sube y baja sin parar!' },
    { num: 8, nombre: 'LA BOTELLA', frase: '¡La que cura las penas!' },
    { num: 9, nombre: 'EL BARRIL', frase: '¡Tanto bebió que rodó!' },
    { num: 10, nombre: 'EL ÁRBOL', frase: '¡El que a buen árbol se arrima!' },
    { num: 11, nombre: 'EL MELÓN', frase: '¡Me quieres o no me quieres!' },
    { num: 12, nombre: 'EL VALIENTE', frase: '¡Con su machete en la mano!' },
    { num: 13, nombre: 'EL GORRITO', frase: '¡Pónselo al nene no se resfríe!' },
    { num: 14, nombre: 'LA MUERTE', frase: '¡La calaca tilica y flaca!' },
    { num: 15, nombre: 'LA PERA', frase: '¡El que espera, desespera!' },
    { num: 16, nombre: 'LA BANDERA', frase: '¡Verde, blanco y colorado!' },
    { num: 17, nombre: 'EL BANDOLÓN', frase: '¡Tocando alegres sones!' },
    { num: 18, nombre: 'EL VIOLONCELLO', frase: '¡Creciendo al son de las cuerdas!' },
    { num: 19, nombre: 'LA GARZA', frase: '¡Alcen vuelo los que puedan!' },
    { num: 20, nombre: 'EL PÁJARO', frase: '¡Tu trinar alegra el día!' },
    { num: 21, nombre: 'LA MANO', frase: '¡La mano del escribano!' },
    { num: 22, nombre: 'LA BOTA', frase: '¡Una bota igual que la otra!' },
    { num: 23, nombre: 'LA LUNA', frase: '¡El farol de los enamorados!' },
    { num: 24, nombre: 'EL COTORRO', frase: '¡Habla y habla todo el día!' },
    { num: 25, nombre: 'EL BORRACHO', frase: '¡No me anden alborotando!' },
    { num: 26, nombre: 'EL NEGRITO', frase: '¡Se le van los pies al bailar!' },
    { num: 27, nombre: 'EL CORAZÓN', frase: '¡No me lo rompas ingrata!' },
    { num: 28, nombre: 'LA SANDÍA', frase: '¡La del juguito fresco!' },
    { num: 29, nombre: 'EL TAMBOR', frase: '¡Retumbando en la fiesta!' },
    { num: 30, nombre: 'EL CAMARÓN', frase: '¡Camarón que se duerme se lo lleva la corriente!' },
    { num: 31, nombre: 'LAS JARAS', frase: '¡Las flechas del buen tirador!' },
    { num: 32, nombre: 'EL MÚSICO', frase: '¡El que alegra la fiesta!' },
    { num: 33, nombre: 'LA ARAÑA', frase: '¡Atrapada en su propia red!' },
    { num: 34, nombre: 'EL SOLDADO', frase: '¡Paso redoblado marchando!' },
    { num: 35, nombre: 'LA ESTRELLA', frase: '¡La guía de los marineros!' },
    { num: 36, nombre: 'EL CAZO', frase: '¡Para el menudo o las carnitas!' },
    { num: 37, nombre: 'EL MUNDO', frase: '¡Este mundo es una rueda!' },
    { num: 38, nombre: 'EL APACHE', frase: '¡Grito de guerra en el llano!' },
    { num: 39, nombre: 'EL NOPAL', frase: '¡Al que sólo van a ver si tiene tunas!' },
    { num: 40, nombre: 'EL ALACRÁN', frase: '¡El que no corre vuela!' },
    { num: 41, nombre: 'LA ROSA', frase: '¡Rosa, rosita, clavel!' },
    { num: 42, nombre: 'LA CALAVERA', frase: '¡Al pozo con la calaca!' },
    { num: 43, nombre: 'LA CAMPANA', frase: '¡Tú que tañes las mañanas!' },
    { num: 44, nombre: 'EL CANTARITO', frase: '¡Tanto va al agua que se quiebra!' },
    { num: 45, nombre: 'EL VENADO', frase: '¡El que salta por el monte!' },
    { num: 46, nombre: 'EL SOL', frase: '¡La cobija de los pobres!' },
    { num: 47, nombre: 'LA CORONA', frase: '¡El sombrero de los reyes!' },
    { num: 48, nombre: 'LA CHALUPA', frase: '¡Remando en Xochimilco!' },
    { num: 49, nombre: 'EL PINO', frase: '¡Fresco y verde todo el año!' },
    { num: 50, nombre: 'EL PESCADO', frase: '¡Por la boca muere el pez!' },
    { num: 51, nombre: 'LA PALMA', frase: '¡Bajo la brisa costeña!' },
    { num: 52, nombre: 'LA MACETA', frase: '¡No pasa del corredor!' },
    { num: 53, nombre: 'EL ARPA', frase: '¡Sonando alegres arpegios!' },
    { num: 54, nombre: 'LA RANA', frase: '¡Al agua patos cantando!' }
  ];

  const TEXTO_INTRO = '¡Vamos a comenzar chicos, hagan silencio o los agarro a madrazos, comenzamos en 3, 2, 1...!';

  // Elementos DOM del Cantador
  const btnIniciar = document.getElementById('btn-iniciar-partida');
  const btnRemezclar = document.getElementById('btn-remezclar-cantador');
  const btnPausar = document.getElementById('btn-pausar-partida');
  const btnDetener = document.getElementById('btn-detener-partida');
  const selVelocidad = document.getElementById('cantador-velocidad');

  const panelDisplay = document.getElementById('cantador-display');
  const elProgreso = document.getElementById('cantador-progreso');
  const elEstado = document.getElementById('cantador-estado');
  const elImg = document.getElementById('cantador-img');
  const elNum = document.getElementById('cantador-num');
  const elNombre = document.getElementById('cantador-nombre');
  const elSub = document.getElementById('cantador-sub');
  const marco = document.getElementById('tabla-marco');

  // Elementos DOM de consulta interactiva
  const inputFila = document.getElementById('fila');
  const inputCol = document.getElementById('columna');
  const contenedorEncontrada = document.getElementById('encontrada-contenido');

  if (!btnIniciar) return;

  // Estado del juego
  let mazo = [];
  let indiceActual = 0;
  let enPartida = false;
  let enPausa = false;
  let enIntro = false;
  let temporizador = null;
  let audioActual = null;

  function barajar(arr) {
    const copia = [...arr];
    for (let i = copia.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [copia[i], copia[j]] = [copia[j], copia[i]];
    }
    return copia;
  }

  function limpiarResaltados() {
    document.querySelectorAll('.carta').forEach(el => {
      el.classList.remove('cantando-ahora', 'ya-cantada');
    });
  }

  // Animación visual de sacudida al remezclar
  function animarMezcla() {
    if (marco) {
      marco.classList.remove('mezclando');
      void marco.offsetWidth;
      marco.classList.add('mezclando');
    }
  }

  // Reproducir intro con voz de Goku
  function reproducirIntro(callback) {
    enIntro = true;
    if (panelDisplay) {
      panelDisplay.classList.remove('d-none');
      elProgreso.textContent = '🔊 ¡Llamado de Goku!';
      elEstado.textContent = 'Iniciando partida... ¡Silencio!';
      elNum.textContent = '📢';
      elNombre.textContent = '¡PREPÁRENSE!';
      elSub.textContent = '«Vamos a comenzar chicos, hagan silencio o los agarro a madrazos, comenzamos en 3, 2, 1...»';
      elImg.src = 'img/cartas/1.jpg';
      elImg.alt = 'Goku Cantador';
    }

    let terminado = false;
    const finIntro = () => {
      if (!terminado) {
        terminado = true;
        enIntro = false;
        callback();
      }
    };

    // Intentar reproducir intro.mp3 (Fish Audio) o intro.wav (TTS local)
    const audioIntroMp3 = new Audio('audios/intro.mp3');
    audioActual = audioIntroMp3;
    audioIntroMp3.onended = finIntro;

    audioIntroMp3.play().catch(() => {
      const audioIntroWav = new Audio('audios/intro.wav');
      audioActual = audioIntroWav;
      audioIntroWav.onended = finIntro;

      audioIntroWav.play().catch(() => {
        // Fallback a SpeechSynthesis del navegador
        if ('speechSynthesis' in window) {
          window.speechSynthesis.cancel();
          const utt = new SpeechSynthesisUtterance(TEXTO_INTRO);
          utt.lang = 'es-MX';
          utt.rate = 1.05;
          utt.onend = finIntro;
          utt.onerror = finIntro;
          window.speechSynthesis.speak(utt);
          setTimeout(finIntro, 5000);
        } else {
          setTimeout(finIntro, 2500);
        }
      });
    });
  }

  function cantarCarta(carta, index, total) {
    if (!enPartida || enPausa) return;

    // Actualizar panel cantador
    if (panelDisplay) {
      panelDisplay.classList.remove('d-none');
      elProgreso.textContent = `Carta ${index + 1} de ${total}`;
      elEstado.textContent = '¡Cantando en voz alta!';
      elNum.textContent = `#${carta.num}`;
      elNombre.textContent = carta.nombre;
      elSub.textContent = carta.frase || '';
      elImg.src = `img/cartas/${carta.num}.jpg`;
      elImg.alt = carta.nombre;
    }

    // Actualizar clases en el tablero
    document.querySelectorAll('.carta.cantando-ahora').forEach(el => {
      el.classList.remove('cantando-ahora');
      el.classList.add('ya-cantada');
    });

    const celdaActual = document.querySelector(`.carta[data-num="${carta.num}"]`);
    if (celdaActual) {
      celdaActual.classList.add('cantando-ahora');
      // Scroll suave si no está a la vista
      celdaActual.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'nearest' });
    }

    // Reproducir audio de la carta
    reproducirAudioCarta(carta, () => {
      if (!enPartida || enPausa) return;

      const tiempoEspera = parseInt(selVelocidad.value, 10) || 3800;
      elEstado.textContent = 'Siguiente carta en breve...';

      temporizador = setTimeout(() => {
        indiceActual++;
        if (indiceActual < mazo.length) {
          cantarCarta(mazo[indiceActual], indiceActual, mazo.length);
        } else {
          finalizarPartida();
        }
      }, tiempoEspera);
    });
  }

  function reproducirAudioCarta(carta, onFinalizado) {
    let finalizado = false;
    const ejecutarCallback = () => {
      if (!finalizado) {
        finalizado = true;
        onFinalizado();
      }
    };

    // 1. Probar MP3 de Fish Audio
    const audioMp3 = new Audio(`audios/${carta.num}.mp3`);
    audioActual = audioMp3;
    audioMp3.onended = ejecutarCallback;

    audioMp3.play().catch(() => {
      // 2. Probar WAV local (es-MX)
      const audioWav = new Audio(`audios/${carta.num}.wav`);
      audioActual = audioWav;
      audioWav.onended = ejecutarCallback;

      audioWav.play().catch(() => {
        // 3. Fallback nativo: SpeechSynthesis
        if ('speechSynthesis' in window) {
          window.speechSynthesis.cancel();
          const utterance = new SpeechSynthesisUtterance(`¡${carta.nombre}!`);
          utterance.lang = 'es-MX';
          utterance.rate = 1.0;
          utterance.onend = ejecutarCallback;
          utterance.onerror = ejecutarCallback;
          window.speechSynthesis.speak(utterance);
          setTimeout(ejecutarCallback, 1800);
        } else {
          setTimeout(ejecutarCallback, 1500);
        }
      });
    });
  }

  function iniciarPartida() {
    clearTimeout(temporizador);
    if (audioActual) audioActual.pause();
    if ('speechSynthesis' in window) window.speechSynthesis.cancel();

    limpiarResaltados();
    mazo = barajar(CARTAS);
    indiceActual = 0;
    enPartida = true;
    enPausa = false;

    btnIniciar.innerHTML = '<span>🔄</span> Reiniciar';
    btnPausar.classList.remove('d-none');
    btnPausar.textContent = '⏸ Pausar';
    btnDetener.classList.remove('d-none');

    animarMezcla();

    // Reproducir primero el intro con voz de Goku
    reproducirIntro(() => {
      if (enPartida && !enPausa) {
        cantarCarta(mazo[indiceActual], indiceActual, mazo.length);
      }
    });
  }

  function remezclarMazo() {
    animarMezcla();
    mazo = barajar(CARTAS);
    indiceActual = 0;
    limpiarResaltados();

    if (panelDisplay) {
      panelDisplay.classList.remove('d-none');
      elEstado.textContent = '¡Baraja remezclada con éxito!';
      elProgreso.textContent = 'Mazo listo';
      elNombre.textContent = 'CARTAS BARAJADAS';
      elSub.textContent = 'Presiona "Comenzar partida" para iniciar con el nuevo orden.';
    }
  }

  function pausarReanudarPartida() {
    if (!enPartida) return;

    if (enPausa) {
      enPausa = false;
      btnPausar.textContent = '⏸ Pausar';
      elEstado.textContent = 'Partida reanudada';
      if (!enIntro) {
        cantarCarta(mazo[indiceActual], indiceActual, mazo.length);
      }
    } else {
      enPausa = true;
      clearTimeout(temporizador);
      if (audioActual) audioActual.pause();
      if ('speechSynthesis' in window) window.speechSynthesis.cancel();
      btnPausar.textContent = '▶ Reanudar';
      elEstado.textContent = '⏸ Partida en pausa';
    }
  }

  function finalizarPartida() {
    enPartida = false;
    enPausa = false;
    clearTimeout(temporizador);

    elEstado.textContent = '🎉 ¡LOTERÍA! Se han cantado todas las 54 cartas.';
    elProgreso.textContent = '54 de 54 cantadas';

    document.querySelectorAll('.carta.cantando-ahora').forEach(el => {
      el.classList.remove('cantando-ahora');
      el.classList.add('ya-cantada');
    });

    btnIniciar.innerHTML = '<span id="icono-play">▶</span> Nueva partida';
    btnPausar.classList.add('d-none');
    btnDetener.classList.add('d-none');
  }

  function detenerPartida() {
    enPartida = false;
    enPausa = false;
    enIntro = false;
    clearTimeout(temporizador);
    if (audioActual) audioActual.pause();
    if ('speechSynthesis' in window) window.speechSynthesis.cancel();

    btnIniciar.innerHTML = '<span id="icono-play">▶</span> Comenzar partida';
    btnPausar.classList.add('d-none');
    btnDetener.classList.add('d-none');
    if (panelDisplay) panelDisplay.classList.add('d-none');

    limpiarResaltados();
  }

  // Control de narración por hover
  const chkAudioHover = document.getElementById('chk-audio-hover');
  let audioHover = null;
  let timerHover = null;

  function narrarCartaHover(num, nombre) {
    if (audioHover) {
      audioHover.pause();
      audioHover.currentTime = 0;
    }
    if ('speechSynthesis' in window) {
      window.speechSynthesis.cancel();
    }

    const wav = new Audio(`audios/${num}.wav`);
    audioHover = wav;

    wav.play().catch(() => {
      const mp3 = new Audio(`audios/${num}.mp3`);
      audioHover = mp3;
      mp3.play().catch(() => {
        if ('speechSynthesis' in window) {
          const utt = new SpeechSynthesisUtterance(`¡${nombre}!`);
          utt.lang = 'es-MX';
          utt.rate = 1.05;
          window.speechSynthesis.speak(utt);
        }
      });
    });
  }

  // Interacción táctil, clic y hover en la cuadrícula de cartas
  document.querySelectorAll('.carta').forEach(cartaEl => {
    cartaEl.style.cursor = 'pointer';

    // Narrar carta en voz alta al pasar el cursor
    cartaEl.addEventListener('mouseenter', () => {
      if (enPartida && !enPausa) return;
      if (chkAudioHover && !chkAudioHover.checked) return;

      clearTimeout(timerHover);
      timerHover = setTimeout(() => {
        const num = cartaEl.getAttribute('data-num');
        const nombre = cartaEl.querySelector('.carta-nombre')?.textContent || '';
        if (num) narrarCartaHover(num, nombre);
      }, 70); // Debounce ágil para fluidez sin saturar
    });

    cartaEl.addEventListener('mouseleave', () => {
      clearTimeout(timerHover);
    });

    // Clic para seleccionar e inspeccionar coordenadas
    cartaEl.addEventListener('click', () => {
      const fila = cartaEl.getAttribute('data-fila');
      const col = cartaEl.getAttribute('data-col');
      const num = cartaEl.getAttribute('data-num');
      const nombre = cartaEl.querySelector('.carta-nombre')?.textContent || '';
      const img = cartaEl.querySelector('img')?.getAttribute('src') || `img/cartas/${num}.jpg`;

      if (inputFila && fila) inputFila.value = fila;
      if (inputCol && col) inputCol.value = col;

      // Resaltar visualmente la carta seleccionada
      document.querySelectorAll('.carta').forEach(c => c.style.outline = '');
      cartaEl.style.outline = '3px solid var(--jade)';

      // Actualizar contenedor "Carta seleccionada" de forma instantánea
      if (contenedorEncontrada) {
        contenedorEncontrada.innerHTML = `
          <div class="encontrada-tile">
            <span class="carta-num grande">${num}</span>
            <img src="${img}" alt="${nombre}" class="img-fluid mt-2 mb-1" style="max-height: 120px;">
            <span class="encontrada-nombre">${nombre}</span>
          </div>
          <p class="small text-muted mb-0">Fila: ${fila} &nbsp; Columna: ${col}</p>
        `;
      }
    });
  });

  // Event Listeners
  btnIniciar.addEventListener('click', iniciarPartida);
  if (btnRemezclar) btnRemezclar.addEventListener('click', remezclarMazo);
  btnPausar.addEventListener('click', pausarReanudarPartida);
  btnDetener.addEventListener('click', detenerPartida);
});
