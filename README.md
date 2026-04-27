# dawe2026cicd2
Pràctica RA6 CICD intro

# index.html:
  Define la estructura de la pagina en tres secciones principales: una cabecera <header>)con el título y el badge "DAWe · RA6", un bloque principal <main> con un formulario para añadir tareas (campo de texto, selector de etiqueta y boton "Afegir") y dos listas separadas para tareas pendientes y completadas, y un pie de pagina <footer> con el nombre del módulo.

# style.css:
 Se organiza mediante variables CSS centralizadas en :root (colores, sombras, bordes, tipografía), lo que facilita cambiar el aspecto global modificando solo esa sección. A partir de ahí define estilos para la cabecera, las tarjetas de sección, el formulario, cada ítem de tarea (incluyendo el estado done con tachado y fondo verde) y un diseño responsive para pantallas pequeñas con @media (max-width: 600px).

# app.js:
 Aporta toda la lógica de la aplicación: carga y guarda las tareas en localStorage (para que persistan al recargar), renderiza dinámicamente los ítems en las dos listas (pendientes y completadas) actualizando los contadores del título, permite marcar/desmarcar tareas con un clic (función toggleTask), y gestiona el envío del formulario para añadir nuevas tareas con la etiqueta seleccionada.

### - Amina Latif