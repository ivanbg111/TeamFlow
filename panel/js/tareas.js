// panel/js/tareas.js
$(function(){
  // Añadir lista
  $('#add-list').click(function(){
    const nombre = prompt("Nombre de la lista:");
    if (!nombre) return;
    $.post('php/tasks.php', {
      action: 'add-list',
      proyecto_id: proyectoId,
      nombre
    }, res => location.reload());
  });

  // Renombrar lista al perder foco
  $('.list-header h5').on('blur', function(){
    const $l = $(this).closest('.list'),
          id = $l.data('id'),
          nombre = $(this).text().trim();
    $.post('php/tasks.php', {
      action: 'edit-list',
      id, nombre
    });
  });

  // Añadir tarjeta
// Añadir tarjeta
$('.add-card').click(function(){
  const lista_id = $(this).closest('.list').data('id');
  const titulo = prompt("Título de la tarjeta:");
  if (!titulo) return;
  console.log('Datos enviados:', { lista_id, titulo });  // Añade esta línea para depurar
  $.post('php/tasks.php', {
    action: 'add-card',
    lista_id, 
    titulo
  }, res => {
    console.log('Respuesta del servidor:', res);  // Verifica la respuesta del servidor
    location.reload();
  });
});


});
