// Solo lo que PHP no resuelve en servidor:
// 1) activar tooltips de Bootstrap.
// 2) animación de reparto al cargar + animación al pulsar Mezclar.
document.addEventListener('DOMContentLoaded', () => {
  const els = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  els.forEach((el) => new bootstrap.Tooltip(el));

  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const tabla = document.getElementById('tabla-cartas');
  const marco = document.getElementById('tabla-marco');

  // Reparto en cascada la primera vez que carga la página.
  if (tabla && !reduce) {
    requestAnimationFrame(() => tabla.classList.add('reparto'));
  }

  // Al pulsar Mezclar: sacudida visible y luego navega a ?mezclar=1.
  const btn = document.getElementById('btn-mezclar');
  if (btn && marco && !reduce) {
    btn.addEventListener('click', (ev) => {
      ev.preventDefault();
      marco.classList.remove('mezclando');
      // Reinicia la animación para que se note cada vez.
      void marco.offsetWidth;
      marco.classList.add('mezclando');
      const url = btn.getAttribute('href');
      setTimeout(() => { window.location.href = url; }, 550);
    });
  }
});
